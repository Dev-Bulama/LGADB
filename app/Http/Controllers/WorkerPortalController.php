<?php
namespace App\Http\Controllers;

use App\Enums\VerificationStatus;
use App\Models\WorkerDocument;
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
                'phone'                    => 'nullable|string|max:20',
                'whatsapp'                 => 'nullable|string|max:20',
                'residential_address'      => 'nullable|string|max:500',
                'next_of_kin_name'         => 'nullable|string|max:150',
                'next_of_kin_phone'        => 'nullable|string|max:20',
                'next_of_kin_relationship' => 'nullable|string|max:100',
                'next_of_kin_address'      => 'nullable|string|max:500',
                'emergency_contact_name'   => 'nullable|string|max:150',
                'emergency_contact_phone'  => 'nullable|string|max:20',
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

        if (!$worker || $worker->verification_status !== VerificationStatus::Approved) {
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
        $documents = $worker ? $worker->documents()->latest()->get() : collect();
        return view('portal.documents', compact('worker', 'documents'));
    }

    public function downloadDocument(WorkerDocument $document)
    {
        $worker = Auth::user()->worker;

        if (!$worker || $document->worker_id !== $worker->id) {
            abort(403);
        }

        $path = storage_path('app/public/' . $document->file_path);
        if (!file_exists($path)) {
            return back()->with('error', 'Document file not found.');
        }

        return response()->download($path, $document->name ?? basename($document->file_path));
    }

    public function notifications()
    {
        $user          = Auth::user();
        $notifications = $user->notifications()->paginate(20);
        return view('portal.notifications', compact('notifications'));
    }

    public function markNotificationRead(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllNotificationsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    public function history()
    {
        $user      = Auth::user();
        $worker    = $user->worker;
        $histories = $worker ? $worker->employmentHistories()->latest()->paginate(15) : collect();
        return view('portal.history', compact('worker', 'histories'));
    }
}
