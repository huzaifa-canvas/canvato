@extends('layouts/layoutMaster')

@section('title', 'User List - Apps')

@section('content')

{{-- Success/Error Messages --}}
@if(session('success'))
  <div class="alert alert-success alert-dismissible mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if(session('error'))
  <div class="alert alert-danger alert-dismissible mb-4" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<h4 class="mb-1">User List</h4>
<p class="mb-6">Manage all users and their roles from here.</p>

{{-- Role Stats Cards --}}
<div class="row g-6 mb-6">
  <div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="mb-1 text-nowrap">{{ $totalUsers }}</h3>
            <p class="mb-0">Total Users</p>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="icon-base ti tabler-users icon-lg"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @foreach($roles->take(3) as $role)
  <div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="mb-1 text-nowrap">{{ $role->users_count }}</h3>
            <p class="mb-0">{{ $role->name }}</p>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-{{ ['primary', 'success', 'warning', 'info', 'danger'][rand(0,4)] }}">
              <i class="icon-base ti tabler-user-shield icon-lg"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Filters + Table --}}
<div class="card">
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-4">
    <h5 class="mb-0">Users</h5>
    <div class="d-flex gap-3 align-items-center">
      {{-- Role Filter --}}
      <form method="GET" action="{{ route('app-user-list') }}" id="roleFilterForm">
        <select name="role" class="form-select" onchange="document.getElementById('roleFilterForm').submit()">
          <option value="">All Roles</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $selectedRole == $role->name ? 'selected' : '' }}>
              {{ $role->name }} ({{ $role->users_count }})
            </option>
          @endforeach
        </select>
      </form>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Email</th>
          <th>Role</th>
          <th>Joined</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $index => $user)
        <tr>
          <td>{{ $users->firstItem() + $index }}</td>
          <td>
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm me-3">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle" />
              </div>
              <span class="fw-medium">{{ $user->name }}</span>
            </div>
          </td>
          <td>{{ $user->email }}</td>
          <td>
            @foreach($user->roles as $userRole)
              <span class="badge bg-label-primary me-1">{{ $userRole->name }}</span>
            @endforeach
            @if($user->roles->isEmpty())
              <span class="badge bg-label-secondary">No Role</span>
            @endif
          </td>
          <td>{{ $user->created_at->format('d M Y') }}</td>
          <td>
            <div class="d-flex gap-1">
              <a href="{{ route('app-user-edit', $user->id) }}" class="btn btn-icon btn-text-primary btn-sm">
                <i class="icon-base ti tabler-edit icon-md"></i>
              </a>
              @if($user->id !== auth()->id())
              <form action="{{ route('app-user-delete', $user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-icon btn-text-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                  <i class="icon-base ti tabler-trash icon-md"></i>
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($users->hasPages())
  <div class="card-footer d-flex justify-content-center">
    {{ $users->appends(['role' => $selectedRole])->links() }}
  </div>
  @endif
</div>
@endsection
