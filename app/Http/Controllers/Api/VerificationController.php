<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\VerificationLog;
use App\Enums\VerificationStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($code): JsonResponse
    {
        $worker = Worker::where('verification_code', $code)
            ->where('verification_status', VerificationStatus::Approved->value)
            ->with(['department', 'office', 'lga'])
            ->first();

        if (!$worker) {
            return response()->json(['verified' => false, 'message' => 'No verified staff record found.'], 404);
        }

        return response()->json([
            'verified' => true,
            'worker' => $this->publicWorkerData($worker),
        ]);
    }

    public function qrVerify($hash): JsonResponse
    {
        $worker = Worker::where('verification_hash', $hash)
            ->where('verification_status', VerificationStatus::Approved->value)
            ->with(['department', 'office', 'lga'])
            ->first();

        if (!$worker) {
            return response()->json(['verified' => false, 'message' => 'Invalid QR code.'], 404);
        }

        return response()->json([
            'verified' => true,
            'worker' => $this->publicWorkerData($worker),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'required|in:staff_number,email,phone,national_id,verification_code,surname',
        ]);

        $worker = Worker::where('verification_status', VerificationStatus::Approved->value)
            ->where($request->type === 'surname' ? 'surname' : $request->type, 'like', "%{$request->query}%")
            ->with(['department', 'office', 'lga'])
            ->first();

        if (!$worker) {
            return response()->json(['found' => false, 'message' => 'No verified staff record found.'], 404);
        }

        return response()->json(['found' => true, 'worker' => $this->publicWorkerData($worker)]);
    }

    private function publicWorkerData(Worker $worker): array
    {
        return [
            'full_name' => $worker->full_name,
            'staff_number' => $worker->staff_number,
            'designation' => $worker->designation,
            'department' => $worker->department?->name,
            'office' => $worker->office?->name,
            'lga' => $worker->lga?->name,
            'employment_type' => $worker->employment_type,
            'status' => $worker->status,
            'verification_status' => $worker->verification_status,
            'verified_at' => $worker->verified_at,
            'id_expiry_date' => $worker->id_expiry_date,
        ];
    }
}
