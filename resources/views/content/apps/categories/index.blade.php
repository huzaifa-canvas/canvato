@extends('layouts/layoutMaster')

@section('title', 'Categories - Catalog Management')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Catalog /</span> Categories
</h4>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">All Categories</h5>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Parent Category</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($categories as $category)
        <tr>
          <td><strong>{{ $category->name }}</strong></td>
          <td>{{ $category->parent ? $category->parent->name : 'None (Top Level)' }}</td>
          <td>
            @if($category->is_active)
              <span class="badge bg-label-success me-1">Active</span>
            @else
              <span class="badge bg-label-danger me-1">Inactive</span>
            @endif
          </td>
          <td>
            <div class="d-flex gap-1">
              <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-icon btn-text-primary btn-sm">
                <i class="icon-base ti tabler-edit icon-md"></i>
              </a>
              <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-icon btn-text-danger btn-sm">
                  <i class="icon-base ti tabler-trash icon-md"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No categories found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
