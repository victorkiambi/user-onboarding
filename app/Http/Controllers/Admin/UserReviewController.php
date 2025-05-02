<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;
use App\Notifications\UserApproved;
use App\Notifications\UserRejected;

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
        $pendingUsers = $query->paginate(10)->withQueryString();
        return view('admin.dashboard', compact('pendingUsers', 'status', 'search'));
    }

    // Show details for a specific user
    public function show(User $user)
    {
        // Fetch audit logs for this user
        $auditLogs = \App\Models\AuditLog::where('user_id', $user->id)
            ->with('admin')
            ->orderByDesc('created_at')
            ->get();
        return view('admin.user_show', compact('user', 'auditLogs'));
    }

    // Approve a user
    public function approve(User $user)
    {
        $user->status = 'approved';
        $user->save();
        // Send approval notification
        $user->notify(new UserApproved());
        // Log action in audit_logs
        AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'action' => 'approved',
            'reason' => null,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'User approved.');
    }

    // Reject a user
    public function reject(Request $request, User $user)
    {
        $reason = $request->input('reason');
        $user->status = 'rejected';
        $user->save();
        // Send rejection notification
        $user->notify(new UserRejected($reason));
        // Log action in audit_logs
        AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'action' => 'rejected',
            'reason' => $reason,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'User rejected.');
    }
} 