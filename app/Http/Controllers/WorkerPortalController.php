<?php
namespace App\Http\Controllers;

use App\Models\Worker;
use App\Services\IdCardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerPortalController extends Controller
{
    public function dashboard()
    {
        $user   = Auth::user();
        $worker = $user->worker;
        return view('portal.dashboard', compact('user', 'worker'));
    }

    public function profile()
    {
        $user   = Auth::user();
        $worker = $user->worker;
        return view('portal.profile', compact('user', 'worker'));
    }

    public function updateProfile(Request $request)
    {
        $user   = Auth::user();
        $worker = $user->worker;

        if ($worker) {
            $validated = $request->validate([
                'phone'                    => 'nullable|string',
                'whatsapp'                 => 'nullable|string',
                'residential_address'      => 'nullable|string',
                'next_of_kin_name'         => 'nullable|string',
                'next_of_kin_phone'        => 'nullable|string',
                'next_of_kin_relationship' => 'nullable|string',
                'next_of_kin_address'      => 'nullable|string',
                'emergency_contact_name'   => 'nullable|string',
                'emergency_contact_phone'  => 'nullable|string',
            ]);
            $worker->update($validated);
        }

        return redirect()->route('portal.profile')->with('success', 'Profile updated successfully.');
    }

    public function idCard()
    {
        $user   = Auth::user();
        $worker = $user->worker;
        return view('portal.id-card', compact('worker'));
    }

    public function downloadIdCard()
    {
        $user   = Auth::user();
        $worker = $user->worker;

        if (!$worker || $worker->verification_status->value !== 'approved') {
            return redirect()->route('portal.id-card')
                ->with('error', 'ID Card not available. Your verification is pending.');
        }

        $service = new IdCardService();
        return $service->download($worker);
    }

    public function documents()
    {
        $user      = Auth::user();
        $worker    = $user->worker;
        $documents = $worker ? $worker->documents : collect();
        return view('portal.documents', compact('worker', 'documents'));
    }

    public function notifications()
    {
        $user          = Auth::user();
        $notifications = $user->notifications()->paginate(20);
        return view('portal.notifications', compact('notifications'));
    }

    public function history()
    {
        $user      = Auth::user();
        $worker    = $user->worker;
        $histories = $worker ? $worker->employmentHistories()->latest()->get() : collect();
        return view('portal.history', compact('worker', 'histories'));
    }
}
