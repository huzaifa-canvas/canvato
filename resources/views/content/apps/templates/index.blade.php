@extends('layouts/layoutMaster')

@section('title', ($currentType ?? 'All') . ' Templates')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.js'
])
@endsection

@section('page-script')
<script type="module">
  document.addEventListener('DOMContentLoaded', function () {
    const flatpickrRange = document.querySelector('#flatpickr-range');
    if (flatpickrRange) {
      window.flatpickr(flatpickrRange, {
        mode: 'range',
        dateFormat: 'Y-m-d'
      });
    }
  });
</script>
@endsection

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

@if(session('error'))
<div class="alert alert-danger alert-dismissible mb-4">
  {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible mb-4">
  <ul class="mb-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
  <div class="card-header border-bottom">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <h5 class="mb-0">{{ $currentType ?? 'All Templates' }} <span class="badge bg-label-primary ms-2">{{ $templates->total() }}</span></h5>
      
      <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3">
        <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2 m-0">
          @if(request('type'))
            <input type="hidden" name="type" value="{{ request('type') }}">
          @endif
          <input type="text" name="search" class="form-control form-control-sm" style="min-width: 180px;" placeholder="Search Title..." value="{{ request('search') }}">
          <input type="text" name="date_range" id="flatpickr-range" class="form-control form-control-sm" style="min-width: 200px;" placeholder="Date Range" value="{{ request('date_range') }}">
          <button type="submit" class="btn btn-primary btn-sm text-nowrap">Filter</button>
        </form>

        @can('create products')
        <button type="button" class="btn btn-label-secondary btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
          <i class="icon-base ti tabler-upload me-1"></i> Bulk Upload
        </button>
        <a href="{{ route('templates.create', $currentType ? ['type' => $currentType] : []) }}" class="btn btn-primary btn-sm text-nowrap">
          <i class="icon-base ti tabler-plus me-1"></i> Add {{ $currentType ?? 'Template' }}
        </a>
        @endcan
      </div>
    </div>
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
              @can('edit products')
              <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-icon btn-text-primary btn-sm" title="Edit">
                <i class="icon-base ti tabler-edit icon-md"></i>
              </a>
              @endcan
              @can('create products')
              <form action="{{ route('templates.duplicate', $template->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-icon btn-text-secondary btn-sm" title="Duplicate">
                  <i class="icon-base ti tabler-copy icon-md"></i>
                </button>
              </form>
              @endcan
              @can('delete products')
              <form action="{{ route('templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-icon btn-text-danger btn-sm" title="Delete">
                  <i class="icon-base ti tabler-trash icon-md"></i>
                </button>
              </form>
              @endcan
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
  @if($templates->hasPages())
  <div class="card-footer d-flex justify-content-end border-top">
    {{ $templates->links() }}
  </div>
  @endif
</div>

{{-- Bulk Upload Modal --}}
@can('create products')
<div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bulk Upload Templates</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('templates.bulk-upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="bulk_type" value="{{ $currentType }}">
        <div class="modal-body">
          <div class="alert alert-info d-flex align-items-start gap-2 mb-4">
            <i class="icon-base ti tabler-info-circle mt-1"></i>
            <div>
              <strong>Instructions:</strong>
              <ul class="mb-0 mt-1 ps-3" style="font-size: 13px;">
                <li>Upload a <strong>.csv</strong> file with template data.</li>
                <li>First row must be column headers.</li>
                <li>Only <strong>title</strong> column is required.</li>
                <li>Duplicate titles will be <strong>skipped</strong> automatically.</li>
                @if($currentType)
                <li>All records will be set to type: <strong>{{ $currentType }}</strong>.</li>
                @else
                <li>Type will not be set (upload from a specific type page to auto-assign).</li>
                @endif
                <li>Download the sample file to see the expected format.</li>
              </ul>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="csv_file">Select CSV File</label>
            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
          </div>
          <a href="{{ route('templates.download-sample') }}" class="btn btn-outline-primary btn-sm">
            <i class="icon-base ti tabler-download me-1"></i> Download Sample CSV
          </a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="icon-base ti tabler-upload me-1"></i> Upload & Import
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endcan
@endsection
