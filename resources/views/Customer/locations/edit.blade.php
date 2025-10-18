@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Edit Location</h2>

    <form method="POST" action="{{ route('user.applicant.locations.update', $location->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Select from existing:</label>
            <select name="location_id" class="form-control">
                <option value="">-- Choose --</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}" {{ $location->location_id == $loc->id ? 'selected' : '' }}>
                        {{ $loc->province }} - {{ $loc->city }}
                    </option>
                @endforeach
            </select>
        </div>

        <p>OR enter a new location:</p>

        <div class="mb-3">
            <label>Province</label>
            <input type="text" name="new_province" class="form-control" placeholder="e.g. Western Province">
        </div>

        <div class="mb-3">
            <label>City</label>
            <input type="text" name="new_city" class="form-control" placeholder="e.g. Mongu">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('user.applicant.locations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
