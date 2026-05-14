@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Dashboard /</span> Overview
</h4>

<div class="row">
  <!-- Users Card -->
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-primary">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-users"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{ $stats['users'] }}</h4>
        </div>
        <p class="mb-1">Total Users</p>
        <p class="mb-0">
          <span class="fw-medium me-1">Registered accounts</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Templates Card -->
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-success">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-layout-grid"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{ $stats['templates'] }}</h4>
        </div>
        <p class="mb-1">Total Templates</p>
        <p class="mb-0">
          <span class="fw-medium me-1 text-success">{{ $stats['active_templates'] }} Active</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Categories Card -->
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-info">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-info"><i class="icon-base ti tabler-category"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{ $stats['categories'] }}</h4>
        </div>
        <p class="mb-1">Categories</p>
        <p class="mb-0">
          <span class="fw-medium me-1">Template classifications</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Earnings/Downloads Card -->
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-warning">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-download"></i></span>
          </div>
          <h4 class="ms-1 mb-0">---</h4>
        </div>
        <p class="mb-1">Total Downloads</p>
        <p class="mb-0">
          <span class="fw-medium me-1">Coming soon</span>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Recent Templates -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recently Added Templates</h5>
        <a href="{{ route('templates.index') }}" class="btn btn-sm btn-primary">View All</a>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Title</th>
              <th>Type</th>
              <th>Price</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @forelse($recentTemplates as $template)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  @if($template->main_thumbnail)
                    <img src="{{ asset('storage/' . $template->main_thumbnail) }}" alt="Avatar" class="rounded me-3" width="30" height="30" style="object-fit:cover;">
                  @else
                    <div class="avatar me-3">
                      <span class="avatar-initial rounded bg-label-secondary"><i class="icon-base ti tabler-photo"></i></span>
                    </div>
                  @endif
                  <strong>{{ $template->title }}</strong>
                </div>
              </td>
              <td><span class="badge bg-label-info">{{ $template->type ?? 'N/A' }}</span></td>
              <td>
                @if($template->isFree())
                  <span class="badge bg-success">FREE</span>
                @else
                  ${{ number_format($template->price, 2) }}
                @endif
              </td>
              <td>
                @if($template->is_active)
                  <span class="badge bg-label-success">Active</span>
                @else
                  <span class="badge bg-label-danger">Inactive</span>
                @endif
              </td>
              <td>{{ $template->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">No templates added yet.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
