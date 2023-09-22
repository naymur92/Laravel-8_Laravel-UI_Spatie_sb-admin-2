@extends('admin.layouts.app')

@section('title', 'Show User' . ' - ' . $user->name)

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Show User</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">{{ $user->name }}</h5>
            @can('users-list')
              <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <div class="card-body">
            <table class="table table-striped table-hover">
              <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>Roles</th>
                <td>
                  @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $v)
                      <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                  @endif
                </td>
              </tr>
              <tr>
                <th>Permissions</th>
                <td>
                  @if (count($user->getAllPermissions()) > 0)
                    @foreach ($user->getAllPermissions() as $v)
                      <label class="badge badge-primary">{{ $v->name }}</label>
                    @endforeach
                  @else
                    <label class="badge badge-danger">No Permission</label>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Created At</th>
                <td>{{ date('d M, Y - h:i a', strtotime($user->created_at)) }}</td>
              </tr>
              <tr>
            </table>
          </div>
          <div class="card-footer d-flex justify-content-between">

            @if (!$user->hasRole('Super Admin') || $user->id != Auth::user()->id)
              @can('users-edit')
                <a class="btn btn-warning" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-pen"></i> Edit</a>
              @endcan
              {{-- @can('users-delete')
                <form action="{{ route('users.destroy', $user->id) }}"
                  onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </form>
              @endcan --}}
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
