@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Pending Users</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif
    <form method="GET" action="" class="mb-8 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="Name, email, or phone"
                   class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" class="w-full md:w-40 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="all" @if(($status ?? 'pending') === 'all') selected @endif>All</option>
                <option value="pending" @if(($status ?? 'pending') === 'pending') selected @endif>Pending</option>
                <option value="approved" @if(($status ?? 'pending') === 'approved') selected @endif>Approved</option>
                <option value="rejected" @if(($status ?? 'pending') === 'rejected') selected @endif>Rejected</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition font-semibold mt-2 md:mt-0">Filter</button>
        </div>
    </form>
    @if($pendingUsers->isEmpty())
        <div class="text-center text-gray-500 py-12">No users found.</div>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingUsers as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $user->profile_photo }}" alt="Profile Photo" class="w-12 h-12 rounded-full object-cover border">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-semibold">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $user->phone ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $user->address ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs uppercase tracking-wide">{{ ucfirst($user->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition font-semibold">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $pendingUsers->links() }}
        </div>
    @endif
</div>
@endsection 