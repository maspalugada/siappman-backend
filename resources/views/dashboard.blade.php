@extends('layouts.app')

@section('title', 'Dashboard - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Dashboard</h1>
        <p style="color: var(--gray-600);">Welcome back, {{ Auth::user()->name }}!</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- QR Codes Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">📱</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">QR Codes</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">Manage QR codes</p>
                    </div>
                </div>
                <a href="{{ route('dashboard.qr-codes') }}" class="btn btn-primary" style="width: 100%;">Manage QR Codes</a>
            </div>
        </div>

        <!-- Assets Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">📦</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">Assets</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">Manage instruments & equipment</p>
                    </div>
                </div>
                <a href="{{ route('dashboard.assets.index') }}" class="btn btn-primary" style="width: 100%;">Manage Assets</a>
            </div>
        </div>

        <!-- Scan History Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">📊</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">Scan History</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">View scan activities</p>
                    </div>
                </div>
                <a href="{{ route('dashboard.scan-history') }}" class="btn btn-primary" style="width: 100%;">View History</a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">👤</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">Profile</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">Manage your account</p>
                    </div>
                </div>
                <a href="{{ route('dashboard.profile') }}" class="btn btn-primary" style="width: 100%;">Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('scanner') }}" class="btn btn-primary">
                    <span style="margin-right: 0.5rem;">📱</span>
                    Start Scanning
                </a>
                <a href="{{ route('dashboard.assets.create') }}" class="btn btn-secondary">
                    <span style="margin-right: 0.5rem;">+</span>
                    Add New Asset
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
