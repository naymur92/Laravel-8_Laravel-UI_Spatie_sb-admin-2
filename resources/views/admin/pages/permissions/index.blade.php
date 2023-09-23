@extends('admin.layouts.app')

@section('title', 'Permission Management')


@push('styles')
  <link href="{{ asset('/') }}admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <style>
    .generated-field {
      position: relative;
    }

    .item-close-btn {
      position: absolute;
      bottom: 27px;
      left: 97%;
      cursor: pointer;
    }

    table tbody tr td {
      padding: 0px !important;
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
      $('.add-more-btn').click(function(event) {
        event.preventDefault();

        var field_number = $('.name').length;

        var fieldHTML =
          `<div class="row mt-2 generated-field"><input type="text" id="field${field_number}" name="name[]" class="name form-control" placeholder="item-list, item-create, item-edit, item-delete, etc"><i class="fa fa-times text-danger item-close-btn"></i></div>`;

        $('.form-body').append(fieldHTML);

        $('.item-close-btn').click(function() {
          $(this).parent('div.generated-field').remove();

          // regenerate field ids
          const field_number = $('.name').length;
          for (var i = 0; i < field_number; ++i) {
            var new_id = `field${i}`;
            document.getElementsByClassName("name")[i].id = new_id;

          }
        });
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      // submit form
      $('#submit-btn').click(function(e) {
        e.preventDefault();

        let myform = document.getElementById('perm_insert_form');
        let formData = new FormData(myform);

        $('.name').removeClass('is-invalid');
        $('.errors').remove();

        $.ajax({
          url: "/admin/permissions",
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
          },
          error: function(xhr, status, error) {
            if (xhr.status === 422) {
              const errors = xhr.responseJSON.errors;

              // Loop through the errors for 'name'
              const field_number = $('.name').length;

              for (var i = 0; i < field_number; ++i) {
                if (errors.hasOwnProperty(`name.${i}`)) {
                  const errorMsg = errors[`name.${i}`];
                  // Display or handle each error message as needed
                  $(`#field${i}`).addClass('is-invalid');
                  $(`#field${i}`).after(`<span class="errors invalid-feedback" role="alert">
                    <strong>${errorMsg}</strong>
                  </span>`);
                }

              }

            }
          }
        })
      });
    });
  </script>
@endpush


@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Permissions Management</h1>

    <!-- DataTales Example -->
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between">
            <h5 class="m-0 font-weight-bold text-primary">Permissions List</h5>
            @can('permissions-create')
              <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Create New Permission</button>
            @endcan
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table data-page-length='25' class="table table-bordered text-center" id="dataTable" width="100%"
                cellspacing="0">
                <thead class="text-white bg-primary">
                  <tr>
                    <th>SL No</th>
                    <th>Permission Name</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  ?>
                  @foreach ($permissions as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td>
                        @can('permissions-delete')
                          <form action="{{ route('permissions.destroy', $item->id) }}"
                            onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-link p-0 b-0 text-danger" data-toggle="tooltip" data-placement="top"
                              title="Delete"><i class="fa fa-trash"></i></button>
                          </form>
                        @endcan
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
    <div class="modal-dialog modal-dialog-centered" style="max-width: 30vw">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Permission Add Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="perm_insert_form" action="{{ route('permissions.store') }}" method="post">
          <div class="modal-body">
            @csrf

            <label class="mb-2"><strong>Permission Name</strong> <span class="text-danger"><i
                  class="fas fa-xs fa-asterisk"></i></span></label>
            <div class="form-body px-3">
              <div class="row">
                <input type="text" id="field0" name="name[]" class="name form-control"
                  placeholder="item-list, item-create, item-edit, item-delete, etc">
              </div>
            </div>
            {{-- Add More Button --}}
            <div class="d-flex justify-content-end my-3">
              <button class="btn btn-primary add-more-btn"><i class="fa fa-plus mr-2"></i> Add More Field</button>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="reset" class="btn btn-danger mr-3" value="Reset Form">
            <input id="submit-btn" type="submit" class="btn btn-success" value="Add Permissions">
          </div>
        </form>
      </div>
    </div>
  </div>


@endsection
