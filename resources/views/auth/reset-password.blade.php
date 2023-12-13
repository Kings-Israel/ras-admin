@extends('layouts.auth.app')
@section('auth')
<div class="card-plain">
    <div class="header">
        <h5>Reset Password</h5>
    </div>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-2">
            <label for="password" class="">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-2">
            <label for="password_confirmation" class="">Confirm Password</label>

            <input id="password_confirmation" class="form-control"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" class="" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="footer">
            <button type="submit" class="btn btn-primary btn-round btn-block">Submit</button>
        </div>
    </form>
</div>
@endsection
