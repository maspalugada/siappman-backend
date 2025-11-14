@extends('layouts.app')

@section('title', 'Instrument Types - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Instrument Types</h1>
            <p style="color: var(--gray-600);">Manage your instrument types</p>
        </div>
        <a href="{{ route('dashboard.instrument-types.create') }}" class="btn btn-primary">Add New Type</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instrumentTypes as $type)
                            <tr>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('dashboard.instrument-types.edit', $type) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('dashboard.instrument-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
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
                                    <p style="color: var(--gray-600);">No instrument types found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $instrumentTypes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
