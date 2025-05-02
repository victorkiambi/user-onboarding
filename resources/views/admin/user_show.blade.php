@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="container mx-auto py-12 px-4 md:px-8">
    <h1 class="text-3xl font-bold mb-10 text-gray-800">Review User: {{ $user->name }}</h1>
    <div class="bg-white shadow-lg rounded-2xl p-10 mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <div class="mb-6 text-lg"><span class="font-semibold text-gray-700">Name:</span> {{ $user->name }}</div>
                <div class="mb-6 text-lg"><span class="font-semibold text-gray-700">Email:</span> {{ $user->email }}</div>
                <div class="mb-6 text-lg"><span class="font-semibold text-gray-700">Phone:</span> {{ $user->phone }}</div>
                <div class="mb-6 text-lg"><span class="font-semibold text-gray-700">Address:</span> {{ $user->address }}</div>
                <div class="mb-6 text-lg"><span class="font-semibold text-gray-700">Status:</span> <span class="inline-block px-3 py-1 rounded bg-yellow-100 text-yellow-800 text-sm uppercase tracking-wide">{{ $user->status }}</span></div>
            </div>
            <div class="flex flex-col space-y-8">
                <div><span class="font-semibold text-gray-700">Profile Photo:</span><br>
                    @if($user->profile_photo)
                        <img src="{{ Str::startsWith($user->profile_photo, 'http') ? $user->profile_photo : asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-40 h-40 object-cover rounded border mt-2">
                    @else
                        <span class="text-gray-500">No photo uploaded.</span>
                    @endif
                </div>
                <div><span class="font-semibold text-gray-700">ID Front:</span><br>
                    @if($user->id_front)
                        <img src="{{ Str::startsWith($user->id_front, 'http') ? $user->id_front : asset('storage/' . $user->id_front) }}" alt="ID Front" class="w-60 h-auto border rounded mt-2">
                    @else
                        <span class="text-gray-500">No ID front uploaded.</span>
                    @endif
                </div>
                <div><span class="font-semibold text-gray-700">ID Back:</span><br>
                    @if($user->id_back)
                        <img src="{{ Str::startsWith($user->id_back, 'http') ? $user->id_back : asset('storage/' . $user->id_back) }}" alt="ID Back" class="w-60 h-auto border rounded mt-2">
                    @else
                        <span class="text-gray-500">No ID back uploaded.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded-xl p-8 mb-12">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Audit Log</h2>
        @if($auditLogs->isEmpty())
            <div class="text-gray-500">No admin actions recorded for this user.</div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($auditLogs as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-semibold capitalize">{{ $log->action }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $log->admin ? $log->admin->name : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $log->reason ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $log->created_at ? $log->created_at->format('Y-m-d H:i') : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <!-- Action Buttons -->
    <div class="flex flex-col md:flex-row md:justify-center md:space-x-8 space-y-4 md:space-y-0 mt-8">
        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="flex-shrink-0">
            @csrf
            <button type="submit" class="w-full md:w-auto bg-green-600 text-white px-8 py-3 rounded shadow hover:bg-green-700 transition font-semibold flex items-center justify-center text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Approve
            </button>
        </form>
        <!-- Reject Button triggers modal -->
        <button type="button" onclick="document.getElementById('reject-modal').classList.remove('hidden')" class="w-full md:w-auto bg-red-600 text-white px-8 py-3 rounded shadow hover:bg-red-700 transition font-semibold flex items-center justify-center text-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            Reject
        </button>
        <a href="{{ route('admin.dashboard') }}" class="w-full md:w-auto text-gray-600 hover:underline flex items-center justify-center px-8 py-3 border border-gray-300 rounded shadow bg-white text-lg">Back to Dashboard</a>
    </div>
    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
            <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h3 class="text-xl font-bold mb-4 text-gray-800">Reject User</h3>
            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                @csrf
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason (optional)</label>
                <textarea name="reason" id="reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 focus:outline-none focus:ring-2 focus:ring-red-200" placeholder="Enter reason for rejection (optional)"></textarea>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="px-6 py-2 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-6 py-2 rounded bg-red-600 text-white font-semibold hover:bg-red-700">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 