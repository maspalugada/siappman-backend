@extends('layouts.app')

@section('title', 'Welcome to SiAPPMan')

@section('content')
<div class="container">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; font-weight: 700; color: var(--gray-900); margin-bottom: 1rem;">Welcome to SiAPPMan</h1>
        <p style="font-size: 1.25rem; color: var(--gray-600); max-width: 600px; margin: 0 auto;">QR Code Scanner and Management System for efficient asset tracking and activity monitoring</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--white); font-size: 2rem; font-weight: 700;">
                    📱
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">QR Code Scanning</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Scan QR codes instantly with your mobile device or webcam for real-time activity tracking</p>
                <a href="{{ route('scanner') }}" class="btn btn-primary">Start Scanning</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, var(--success), #34D399); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--white); font-size: 2rem; font-weight: 700;">
                    📊
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Activity Monitoring</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Track and monitor all scan activities with detailed logs and analytics</p>
                <a href="{{ route('login') }}" class="btn btn-primary">View Dashboard</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, var(--warning), #FBBF24); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--white); font-size: 2rem; font-weight: 700;">
                    ⚙️
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Asset Management</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Manage QR codes for assets, locations, and equipment efficiently</p>
                <a href="{{ route('login') }}" class="btn btn-primary">Manage Assets</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Get Started</h2>
            <p style="color: var(--gray-600); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">Join SiAPPMan today to streamline your asset tracking and activity monitoring processes</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endsection
