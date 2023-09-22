@extends('admin.layouts.app')

@section('title', 'User Profile')

@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit User Profile</h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Edit Profile of {{ $user->name }}</h6>
        <div class="ms-auto">
          <div class="btn-list">
            <a href="{{ route('user-profile.show') }}" type="button"
              class="btn btn-secondary waves-effect waves-light br-5"><i class="fas fa-angle-left me-1"></i>
              Back</a>
          </div>
        </div>
      </div>
      <form action="{{ route('user-profile.update') }}" method="POST">
        @csrf
        @method('put')

        <div class="card-body">
          <div class="row">

            {{-- name --}}
            <div class="col-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="_name" class="col-form-label font-14">Name <span class="text-danger"><i
                      class="fas fa-xs fa-asterisk"></i></span></label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  id="_name" value="{{ old('name', $user->name) }}" placeholder="Name">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            {{-- email/ user id --}}
            <div class="col-12 col-lg-6 mb-3">
              <div class="form-group">
                <label for="_email_id" class="col-form-label font-14">Email <span class="text-danger"><i
                      class="fas fa-xs fa-asterisk"></i></span></label>

                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  id="_email_id" value="{{ old('email', $user->email) }}" placeholder="Email">

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

          </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
          <input class="btn btn-success" type="submit" value="Update">
        </div>
      </form>
    </div>

  </div>
@endsection
