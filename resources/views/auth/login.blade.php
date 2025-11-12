@extends('layouts.app')

@section('title', 'Login - SiAPPMan')

@section('content')
<div class="container" style="max-width: 400px; margin: 4rem auto;">
    <div class="card">
        <div class="card-header" style="text-align: center; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: var(--white);">
            <h1 style="margin: 0; font-size: 1.5rem;">Welcome Back</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Sign in to your account</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input">
                    @error('email')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required class="form-input">
                    @error('password')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="display: flex; align-items: center;">
                    <input id="remember" type="checkbox" name="remember" style="margin-right: 0.5rem;">
                    <label for="remember" style="margin: 0; font-size: 0.875rem; color: var(--gray-600);">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Sign In
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                <p style="margin: 0; color: var(--gray-600); font-size: 0.875rem;">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
