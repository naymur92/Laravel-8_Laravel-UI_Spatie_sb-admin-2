@extends('admin.layouts.app')

@section('title', 'Show Role' . ' - ' . $role->name)

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Show Role</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">{{ $role->name }}</h5>
            @can('roles-list')
              <a href="{{ route('roles.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <div class="card-body">
            <table class="table table-striped table-hover">
              <tr>
                <th>Role Name</th>
                <td>{{ $role->name }}</td>
              </tr>
              <tr>
                <th>Permissions</th>
                <td>
                  @if ($role->permissions->count() > 0)
                    @foreach ($role->permissions as $p)
                      <label class="badge badge-primary">{{ $p->name }}</label>
                    @endforeach
                  @else
                    <label class="badge badge-danger">No Permission</label>
                  @endif
                </td>
              </tr>
              <tr>
            </table>
          </div>
          <div class="card-footer d-flex justify-content-between">
            @can('roles-edit')
              <a class="btn btn-warning" href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-pen"></i> Edit</a>
            @endcan
            @if ($role->name != 'Super Admin')
              @can('roles-delete')
                <form action="{{ route('roles.destroy', $role->id) }}"
                  onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </form>
              @endcan
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
