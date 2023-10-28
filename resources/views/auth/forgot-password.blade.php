{{-- <x-guest-layout>
</x-guest-layout> --}}
@extends('layouts.auth.app')
@section('auth')
<div class="card-plain">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Enter Email to get new password.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary btn-round btn-block">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
    <a href="{{ route('login') }}" class="link">Login</a>
</div>
@endsection
