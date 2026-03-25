<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Attendance;
use App\Models\Student;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
         $recentDays = collect([2, 1, 0])->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo)->toDateString();
            return [
                'date'  => $date,
                'count' => Attendance::whereDate('date', $date)->count(),
            ];
        });

        $totalDays = Attendance::distinct('date')->count('date');

        $students = Student::where('user_id', Auth::id())
                           ->withCount('attendances')
                           ->get();


        return view('auth.login',compact('recentDays', 'students', 'totalDays'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        activity()
            ->causedBy(Auth::user())
            ->event('login')
            ->log('User logged in');

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        activity()
            ->causedBy($user)
            ->event('logout')
            ->log('User logged out');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
