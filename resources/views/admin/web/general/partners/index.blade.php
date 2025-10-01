@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Partners</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.web.general.partners.create') }}" class="btn btn-primary mb-3">Add New Partner</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Icon</th>
                <th>Name</th>
                <th>URL</th>
                <th>Sort Order</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partners as $partner)
                <tr>
                    <td><i class="{{ $partner->icon }}"></i></td>
                    <td>{{ $partner->name }}</td>
                    <td><a href="{{ $partner->name_url }}" target="_blank">Visit</a></td>
                    <td>{{ $partner->sort_order }}</td>
                    <td>{{ $partner->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.web.general.partners.edit', $partner->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.web.general.partners.destroy', $partner->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection