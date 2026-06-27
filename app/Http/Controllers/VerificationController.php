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

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type'  => 'required|in:staff_number,email,phone,national_id,verification_code,surname,full_name',
        ]);

        $query = $request->input('query');
        $type  = $request->input('type');

        $dbQuery = Worker::where('verification_status', VerificationStatus::Approved->value)
            ->with(['department', 'office', 'unit', 'lga', 'state']);

        $worker = match ($type) {
            'staff_number'      => $dbQuery->where('staff_number', $query)->first(),
            'email'             => $dbQuery->where('email', $query)->first(),
            'phone'             => $dbQuery->where('phone', $query)->first(),
            'national_id'       => $dbQuery->where('national_id', $query)->first(),
            'verification_code' => $dbQuery->where('verification_code', $query)->first(),
            'surname'           => $dbQuery->where('surname', 'like', "%{$query}%")->first(),
            'full_name'         => $dbQuery->where(function ($q) use ($query) {
                $q->whereRaw("CONCAT(surname, ' ', first_name) LIKE ?", ["%{$query}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', surname) LIKE ?", ["%{$query}%"]);
            })->first(),
            default => null,
        };

        // Log the search attempt
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
