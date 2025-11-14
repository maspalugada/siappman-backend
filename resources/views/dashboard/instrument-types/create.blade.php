@extends('layouts.app')

@section('title', 'Add New Instrument Type - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Add New Instrument Type</h1>
        <p style="color: var(--gray-600);">Create a new instrument type</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.instrument-types.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Type Name *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                    @error('name')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Create Type</button>
                    <a href="{{ route('dashboard.instrument-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
