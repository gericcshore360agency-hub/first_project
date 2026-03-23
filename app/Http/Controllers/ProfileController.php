<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{      

// Display a listing of the users. (FOR ADMIN)
    public function index()

    {
        $users = User::paginate(10); // or ->get()

        return view('user_management.user_manage', compact('users'));
    }


// Show the form for creating a new user. (FOR ADMIN)
    public function add_users()
    {
        $roles = Role::all(); 

        return view('user_management.add_user', compact('roles'));
    }


// Store a newly created user in storage. (FOR ADMIN)
    public function create_users(){
          
    $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
    ]);

    $user = User::create([
            'name'=> $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

    $user->syncRoles($data['roles']);

    return redirect()->route('show_users')->with('success','User created successfully.');
}


// Show the form for editing the specified user (FOR ADMIN).
    public function edit_users($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('user_management.edit_user', compact('user', 'roles'));
    }

// Update the specified user in storage (FOR ADMIN).
    public function update_user(Request $request, $id){

        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        $user->syncRoles($data['roles']);

        return redirect()->route('show_users')->with('success', 'User updated successfully.');
    }

// DELETE the specified user from storage (FOR ADMIN).
    public function delete_user($id)
    {
       $user = User::findOrFail($id);

    if ($user->id === auth()->id()) {
        return redirect()->back()->with('error', 'You cannot delete your own account.');
    }

    $user->delete();

    return redirect()->route('show_users')->with('success', 'User deleted successfully.');
    }








/////////////////////////////////////////DEFAULT ROUTES////////////////////////////////////////////////////////////////////////////////


    // Show the form for editing the specified user.
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Update the user's profile information.
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
