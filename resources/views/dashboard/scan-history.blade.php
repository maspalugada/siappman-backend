@extends('layouts.app')

@section('title', 'Scan History - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Scan History</h1>
        <p style="color: var(--gray-600);">View all your scan activities</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="text-align: center; color: var(--gray-500); padding: 3rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">No Scan History</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Your scan activities will appear here</p>
                <a href="{{ route('scanner') }}" class="btn btn-primary">Start Scanning</a>
            </div>
        </div>
    </div>
</div>
@endsection
