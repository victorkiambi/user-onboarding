@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Profile</h2>
        @if(session('status'))
            <div class="mb-4 p-4 rounded bg-green-100 border-l-4 border-green-500 text-green-800">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('user.profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name" class="block font-semibold text-gray-700 mb-2">Name</label>
                <input id="name" name="name" type="text" class="block w-full border-gray-300 rounded" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block font-semibold text-gray-700 mb-2">Email</label>
                <input id="email" name="email" type="email" class="block w-full border-gray-300 rounded" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block font-semibold text-gray-700 mb-2">Phone</label>
                <input id="phone" name="phone" type="text" class="block w-full border-gray-300 rounded" value="{{ old('phone', $user->phone) }}" required autocomplete="tel">
                @error('phone')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-6">
                <label for="address" class="block font-semibold text-gray-700 mb-2">Address</label>
                <input id="address" name="address" type="text" class="block w-full border-gray-300 rounded" value="{{ old('address', $user->address) }}" required autocomplete="street-address">
                @error('address')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="flex justify-end">
                <a href="{{ route('user.dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded shadow font-semibold hover:bg-gray-300 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition font-semibold">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection 