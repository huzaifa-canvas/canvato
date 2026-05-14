@extends('layouts/layoutMaster')

@section('title', 'Edit User - Apps')

@section('content')

{{-- Success/Error Messages --}}
@if(session('success'))
  <div class="alert alert-success alert-dismissible mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if($errors->any())
  <div class="alert alert-danger alert-dismissible mb-4" role="alert">
    @foreach($errors->all() as $error)
      <p class="mb-0">{{ $error }}</p>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row">
  {{-- User Info Card --}}
  <div class="col-xl-4 col-lg-5 col-md-5">
    <div class="card mb-6">
      <div class="card-body text-center">
        <div class="avatar avatar-xl mx-auto mb-4">
          <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle" />
        </div>
        <h4 class="mb-1">{{ $user->name }}</h4>
        <span class="badge bg-label-primary mb-3">
          {{ $user->roles->pluck('name')->join(', ') ?: 'No Role' }}
        </span>
        <div class="d-flex justify-content-center gap-4 mt-3">
          <div>
            <h5 class="mb-0">{{ $user->roles->count() }}</h5>
            <span class="text-muted">Roles</span>
          </div>
          <div>
            <h5 class="mb-0">{{ $user->permissions->count() }}</h5>
            <span class="text-muted">Permissions</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Form --}}
  <div class="col-xl-8 col-lg-7 col-md-7">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Edit User</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('app-user-update', $user->id) }}">
          @csrf
          @method('PUT')
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label" for="name">Full Name</label>
              <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
            </div>
            <div class="col-md-6">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
            </div>
            <div class="col-md-6">
              <label class="form-label" for="role">Role</label>
              <select id="role" name="role" class="form-select">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                  <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="password">New Password <small class="text-muted">(leave blank to keep current)</small></label>
              <input type="password" id="password" name="password" class="form-control" placeholder="············" />
            </div>
          </div>
          <div class="mt-6">
            <button type="submit" class="btn btn-primary me-3">Save Changes</button>
            <a href="{{ route('app-user-list') }}" class="btn btn-label-secondary">Back to List</a>
          </div>
        </form>
      </div>
    </div>

    {{-- User's Permissions --}}
    <div class="card mt-6">
      <div class="card-header">
        <h5 class="card-title mb-0">User Permissions</h5>
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
          @forelse($user->getAllPermissions() as $perm)
            <span class="badge bg-label-info">{{ ucwords($perm->name) }}</span>
          @empty
            <span class="text-muted">No permissions assigned.</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
