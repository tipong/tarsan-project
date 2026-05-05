@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Total Orders</p>
            <h2 class="text-3xl font-bold">0</h2>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Total Revenue</p>
            <h2 class="text-3xl font-bold">Rp 0</h2>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Total Rooms</p>
            <h2 class="text-3xl font-bold">0</h2>
        </div>

    </div>
@endsection
