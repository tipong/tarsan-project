@extends('resepsionis.layouts.app')

@section('title', 'Dashboard Resepsionis')

@section('content')
<h1 class="text-xl font-semibold mb-6">Dashboard Resepsionis</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Upcoming Check-in</p>
        <p class="text-2xl font-bold">{{ $upcoming }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Ongoing Stay</p>
        <p class="text-2xl font-bold">{{ $ongoing }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Check-in Hari Ini</p>
        <p class="text-2xl font-bold">{{ $todayCheckin }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Check-out Hari Ini</p>
        <p class="text-2xl font-bold">{{ $todayCheckout }}</p>
    </div>

</div>
@endsection
