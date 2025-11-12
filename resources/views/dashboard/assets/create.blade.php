@extends('layouts.app')

@section('title', 'Add New Asset - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Add New Asset</h1>
        <p style="color: var(--gray-600);">Create a new instrument or equipment asset</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.assets.store') }}">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Asset Name *</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                        @error('name')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="instrument_type" class="form-label">Instrument Type *</label>
                        <select id="instrument_type" name="instrument_type" class="form-input" required>
                            <option value="">Select Instrument Type</option>
                            @foreach($instrumentTypes as $type)
                                <option value="{{ $type }}" {{ old('instrument_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
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
                                <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                        @error('unit')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah" class="form-label">Jumlah *</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-input" value="{{ old('jumlah', 1) }}" min="1" required>
                        @error('jumlah')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Location *</label>
                        <select id="location" name="location" class="form-input" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ old('location') === $location ? 'selected' : '' }}>{{ $location }}</option>
                            @endforeach
                        </select>
                        @error('location')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="4" placeholder="Optional description of the asset">{{ old('description') }}</textarea>
                    @error('description')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Create Asset</button>
                    <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
