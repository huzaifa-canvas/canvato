@extends('layouts/layoutMaster')

@section('title', ($currentType ?? 'All') . ' Templates')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Design Templates /</span> {{ $currentType ?? 'All Templates' }}
</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible mb-4">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ $currentType ?? 'All Templates' }} <span class="badge bg-label-primary ms-2">{{ $templates->count() }}</span></h5>
    <a href="{{ route('templates.create', $currentType ? ['type' => $currentType] : []) }}" class="btn btn-primary">
      <i class="icon-base ti tabler-plus me-1"></i> Add {{ $currentType ?? 'Template' }}
    </a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Thumbnail</th>
          <th>Title</th>
          @if(!$currentType)
          <th>Type</th>
          @endif
          <th>Categories</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($templates as $template)
        <tr>
          <td>
            @php $mainThumb = $template->main_thumbnail; @endphp
            @if($mainThumb)
              <img src="{{ asset('storage/' . $mainThumb) }}" alt="Thumbnail" width="50" height="50" class="rounded" style="object-fit:cover;">
            @else
              <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                <i class="icon-base ti tabler-photo text-muted"></i>
              </div>
            @endif
          </td>
          <td><strong>{{ $template->title }}</strong></td>
          @if(!$currentType)
          <td>
            @if($template->type)
              <span class="badge bg-label-info">{{ $template->type }}</span>
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          @endif
          <td>
            @if($template->categories->count())
              @foreach($template->categories as $cat)
                <span class="badge bg-label-secondary me-1">{{ $cat->name }}</span>
              @endforeach
            @else
              <span class="text-muted">N/A</span>
            @endif
          </td>
          <td>
            @if($template->isFree())
              <span class="badge bg-success">FREE</span>
            @else
              <span class="fw-bold">${{ number_format($template->price, 2) }}</span>
            @endif
          </td>
          <td>
            @if($template->is_active)
              <span class="badge bg-label-success">Active</span>
            @else
              <span class="badge bg-label-danger">Inactive</span>
            @endif
          </td>
          <td>
            <div class="d-flex gap-1">
              <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-icon btn-text-primary btn-sm" title="Edit">
                <i class="icon-base ti tabler-edit icon-md"></i>
              </a>
              <form action="{{ route('templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-icon btn-text-danger btn-sm" title="Delete">
                  <i class="icon-base ti tabler-trash icon-md"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="{{ $currentType ? 6 : 7 }}" class="text-center py-4">
              No {{ $currentType ?? '' }} templates found. 
              <a href="{{ route('templates.create', $currentType ? ['type' => $currentType] : []) }}">Create your first!</a>
            </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
