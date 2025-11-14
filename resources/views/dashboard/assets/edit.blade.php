@extends('layouts.app')

@section('title', 'Edit Asset - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Edit Asset</h1>
        <p style="color: var(--gray-600);">Update asset information</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.assets.update', $asset) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Asset Name *</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $asset->name) }}" required>
                        @error('name')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="instrument_type" class="form-label">Instrument Type *</label>
                        <select id="instrument_type" name="instrument_type" class="form-input" required>
                            <option value="">Select Instrument Type</option>
                            @foreach($instrumentTypes as $type)
                                <option value="{{ $type->name }}" {{ old('instrument_type', $asset->instrument_type) === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('instrument_type')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit" class="form-label">Unit *</label>
                        <select id="unit" name="unit" class="form-input" required>
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->name }}" {{ old('unit', $asset->unit) === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('unit')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah" class="form-label">Jumlah *</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-input" value="{{ old('jumlah', $asset->jumlah) }}" min="1" required>
                        @error('jumlah')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Location *</label>
                        <select id="location" name="location" class="form-input" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}" {{ old('location', $asset->location) === $location->name ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error('location')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="active" {{ old('status', $asset->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $asset->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="maintenance" {{ old('status', $asset->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="4">{{ old('description', $asset->description) }}</textarea>
                    @error('description')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Update Asset</button>
                    <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
