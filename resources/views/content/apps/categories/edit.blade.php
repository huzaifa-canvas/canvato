@extends('layouts/layoutMaster')

@section('title', 'Edit Category - Catalog Management')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Catalog / Categories /</span> Edit
</h4>

<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Edit: {{ $category->name }}</h5>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
  </div>
  <div class="card-body">
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div class="mb-3">
        <label class="form-label" for="name">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required />
      </div>

      <div class="mb-3">
        <label class="form-label" for="parent_id">Parent Category (Optional)</label>
        <select id="parent_id" class="form-select" name="parent_id">
          <option value="">-- None (Top Level) --</option>
          @foreach($parentCategories as $parent)
            <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
          @endforeach
        </select>
        <div class="form-text">Select a parent category if this is a sub-category.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" class="form-control" name="description">{{ $category->description }}</textarea>
      </div>

      <div class="mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $category->is_active ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">Active</label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
  </div>
</div>
@endsection
