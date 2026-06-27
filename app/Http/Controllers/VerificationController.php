<?php
namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\VerificationLog;
use App\Enums\VerificationStatus;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('public.verify.index');
    }

    /**
     * Auto-detect the search type from the query string format.
     */
    public static function detectType(string $query): string
    {
        $q = trim($query);

        // Staff number: LGA/YYYY/NNNNN
        if (preg_match('/^[A-Z]{2,5}\/\d{4}\/\d{4,6}$/i', $q)) {
            return 'staff_number';
        }

        // Verification code: exactly 10 uppercase alphanum chars
        if (preg_match('/^[A-Z0-9]{10}$/', strtoupper($q)) && !str_contains($q, ' ')) {
            return 'verification_code';
        }

        // Email address
        if (filter_var($q, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        // Phone: starts with 0 or +, digits only with optional +, spaces, dashes
        if (preg_match('/^[\+]?[\d\s\-]{7,15}$/', $q)) {
            return 'phone';
        }

        // National ID (NIN): 11 digit number
        if (preg_match('/^\d{11}$/', $q)) {
            return 'national_id';
        }

        // Single word → surname search
        if (!str_contains($q, ' ')) {
            return 'surname';
        }

        // Multiple words → full name
        return 'full_name';
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2|max:200',
            'type'  => 'nullable|in:staff_number,email,phone,national_id,verification_code,surname,full_name',
        ]);

        $query = trim($request->input('query'));
        $type  = $request->input('type') ?: static::detectType($query);

        $dbQuery = Worker::where('verification_status', VerificationStatus::Approved->value)
            ->with(['department', 'office', 'unit', 'lga', 'state']);

        $worker = match ($type) {
            'staff_number'      => $dbQuery->whereRaw('LOWER(staff_number) = ?', [strtolower($query)])->first(),
            'email'             => $dbQuery->whereRaw('LOWER(email) = ?', [strtolower($query)])->first(),
            'phone'             => $dbQuery->where('phone', $query)->first(),
            'national_id'       => $dbQuery->where('national_id', $query)->first(),
            'verification_code' => $dbQuery->whereRaw('UPPER(verification_code) = ?', [strtoupper($query)])->first(),
            'surname'           => $dbQuery->whereRaw('LOWER(surname) LIKE ?', ['%' . strtolower($query) . '%'])->first(),
            'full_name'         => $dbQuery->where(function ($q) use ($query) {
                $lq = strtolower($query);
                $q->whereRaw("LOWER(CONCAT(surname, ' ', first_name)) LIKE ?", ["%{$lq}%"])
                  ->orWhereRaw("LOWER(CONCAT(first_name, ' ', surname)) LIKE ?", ["%{$lq}%"])
                  ->orWhereRaw("LOWER(CONCAT(first_name, ' ', COALESCE(middle_name,''), ' ', surname)) LIKE ?", ["%{$lq}%"]);
            })->first(),
            default => null,
        };

        VerificationLog::create([
            'worker_id'    => $worker?->id,
            'search_query' => $query,
            'search_type'  => $type,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'result_found' => $worker !== null,
        ]);

        return view('public.verify.result', compact('worker', 'query', 'type'));
    }

    public function show($code)
    {
        $worker = Worker::where('verification_code', $code)
            ->where('verification_status', VerificationStatus::Approved->value)
            ->with(['department', 'office', 'unit', 'lga', 'state'])
            ->firstOrFail();

        return view('public.verify.show', compact('worker'));
    }

    public function qrScan($hash)
    {
        $worker = Worker::where('verification_hash', $hash)
            ->where('verification_status', VerificationStatus::Approved->value)
            ->with(['department', 'office', 'unit', 'lga', 'state'])
            ->first();

        return view('public.verify.qr-result', compact('worker', 'hash'));
    }
}
