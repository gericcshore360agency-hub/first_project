<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class HistoryController extends Controller
{
public function index()
    {
        $activities = Activity::with('causer')->latest()->paginate(15);

        $deletedUsers = User::onlyTrashed()->latest('deleted_at')->get();

        return view('history', compact('activities', 'deletedUsers'));
    }

public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return redirect()->back()->with('success', 'User restored successfully.');
    }
}