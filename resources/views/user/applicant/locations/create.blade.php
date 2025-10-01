@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Add Location</h2>

    <form method="POST" action="{{ route('user.applicant.locations.store') }}">
        @csrf

        <div class="mb-3">
            <label>Select from existing:</label>
            <select name="location_id" class="form-control">
                <option value="">-- Choose --</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->province }} - {{ $loc->city }}</option>
                @endforeach
            </select>
        </div>

        <p>OR enter a new location:</p>

        <div class="mb-3">
            <label>Province</label>
            <input type="text" name="new_province" class="form-control">
        </div>

        <div class="mb-3">
            <label>City</label>
            <input type="text" name="new_city" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('user.applicant.locations.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
