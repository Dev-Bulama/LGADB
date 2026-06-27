<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $worker = $request->user()->worker?->load(['department', 'unit', 'office', 'lga', 'state']);
        if (!$worker) {
            return response()->json(['message' => 'No worker profile found.'], 404);
        }
        return response()->json(['worker' => $worker]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $worker = $request->user()->worker;
        if (!$worker) {
            return response()->json(['message' => 'No worker profile found.'], 404);
        }

        $validated = $request->validate([
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'residential_address' => 'nullable|string',
            'next_of_kin_name' => 'nullable|string',
            'next_of_kin_phone' => 'nullable|string',
        ]);

        $worker->update($validated);
        return response()->json(['message' => 'Profile updated.', 'worker' => $worker]);
    }

    public function documents(Request $request): JsonResponse
    {
        $worker = $request->user()->worker;
        $documents = $worker ? $worker->documents : [];
        return response()->json(['documents' => $documents]);
    }

    public function history(Request $request): JsonResponse
    {
        $worker = $request->user()->worker;
        $histories = $worker ? $worker->employmentHistories()->latest()->get() : [];
        return response()->json(['histories' => $histories]);
    }

    public function notifications(Request $request): JsonResponse
    {
        $notifications = $request->user()->notifications()->paginate(20);
        return response()->json(['notifications' => $notifications]);
    }

    public function idCard(Request $request): JsonResponse
    {
        $worker = $request->user()->worker;
        if (!$worker || $worker->verification_status->value !== 'approved') {
            return response()->json(['message' => 'ID card not available.'], 403);
        }
        return response()->json([
            'worker' => $worker->only(['full_name', 'staff_number', 'designation', 'verification_code']),
            'download_url' => route('portal.id-card.download'),
        ]);
    }
}
