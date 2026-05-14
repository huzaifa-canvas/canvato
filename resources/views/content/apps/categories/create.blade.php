@extends('layouts/layoutMaster')

@section('title', 'Add Category - Catalog Management')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Catalog / Categories /</span> Add Category
</h4>

<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">New Category</h5>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
  </div>
  <div class="card-body">
    <form action="{{ route('categories.store') }}" method="POST">
      @csrf
      
      <div class="mb-3">
        <label class="form-label" for="name">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="e.g. WordPress, PSDs" required />
      </div>

      <div class="mb-3">
        <label class="form-label" for="parent_id">Parent Category (Optional)</label>
        <select id="parent_id" class="form-select" name="parent_id">
          <option value="">-- None (Top Level) --</option>
          @foreach($parentCategories as $parent)
            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
          @endforeach
        </select>
        <div class="form-text">Select a parent category if this is a sub-category (e.g. Themes under WordPress).</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" class="form-control" name="description" placeholder="Optional description"></textarea>
      </div>

      <div class="mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
          <label class="form-check-label" for="is_active">Active</label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Save Category</button>
    </form>
  </div>
</div>
@endsection
