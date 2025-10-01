@extends('layouts.admin_dashboard')

@section('content')
<div class="container">

    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="buttons">
        <h4>Opportunities</h4>
        <a href="{{ route('admin.web.opportunities.create') }}" class="btn btn-primary">Add New</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Summary</th>
                <th>Overlay Intro</th>
                <th>Overlay Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($opportunities as $opportunity)
                <tr>
                    <td><img src="{{ asset('/public/storage/opportunities/' . $opportunity->image) }}" width="80" style="border-radius: 0.5rem;"></td>
                    <td>{{ $opportunity->title }}</td>
                    <td>{{ $opportunity->summary }}</td>
                    <td>{{ $opportunity->overlay_intro }}</td>
                    <td>{{ $opportunity->overlay_details }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.web.opportunities.edit', $opportunity->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('admin.web.opportunities.destroy', $opportunity->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
