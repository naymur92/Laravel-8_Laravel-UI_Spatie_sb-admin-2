@extends('admin.layouts.app')

@section('title', 'User Profile')

@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Change Password</h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Change Password of {{ Auth::user()->name }}</h6>
        <div class="ms-auto">
          <div class="btn-list">
            <a href="{{ route('dashboard') }}" type="button" class="btn btn-secondary waves-effect waves-light br-5"><i
                class="fas fa-angle-left me-1"></i>
              Back</a>
          </div>
        </div>
      </div>
      <form action="{{ route('user-profile.update-password') }}" method="POST">
        @csrf
        @method('put')

        <div class="card-body">
          <div class="row">

            {{-- password --}}
            <div class="col-12 col-lg-6 mb-3">
              <div class="form-group">
                <label for="_pass" class="col-form-label font-14">Enter new password <span class="text-danger"><i
                      class="fas fa-xs fa-asterisk"></i></span></label>

                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                  id="_pass" placeholder="Password">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            {{-- confirm password --}}
            <div class="col-12 col-lg-6 mb-3">
              <div class="form-group">
                <label for="_pass_conf" class="col-form-label font-14">Enter password again <span class="text-danger"><i
                      class="fas fa-xs fa-asterisk"></i></span></label>

                <input type="password" name="password_confirmation"
                  class="form-control @error('password') is-invalid @enderror" id="_pass_conf"
                  placeholder="Retype password">

                @error('password')
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
