@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="container mx-auto py-12 px-4 md:px-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Documents</h2>
        @if(session('status'))
            <div class="mb-4 p-4 rounded bg-green-100 border-l-4 border-green-500 text-green-800">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('profile.documents.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Current Profile Photo:</label>
                @if($user->profile_photo)
                    <img src="{{ Str::startsWith($user->profile_photo, 'http') ? $user->profile_photo : asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-32 h-32 object-cover rounded border mb-2">
                @else
                    <span class="text-gray-500">No photo uploaded.</span>
                @endif
                <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg" class="block mt-2 border-gray-300 rounded">
                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Current ID Front:</label>
                @if($user->id_front)
                    <img src="{{ Str::startsWith($user->id_front, 'http') ? $user->id_front : asset('storage/' . $user->id_front) }}" alt="ID Front" class="w-48 h-auto border rounded mb-2">
                @else
                    <span class="text-gray-500">No ID front uploaded.</span>
                @endif
                <input type="file" name="id_front" accept="image/jpeg,image/png,image/jpg" class="block mt-2 border-gray-300 rounded">
                <x-input-error :messages="$errors->get('id_front')" class="mt-2" />
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Current ID Back:</label>
                @if($user->id_back)
                    <img src="{{ Str::startsWith($user->id_back, 'http') ? $user->id_back : asset('storage/' . $user->id_back) }}" alt="ID Back" class="w-48 h-auto border rounded mb-2">
                @else
                    <span class="text-gray-500">No ID back uploaded.</span>
                @endif
                <input type="file" name="id_back" accept="image/jpeg,image/png,image/jpg" class="block mt-2 border-gray-300 rounded">
                <x-input-error :messages="$errors->get('id_back')" class="mt-2" />
            </div>
            <div class="flex justify-end">
                <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('user.dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded shadow font-semibold hover:bg-gray-300 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition font-semibold">Update Documents</button>
            </div>
        </form>
    </div>
</div>
@endsection 