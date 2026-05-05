@extends('tamu.layouts.edit')

@section('content')

{{-- HEADER --}}
@section('header')
<div class="flex items-center gap-3">
    <a href="{{ route('tamu.dashboard') }}"
       class="font-semibold text-xl text-gray-800 hover:text-gray-900">
        ←
    </a>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Profile
    </h2>
</div>
@endsection

{{-- CONTENT --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection
