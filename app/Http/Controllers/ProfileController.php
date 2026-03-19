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

class ProfileController extends Controller
{        
    // Display a listing of the users. (FOR ADMIN)
    public function index()

    {
        $users = User::paginate(10); // or ->get()

        return view('user_manage', compact('users'));
    }

    // Show the form for creating a new user. (FOR ADMIN)
    public function add_users()
    {
        $roles = Role::all(); 

        return view('add_user', compact('roles'));
    }

        // Show the form for editing the specified user (FOR ADMIN).
        public function edit_users($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('edit_user', compact('user', 'roles'));
    }

        public function create_users(){
          
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        

    }








///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
