@extends('layouts.app')

@section('title', 'Edit Unit - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Edit Unit</h1>
        <p style="color: var(--gray-600);">Update unit information</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.units.update', $unit) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Unit Name *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $unit->name) }}" required>
                    @error('name')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Update Unit</button>
                    <a href="{{ route('dashboard.units.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
