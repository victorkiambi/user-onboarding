<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserReviewController extends Controller
{
    // List all pending users
    public function index(Request $request)
    {
        $query = User::query();
        // Filter by status (default: pending)
        $status = $request->input('status', 'pending');
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        // Search by name, email, or phone
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%") ;
            });
        }
        $pendingUsers = $query->get();
        return view('admin.dashboard', compact('pendingUsers', 'status', 'search'));
    }

    // Show details for a specific user
    public function show(User $user)
    {
        // TODO: Add authorization if needed
        return view('admin.user_show', compact('user'));
    }

    // Approve a user
    public function approve(User $user)
    {
        $user->status = 'approved';
        $user->save();
        // TODO: Send approval notification to user
        // TODO: Log action in audit_logs
        return redirect()->route('admin.dashboard')->with('success', 'User approved.');
    }

    // Reject a user
    public function reject(User $user)
    {
        $user->status = 'rejected';
        $user->save();
        // TODO: Send rejection notification to user
        // TODO: Log action in audit_logs
        return redirect()->route('admin.dashboard')->with('success', 'User rejected.');
    }
} 