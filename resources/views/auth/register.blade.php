@extends('layouts.app')

@section('title', 'Register - SiAPPMan')

@section('content')
<div class="container" style="max-width: 400px; margin: 4rem auto;">
    <div class="card">
        <div class="card-header" style="text-align: center; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: var(--white);">
            <h1 style="margin: 0; font-size: 1.5rem;">Create Account</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Join SiAPPMan today</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="form-input">
                    @error('name')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input">
                    @error('email')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" required class="form-input">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('role')
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

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input">
                    @error('password_confirmation')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Create Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                <p style="margin: 0; color: var(--gray-600); font-size: 0.875rem;">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
