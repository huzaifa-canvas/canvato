@extends('layouts/layoutMaster')

@section('title', 'Permission - Apps')

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

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Permissions List</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
      <i class="icon-base ti tabler-plus me-1"></i> Add Permission
    </button>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Guard</th>
          <th>Assigned To</th>
          <th>Created Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($permissions as $index => $permission)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td><span class="fw-medium">{{ ucwords($permission->name) }}</span></td>
          <td><span class="badge bg-label-info">{{ $permission->guard_name }}</span></td>
          <td>
            @php
              $assignedRoles = $permission->roles->pluck('name');
            @endphp
            @foreach($assignedRoles as $roleName)
              <span class="badge bg-label-primary me-1">{{ $roleName }}</span>
            @endforeach
            @if($assignedRoles->isEmpty())
              <span class="badge bg-label-secondary">Not assigned</span>
            @endif
          </td>
          <td>{{ $permission->created_at->format('d M Y') }}</td>
          <td>
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-text-primary btn-sm edit-permission-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#editPermissionModal"
                      data-id="{{ $permission->id }}"
                      data-name="{{ $permission->name }}">
                <i class="icon-base ti tabler-edit icon-md"></i>
              </button>
              <form action="{{ route('access-permission.destroy', $permission->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-icon btn-text-danger btn-sm" onclick="return confirm('Are you sure?')">
                  <i class="icon-base ti tabler-trash icon-md"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
        @if($permissions->isEmpty())
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">No permissions found.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

{{-- Add Permission Modal --}}
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h3>Add New Permission</h3>
          <p class="text-body-secondary">Permissions you may use and assign to your users.</p>
        </div>
        <form method="POST" action="{{ route('access-permission.store') }}">
          @csrf
          <div class="col-12 form-control-validation mb-4">
            <label class="form-label" for="modalPermissionName">Permission Name</label>
            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="e.g. edit products" required />
          </div>
          <div class="col-12 text-center demo-vertical-spacing">
            <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Permission</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Permission Modal --}}
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h3>Edit Permission</h3>
          <p class="text-body-secondary">Edit permission as per your requirements.</p>
        </div>
        <div class="alert alert-warning" role="alert">
          <h6 class="alert-heading mb-2">Warning</h6>
          <p class="mb-0">By editing the permission name, you might break the system permissions functionality. Please ensure you're absolutely certain before proceeding.</p>
        </div>
        <form id="editPermissionForm" method="POST" action="">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-sm-9 form-control-validation">
              <label class="form-label" for="editPermissionName">Permission Name</label>
              <input type="text" id="editPermissionName" name="modalPermissionName" class="form-control" placeholder="Permission Name" required />
            </div>
            <div class="col-sm-3 mb-4">
              <label class="form-label invisible d-none d-sm-inline-block">Button</label>
              <button type="submit" class="btn btn-primary mt-1 mt-sm-0">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.edit-permission-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const name = this.dataset.name;
      document.getElementById('editPermissionName').value = name;
      document.getElementById('editPermissionForm').action = '/admin/access-permission/' + id;
    });
  });
});
</script>
@endsection