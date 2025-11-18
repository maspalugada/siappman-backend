@extends('layouts.app')

@section('title', 'Locations - SiAPPMan')

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Locations</h1>
            <p style="color: var(--gray-600);">Manage your locations</p>
        </div>
        <a href="{{ route('dashboard.locations.create') }}" class="btn btn-primary">Add New Location</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($locations as $location)
                            <tr>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('dashboard.locations.edit', $location) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('dashboard.locations.destroy', $location) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 2rem;">
                                    <p style="color: var(--gray-600);">No locations found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $locations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
