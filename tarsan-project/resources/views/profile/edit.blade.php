@extends('layouts.tamu-inner')
@section('title', 'Edit Profile – Tarsan Homestay')
@section('page-tag', 'Account')
@section('page-title', 'Edit Profile')
@section('page-sub', 'Manage your account information and security')

@push('styles')
<style>
.profile-wrap{max-width:800px;margin:0 auto}
.profile-box{background:#fff;border:1px solid rgba(0,0,0,.07);padding:40px;margin-bottom:24px}
.profile-box header h2{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:8px;display:flex;align-items:center;gap:8px}
.profile-box header p{font-size:13px;color:#888}
.profile-box label{font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;margin-bottom:8px;display:block}
.profile-box input[type="text"], .profile-box input[type="email"], .profile-box input[type="password"]{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:12px 16px;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .3s;border-radius:0}
.profile-box input:focus{border-color:#6b5c47}
.profile-box .btn-save{padding:12px 24px;background:#1a1a1a;color:#fff;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;border:none;cursor:pointer;transition:background .3s}
.profile-box .btn-save:hover{background:#333}
.profile-box .btn-danger{padding:12px 24px;background:transparent;color:#dc2626;border:1px solid #dc2626;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;transition:all .3s}
.profile-box .btn-danger:hover{background:#dc2626;color:#fff}
</style>
@endpush

@section('inner-content')
<div class="breadcrumb" style="max-width:800px;margin:0 auto 24px;font-size:12px">
    <a href="{{ route('tamu.dashboard') }}" style="color:#6b5c47;text-decoration:none">← Back to Dashboard</a>
</div>

<div class="profile-wrap">
    <div class="profile-box">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="profile-box">
        @include('profile.partials.update-password-form')
    </div>

    <div class="profile-box" style="border-color:rgba(220,38,38,0.2)">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
