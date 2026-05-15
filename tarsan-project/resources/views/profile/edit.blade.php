@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('tamu.dashboard') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition duration-200 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600 mt-1">Manage your account information here</p>
        </div>

        <div class="space-y-6">
            {{-- Profile Information --}}
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div class="bg-white p-6 rounded-lg shadow-sm border border-red-200">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
