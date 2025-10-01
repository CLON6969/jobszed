@php
    $isEdit = $document && $document->exists;

    // Get sections from old input if exists, else from model relation (eager loaded)
    $sections = old('sections', $isEdit ? $document->sections->toArray() : []);
@endphp

@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h1>{{ $isEdit ? 'Edit Legal Document' : 'Create Legal Document' }}</h1>

    <form action="{{ $isEdit ? route('admin.web.legal.update', $document->id) : route('admin.web.legal.store') }}" method="POST">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        {{-- Document fields --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title *</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $document->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug *</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $document->slug ?? '') }}" required>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active', $document->is_active ?? false) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active</label>
        </div>

        <hr>

        {{-- Sections --}}
        <h3>Sections</h3>
        <div id="sections-wrapper">
            @foreach($sections as $sIndex => $section)
                <div class="card mb-3 section-card" data-index="{{ $sIndex }}">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger btn-sm float-end" onclick="removeSection(this)">Remove Section</button>

                        <input type="hidden" name="sections[{{ $sIndex }}][id]" value="{{ $section['id'] ?? '' }}">

                        <div class="mb-3">
                            <label>Heading *</label>
                            <input type="text" name="sections[{{ $sIndex }}][heading]" class="form-control" value="{{ $section['heading'] ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Body</label>
                            <textarea name="sections[{{ $sIndex }}][body]" class="form-control">{{ $section['body'] ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Order</label>
                            <input type="number" name="sections[{{ $sIndex }}][order]" class="form-control" value="{{ $section['order'] ?? 0 }}">
                        </div>

                        {{-- List Items --}}
                        <h5>List Items</h5>
                        <div class="list-items-wrapper">
                            @php
                                // Grab list items from old input or fallback to the section array
                                $listItems = old("sections.$sIndex.list_items", $section['list_items'] ?? []);
                            @endphp

                            @foreach($listItems as $lIndex => $item)
                                <div class="input-group mb-2" data-index="{{ $lIndex }}">
                                    <input type="hidden" name="sections[{{ $sIndex }}][list_items][{{ $lIndex }}][id]" value="{{ $item['id'] ?? '' }}">
                                    <input type="text" name="sections[{{ $sIndex }}][list_items][{{ $lIndex }}][item_text]" class="form-control" value="{{ $item['item_text'] ?? '' }}" required>
                                    <input type="number" name="sections[{{ $sIndex }}][list_items][{{ $lIndex }}][order]" class="form-control" style="max-width: 100px;" value="{{ $item['order'] ?? 0 }}" placeholder="Order">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeListItem(this)">×</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addListItem(this)">+ Add List Item</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addSection()">+ Add Section</button>

        <button type="submit" class="btn btn-success">Save Document</button>
    </form>
</div>

{{-- JavaScript for dynamic add/remove --}}
<script>
    let sectionIndex = {{ count($sections) }};

    function addSection() {
        const wrapper = document.getElementById('sections-wrapper');
        const html = `
            <div class="card mb-3 section-card" data-index="${sectionIndex}">
                <div class="card-body">
                    <button type="button" class="btn btn-danger btn-sm float-end" onclick="removeSection(this)">Remove Section</button>
                    <input type="hidden" name="sections[${sectionIndex}][id]" value="">
                    <div class="mb-3">
                        <label>Heading *</label>
                        <input type="text" name="sections[${sectionIndex}][heading]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Body</label>
                        <textarea name="sections[${sectionIndex}][body]" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Order</label>
                        <input type="number" name="sections[${sectionIndex}][order]" class="form-control" value="0">
                    </div>

                    <h5>List Items</h5>
                    <div class="list-items-wrapper"></div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addListItem(this)">+ Add List Item</button>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        sectionIndex++;
    }

    function removeSection(button) {
        button.closest('.section-card').remove();
    }

    function addListItem(button) {
        const sectionCard = button.closest('.section-card');
        const sectionIndex = sectionCard.dataset.index;
        const wrapper = sectionCard.querySelector('.list-items-wrapper');
        const itemCount = wrapper.querySelectorAll('.input-group').length;

        const html = `
            <div class="input-group mb-2" data-index="${itemCount}">
                <input type="hidden" name="sections[${sectionIndex}][list_items][${itemCount}][id]" value="">
                <input type="text" name="sections[${sectionIndex}][list_items][${itemCount}][item_text]" class="form-control" placeholder="List item text" required>
                <input type="number" name="sections[${sectionIndex}][list_items][${itemCount}][order]" class="form-control" style="max-width: 100px;" placeholder="Order" value="0">
                <button type="button" class="btn btn-outline-danger" onclick="removeListItem(this)">×</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
    }

    function removeListItem(button) {
        button.closest('.input-group').remove();
    }
</script>
@endsection
