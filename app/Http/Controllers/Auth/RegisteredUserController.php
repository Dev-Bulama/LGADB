<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lga;
use App\Models\State;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register', [
            'states'      => State::orderBy('name')->get(),
            'lgas'        => Lga::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'surname'         => 'required|string|max:100',
            'first_name'      => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'gender'          => 'required|in:male,female,other',
            'date_of_birth'   => 'required|date|before:-16 years',
            'phone'           => 'required|string|max:20',
            'email'           => 'required|email|max:255|unique:users,email|unique:workers,email',
            'state_id'        => 'required|exists:states,id',
            'lga_id'          => 'required|exists:lgas,id',
            'department_id'   => 'required|exists:departments,id',
            'designation'     => 'required|string|max:150',
            'employment_type' => 'required|in:permanent,contract,temporary,casual',
            'password'        => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::create([
            'name'      => trim("{$request->surname} {$request->first_name}"),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_type' => RoleType::Worker,
            'is_active' => true,
        ]);

        $user->assignRole('worker');

        Worker::create([
            'user_id'         => $user->id,
            'surname'         => $request->surname,
            'first_name'      => $request->first_name,
            'middle_name'     => $request->middle_name,
            'gender'          => $request->gender,
            'date_of_birth'   => $request->date_of_birth,
            'phone'           => $request->phone,
            'email'           => $request->email,
            'state_id'        => $request->state_id,
            'lga_id'          => $request->lga_id,
            'department_id'   => $request->department_id,
            'designation'     => $request->designation,
            'employment_type' => $request->employment_type,
        ]);

        // Notify HR admins about new registration
        $hrAdmins = User::where('role_type', RoleType::HrOfficer->value)->get();
        foreach ($hrAdmins as $admin) {
            if ($admin->email) {
                $admin->notify(new \App\Notifications\WorkerRegisteredNotification($user->worker));
            }
        }

        Auth::login($user);

        return redirect()->route('portal.dashboard')->with('success', 'Registration successful! Your record has been submitted for verification.');
    }
}
