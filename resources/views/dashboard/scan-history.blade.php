@extends('layouts.app')

@section('title', 'Scan History - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Scan History</h1>
        <p style="color: var(--gray-600);">View all your scan activities</p>
    </div>

    @if($scanActivities->count() > 0)
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Scanned Item</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Type</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Action</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Scanned By</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Location</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Scanned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scanActivities as $activity)
                                <tr style="border-bottom: 1px solid var(--gray-100);">
                                    <td style="padding: 1rem; color: var(--gray-900); font-weight: 500;">
                                        @if($activity->scannable)
                                            <a href="{{ $activity->scannable instanceof \App\Models\Asset ? route('dashboard.assets.show', $activity->scannable) : route('dashboard.instrument-sets.show', $activity->scannable) }}" style="color: var(--primary-color); text-decoration: none;">
                                                {{ $activity->scannable->name }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; color: var(--gray-600);">
                                        @if($activity->scannable)
                                            {{ $activity->scannable instanceof \App\Models\Asset ? 'Asset' : 'Instrument Set' }}
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $activity->action }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $activity->user->name ?? 'N/A' }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $activity->location ?? 'N/A' }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $activity->scanned_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($scanActivities->hasPages())
                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $scanActivities->links() }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">No Scan History</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Your scan activities will appear here</p>
                <a href="{{ route('scanner') }}" class="btn btn-primary">Start Scanning</a>
            </div>
        </div>
    @endif
</div>
@endsection
