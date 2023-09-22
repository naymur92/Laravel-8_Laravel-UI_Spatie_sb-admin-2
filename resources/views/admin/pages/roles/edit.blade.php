@extends('admin.layouts.app')

@section('title', 'Edit Role' . ' - ' . $role->name)

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $role->name }}</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Role Edit Form</h5>
            @can('role-list')
              <a href="{{ route('roles.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @method('put')
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="_name"><strong>Role Name:</strong></label>
                <input type="text" name="name" id="_name"
                  class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}"
                  placeholder="Admin, User Entry Manager, etc.">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="_permission" class="mb-3"><strong>Select Permissions:</strong></label>
                <br>

                @foreach ($permissions as $item)
                  <?php if ($item->id <= 8) {
                      continue;
                  } ?>
                  <label>
                    <input type="checkbox" name="permission[]" value="{{ $item->id }}"
                      {{ in_array($item->id, $rolePermissions) ? 'checked' : '' }}>
                    {{ $item->name }}
                  </label>
                  <br>
                @endforeach
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <input type="submit" value="Update Role" class="btn btn-success">
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
@endsection
