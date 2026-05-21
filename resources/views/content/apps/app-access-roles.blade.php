@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('content')
  <h4 class="mb-1">Roles List</h4>

  <p class="mb-6">
    A role provides access to predefined menus and features so that depending on <br />
    assigned role an administrator can have access to what user needs.
  </p>

  {{-- Success/Error Messages --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-4" role="alert">
      @foreach ($errors->all() as $error)
        <p class="mb-0">{{ $error }}</p>
      @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Role cards -->
  <div class="row g-6">
    @foreach ($roles as $role)
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h6 class="fw-normal mb-0 text-body">Total {{ $role->users_count }} users</h6>
              <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                @foreach ($role->users->take(4) as $user)
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                    title="{{ $user->name }}" class="avatar pull-up">
                    <span
                      class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                  </li>
                @endforeach
                @if ($role->users_count > 4)
                  <li class="avatar">
                    <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip"
                      data-bs-placement="bottom"
                      title="{{ $role->users_count - 4 }} more">+{{ $role->users_count - 4 }}</span>
                  </li>
                @endif
              </ul>
            </div>
            <div class="d-flex justify-content-between align-items-end">
              <div class="role-heading">
                <h5 class="mb-1">{{ $role->name }}</h5>
                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                  class="btn btn-icon btn-text-primary btn-sm role-edit-modal" data-role-id="{{ $role->id }}"
                  data-role-name="{{ $role->name }}"
                  data-role-permissions="{{ $role->permissions->pluck('name')->toJson() }}" title="Edit Role">
                  <i class="icon-base ti tabler-edit icon-md"></i>
                </a>
              </div>
              @if ($role->name !== 'Super Admin')
                <form action="{{ route('access-roles.destroy', $role->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-icon btn-text-danger p-0"
                    onclick="return confirm('Are you sure you want to delete this role?')">
                    <i class="icon-base ti tabler-trash icon-md"></i>
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="card h-100">
        <div class="row h-100">
          <div class="col-sm-5">
            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
              <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid" alt="Image"
                width="83" />
            </div>
          </div>
          <div class="col-sm-7">
            <div class="card-body text-sm-end text-center ps-sm-0">
              <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Role</button>
              <p class="mb-0">
                Add new role, <br />
                if it doesn't exist.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Users Table --}}
    <div class="col-12">
      <h4 class="mt-6 mb-1">Total users with their roles</h4>
      <p class="mb-0">Find all of your company's administrator accounts and their associate roles.</p>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allUsers ?? [] as $index => $user)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-3">
                        <span
                          class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                      </div>
                      <span class="fw-medium">{{ $user->name }}</span>
                    </div>
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @foreach ($user->roles as $userRole)
                      <span class="badge bg-label-primary me-1">{{ $userRole->name }}</span>
                    @endforeach
                    @if ($user->roles->isEmpty())
                      <span class="badge bg-label-secondary">No Role</span>
                    @endif
                  </td>
                  <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
              @endforeach
              @if (($allUsers ?? collect())->isEmpty())
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">No users found.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--/ Role cards -->

  <!-- Add Role Modal -->
  @include('_partials/_modals/modal-add-role')
  <!-- / Add Role Modal -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Select All checkbox
      const selectAll = document.getElementById('selectAll');
      if (selectAll) {
        selectAll.addEventListener('change', function() {
          document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = this.checked);
        });
      }

      // Edit Role click handler
      document.querySelectorAll('.role-edit-modal').forEach(function(btn) {
        btn.addEventListener('click', function() {
          const roleId = this.dataset.roleId;
          const roleName = this.dataset.roleName;
          const rolePermissions = JSON.parse(this.dataset.rolePermissions || '[]');

          // Update modal title
          document.querySelector('.role-title').textContent = 'Edit Role';

          // Set role name
          document.getElementById('modalRoleName').value = roleName;

          // Update form action for update
          const form = document.getElementById('addRoleForm');
          form.action = '/admin/access-roles/' + roleId;
          document.getElementById('formMethod').value = 'PUT';

          // Check permissions
          document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.checked = rolePermissions.includes(cb.value);
          });
        });
      });

      // Reset modal when "Add New Role" is clicked
      document.querySelectorAll('.add-new-role').forEach(function(btn) {
        btn.addEventListener('click', function() {
          document.querySelector('.role-title').textContent = 'Add New Role';
          document.getElementById('modalRoleName').value = '';
          const form = document.getElementById('addRoleForm');
          form.action = '{{ route('access-roles.store') }}';
          document.getElementById('formMethod').value = 'POST';
          document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
          if (document.getElementById('selectAll')) document.getElementById('selectAll').checked = false;
        });
      });
    });
  </script>
@endsection
