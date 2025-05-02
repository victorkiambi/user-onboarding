@extends('layouts.app')

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
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-40 h-40 object-cover rounded border mt-2">
                    @else
                        <span class="text-gray-500">No photo uploaded.</span>
                    @endif
                </div>
                <div><span class="font-semibold text-gray-700">ID Front:</span><br>
                    @if($user->id_front)
                        <img src="{{ asset('storage/' . $user->id_front) }}" alt="ID Front" class="w-60 h-auto border rounded mt-2">
                    @else
                        <span class="text-gray-500">No ID front uploaded.</span>
                    @endif
                </div>
                <div><span class="font-semibold text-gray-700">ID Back:</span><br>
                    @if($user->id_back)
                        <img src="{{ asset('storage/' . $user->id_back) }}" alt="ID Back" class="w-60 h-auto border rounded mt-2">
                    @else
                        <span class="text-gray-500">No ID back uploaded.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row md:space-x-6 space-y-4 md:space-y-0">
        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
            @csrf
            <button type="submit" class="w-full md:w-auto bg-green-600 text-white px-8 py-3 rounded shadow hover:bg-green-700 transition font-semibold flex items-center justify-center text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Approve
            </button>
        </form>
        <form method="POST" action="{{ route('admin.users.reject', $user) }}">
            @csrf
            <button type="submit" class="w-full md:w-auto bg-red-600 text-white px-8 py-3 rounded shadow hover:bg-red-700 transition font-semibold flex items-center justify-center text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                Reject
            </button>
        </form>
        <a href="{{ route('admin.dashboard') }}" class="w-full md:w-auto text-gray-600 hover:underline flex items-center justify-center px-8 py-3 border border-gray-300 rounded shadow bg-white text-lg">Back to Dashboard</a>
    </div>
</div>
@endsection 