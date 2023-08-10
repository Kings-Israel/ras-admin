{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
@extends('layouts.auth.app')
@section('auth')
    <div class="card-plain">
        <div class="header">
            <h5>Sign Up</h5>
            <span>Register a new membership</span>
        </div>
        <form class="form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter User Name">
                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter Email">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" class="form-control" />
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
            </div>
            <div class="checkbox">
                <input id="terms" type="checkbox">
                <label for="terms">I read and Agree to the <a href="javascript:void(0);">Terms of Usage</a></label>
            </div>
        </form>
        <div class="footer">
            <a href="index.html" class="btn btn-primary btn-round btn-block">SIGN UP</a>
        </div>
        <a class="link" href="{{ route('login') }}">You already have a membership?</a>
    </div>
@endsection
