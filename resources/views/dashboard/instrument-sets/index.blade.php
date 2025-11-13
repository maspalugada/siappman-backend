@extends('layouts.app')

@section('title', 'Instrument Sets - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Instrument Sets</h1>
            <p style="color: var(--gray-600);">Manage your instrument sets and bundles</p>
        </div>
        <a href="{{ route('dashboard.instrument-sets.create') }}" class="btn btn-primary">
            <span style="margin-right: 0.5rem;">+</span>
            Add New Set
        </a>
    </div>

    @if($instrumentSets->count() > 0)
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Set Name</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Description</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Number of Assets</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Status</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instrumentSets as $set)
                                <tr style="border-bottom: 1px solid var(--gray-100);">
                                    <td style="padding: 1rem; color: var(--gray-900); font-weight: 500;">{{ $set->name }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ Str::limit($set->description, 50) }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $set->assets_count }}</td>
                                    <td style="padding: 1rem;">
                                        @php
                                            $statusClass = '';
                                            switch ($set->status) {
                                                case 'Ready':
                                                    $statusClass = 'background-color: #D1FAE5; color: #065F46;';
                                                    break;
                                                case 'Washing':
                                                case 'Sterilizing':
                                                    $statusClass = 'background-color: #DBEAFE; color: #1E40AF;';
                                                    break;
                                                case 'In Use':
                                                    $statusClass = 'background-color: #E5E7EB; color: #374151;';
                                                    break;
                                                case 'Maintenance':
                                                    $statusClass = 'background-color: #FEF3C7; color: #92400E;';
                                                    break;
                                            }
                                        @endphp
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; {{ $statusClass }}">
                                            {{ $set->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('dashboard.instrument-sets.show', $set) }}" class="btn btn-secondary">View</a>
                                            <a href="{{ route('dashboard.instrument-sets.edit', $set) }}" class="btn btn-secondary">Edit</a>
                                            <form method="POST" action="{{ route('dashboard.instrument-sets.destroy', $set) }}" onsubmit="return confirm('Are you sure you want to delete this set?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($instrumentSets->hasPages())
                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $instrumentSets->links() }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600;">No Instrument Sets Found</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Get started by creating your first instrument set.</p>
                <a href="{{ route('dashboard.instrument-sets.create') }}" class="btn btn-primary">Create Instrument Set</a>
            </div>
        </div>
    @endif
</div>
@endsection
