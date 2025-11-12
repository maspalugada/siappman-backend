@extends('layouts.app')

@section('title', 'Profile - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Profile</h1>
        <p style="color: var(--gray-600);">Manage your account information</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Account Information</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.profile.update') }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ auth()->user()->name }}" required class="form-input">
                        @error('name')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ auth()->user()->email }}" required class="form-input">
                        @error('email')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" value="{{ ucfirst(auth()->user()->role) }}" readonly class="form-input" style="background-color: var(--gray-100);">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Member Since</label>
                        <input type="text" value="{{ auth()->user()->created_at->format('M d, Y') }}" readonly class="form-input" style="background-color: var(--gray-100);">
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Change Password</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.profile.password') }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" type="password" name="current_password" required class="form-input">
                        @error('current_password')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" type="password" name="password" required class="form-input">
                        @error('password')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input">
                        @error('password_confirmation')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
