@extends('admin.layouts.app')

@section('title', 'Role Management')


@push('styles')
  <link href="{{ asset('/') }}admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <style>
    table tbody tr td {
      padding: 5px !important;
      vertical-align: middle !important;
    }
  </style>
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="{{ asset('/') }}admin_assets/vendor/datatables/jquery.dataTables.js"></script>
  <script src="{{ asset('/') }}admin_assets/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('/') }}admin_assets/js/demo/datatables-demo.js"></script>

  <script>
    $(document).ready(function() {
      // submit form
      $('#submit-btn').click(function(e) {
        e.preventDefault();

        let myform = document.getElementById('role_insert_form');
        let formData = new FormData(myform);

        $('#_name').removeClass('border-danger');

        $.ajax({
          url: "/admin/roles",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function(response) {
            // console.log(response)
            if (response.success) {
              location.reload();
            }
          }
        }).fail(function(jqXHR, textStatus, error) {
          // get errors list
          let errors = jQuery.parseJSON(jqXHR.responseText).errors;

          // convert object to array
          let errorsArray = Object.keys(errors).map(function(key) {
            return errors[key];
          });
          // console.log(errors);

          // add css to field
          if (errors.name) {
            $('#_name').addClass('border-danger');
          }
          if (errors.permission) {
            $('.permissions').css({
              'border': '1px solid red',
              'padding': '5px',
              'borderRadius': '5px'
            });
          }

          // clear type list
          $('#errors').html('');
          // generate errors
          var content = '';
          errorsArray.forEach(element => {
            content += '<li>' + element[0] + '</li>';
          });
          $('#errors').html(content);
        });
      });
    });
  </script>
@endpush


@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Role Management</h1>

    <!-- DataTales Example -->
    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between">
            <h5 class="m-0 font-weight-bold text-primary">Roles List</h5>
            @can('roles-create')
              <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Create New Role</button>
            @endcan
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-white bg-primary">
                  <tr>
                    <th>SL No</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>

                  @foreach ($roles as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td>
                        <div class="d-flex justify-content-center align-items-center">

                          @can('roles-list')
                            <a class="btn btn-link p-0 mr-2" href="{{ route('roles.show', $item->id) }}"
                              data-toggle="tooltip" data-placement="top" title="View"><i
                                class="fa fa-eye text-primary"></i></a>
                          @endcan
                          @can('roles-edit')
                            <a class="btn btn-link p-0 mr-2" href="{{ route('roles.edit', $item->id) }}"
                              data-toggle="tooltip" data-placement="top" title="Edit"><i
                                class="fa fa-pen text-warning"></i></a>
                          @endcan
                          @if ($item->name != 'Super Admin')
                            @can('roles-delete')
                              <form action="{{ route('roles.destroy', $item->id) }}"
                                onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-link p-0 mr-2" data-toggle="tooltip" data-placement="top"
                                  title="Delete"><i class="fa fa-trash text-danger"></i></button>
                              </form>
                            @endcan
                          @endif
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

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 40vw">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Role Add Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="role_insert_form" action="{{ route('roles.store') }}" method="post">
          <div class="modal-body">
            @csrf

            <div class="form-group">
              <label for="_name"><strong>Role Name</strong> <span class="text-danger"><i
                    class="fas fa-xs fa-asterisk"></i></span></label>
              <input type="text" name="name" id="_name" class="form-control"
                placeholder="Super Admin, Admin, User, etc.">
            </div>

            <div class="form-group">
              <label class="mb-3"><strong>Select Permissions</strong> <span class="text-danger"><i
                    class="fas fa-xs fa-asterisk"></i></span></label>
              <br>

              <div class="permissions">
                @foreach ($permissions as $item)
                  @if ($item->id > 8)
                    <label class="mr-2" {{ $item->id <= 8 ? 'hidden' : null }}>
                      <input type="checkbox" name="permission[]" value="{{ $item->id }}">
                      {{ $item->name }}
                    </label>
                  @endif
                @endforeach
              </div>

            </div>

            {{-- errors area --}}
            <ul id="errors" class="text-danger my-2">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="reset" class="btn btn-danger mr-3" value="Reset Form">
            <input id="submit-btn" type="submit" class="btn btn-success" value="Add Role">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
