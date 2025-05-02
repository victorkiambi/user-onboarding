@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
            <h3 class="text-2xl font-bold mb-6 text-gray-800">Profile Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <div class="mb-4 text-lg"><span class="font-semibold text-gray-700">Name:</span> {{ Auth::user()->name }}</div>
                    <div class="mb-4 text-lg"><span class="font-semibold text-gray-700">Email:</span> {{ Auth::user()->email }}</div>
                    <div class="mb-4 text-lg"><span class="font-semibold text-gray-700">Phone:</span> {{ Auth::user()->phone }}</div>
                    <div class="mb-4 text-lg"><span class="font-semibold text-gray-700">Address:</span> {{ Auth::user()->address }}</div>
                    <div class="mb-4 text-lg"><span class="font-semibold text-gray-700">Status:</span> <span class="inline-block px-3 py-1 rounded bg-yellow-100 text-yellow-800 text-sm uppercase tracking-wide">{{ Auth::user()->status }}</span></div>
                </div>
                <div class="flex flex-col space-y-6">
                    <div><span class="font-semibold text-gray-700">Profile Photo:</span><br>
                        @if(Auth::user()->profile_photo)
                            <img src="{{ Str::startsWith(Auth::user()->profile_photo, 'http') ? Auth::user()->profile_photo : asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="w-32 h-32 object-cover rounded border mt-2">
                        @else
                            <span class="text-gray-500">No photo uploaded.</span>
                        @endif
                    </div>
                    <div><span class="font-semibold text-gray-700">ID Front:</span><br>
                        @if(Auth::user()->id_front)
                            <img src="{{ Str::startsWith(Auth::user()->id_front, 'http') ? Auth::user()->id_front : asset('storage/' . Auth::user()->id_front) }}" alt="ID Front" class="w-48 h-auto border rounded mt-2">
                        @else
                            <span class="text-gray-500">No ID front uploaded.</span>
                        @endif
                    </div>
                    <div><span class="font-semibold text-gray-700">ID Back:</span><br>
                        @if(Auth::user()->id_back)
                            <img src="{{ Str::startsWith(Auth::user()->id_back, 'http') ? Auth::user()->id_back : asset('storage/' . Auth::user()->id_back) }}" alt="ID Back" class="w-48 h-auto border rounded mt-2">
                        @else
                            <span class="text-gray-500">No ID back uploaded.</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex space-x-4 mt-4">
                <a href="{{ route('user.profile.edit') }}" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition font-semibold">Edit Profile</a>
                <a href="{{ route('profile.documents.edit') }}" class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700 transition font-semibold">Edit Documents</a>
            </div>
        </div>
    </div>
</div>
@endsection 