@extends('admin.layouts.app')

@section('title', 'User Management')

@push('styles')
  <link href="{{ asset('/') }}admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="{{ asset('/') }}admin_assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ asset('/') }}admin_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('/') }}admin_assets/js/demo/datatables-demo.js"></script>
@endpush

@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User Management</h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
        <div class="ms-auto">
          <div class="btn-list">
            @can('users-create')
              <a href="{{ route('users.create') }}" type="button" class="btn btn-primary waves-effect waves-light br-5"><i
                  class="fas fa-plus-circle me-1"></i>
                Add
                New User</a>
            @endcan

          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center bg-primary text-white">
                  <tr>
                    <th>SL.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    {{-- <th>Type</th> --}}
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($users as $user)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td class="text-center">
                        @if (!empty($user->getRoleNames()))
                          @foreach ($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                          @endforeach
                        @endif
                      </td>
                      {{-- <td class="text-center">{{ getDropdownTextValue('user_type', $user->type) }}</td> --}}
                      <td class="text-center">
                        <span
                          class="badge badge-pill {{ $user->status == 2 ? 'badge-danger' : 'badge-success' }} ">{{ getDropdownTextValue('status', $user->status) }}</span>
                      </td>
                      <td>
                        {{-- <a class="text-primary" href="{{ route('users.show', $user->id) }}" data-toggle="tooltip"
                          title="View"><i class="fas fa-eye"></i></a> --}}
                        <div class="text-center d-flex justify-content-center align-items-center">

                          @can('users-list')
                            <a class="text-warning ml-2" href="{{ route('users.show', $user->id) }}" data-toggle="tooltip"
                              data-placement="top" title="View"><i class="fa fa-eye text-primary"></i></a>
                          @endcan

                          @can('users-edit')
                            @if ($user->id != 1 && $user->id != Auth::user()->id)
                              <a class="text-warning ml-2" href="{{ route('users.edit', $user->id) }}"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                  class="fas fa-pencil-alt"></i></a>

                              {{-- set inactive --}}
                              @if ($user->status == 1)
                                <form action="{{ route('users.change-status', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?')">
                                  @csrf
                                  @method('put')
                                  <input type="text" value="2" name="status" hidden>

                                  <button type="submit" class="btn btn-link p-0 m-0 text-danger ml-2" data-toggle="tooltip"
                                    data-placement="top" title="Mark Inactive"><i class="fas fa-times"></i></button>
                                </form>
                              @endif

                              {{-- set active --}}
                              @if ($user->status == 2)
                                <form action="{{ route('users.change-status', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?')">
                                  @csrf
                                  @method('put')
                                  <input type="text" value="1" name="status" hidden>

                                  <button type="submit" class="btn btn-link p-0 m-0 text-success ml-2"
                                    data-toggle="tooltip" data-placement="top" title="Mark Active"><i
                                      class="fas fa-check"></i></button>
                                </form>
                              @endif
                            @endif
                          @endcan

                        </div>

                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
