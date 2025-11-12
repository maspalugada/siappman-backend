@extends('layouts.app')

@section('title', 'Asset Management - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <a href="{{ route('dashboard') }}" style="color: var(--primary-color); text-decoration: none; font-size: 1.125rem;">← Back to Dashboard</a>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Asset Management</h1>
                <p style="color: var(--gray-600);">Manage your assets and equipment</p>
            </div>
        <a href="{{ route('dashboard.assets.create') }}" class="btn btn-primary">
            <span style="margin-right: 0.5rem;">+</span>
            Add Asset
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="text-align: center; color: var(--gray-500); padding: 3rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">No Assets Yet</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Add your first asset to start tracking</p>
                <a href="{{ route('dashboard.assets.create') }}" class="btn btn-primary">Add Your First Asset</a>
            </div>
        </div>
    </div>
</div>
@endsection
