@extends('admin.layouts.app')

@section('title', 'Create User')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create User</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">User Create Form</h5>
            @can('users-list')
              <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">

              <div class="form-group">
                <label for="_name"><strong>Enter Full Name:</strong></label>
                <input type="text" name="name" id="_name" value="{{ old('name') }}"
                  class="form-control @error('name') is-invalid @enderror">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="_email"><strong>Enter Email:</strong></label>
                <input type="email" name="email" id="_email" value="{{ old('email') }}"
                  class="form-control @error('email') is-invalid @enderror">

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="_password"><strong>Enter Password:</strong></label>
                    <input type="password" name="password" id="_password"
                      class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="_password"><strong>Retype Password:</strong></label>
                    <input type="password" name="password_confirmation" id="_password"
                      class="form-control @error('password') is-invalid @enderror">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="_role"><strong>Select Role:</strong></label>
                <select name="roles[]" id="_role" class="form-control @error('roles') is-invalid @enderror" multiple>
                  <option value="" selected disabled>Select One/Multiple</option>

                  @foreach ($roles as $item)
                    <option value="{{ $item }}" @if (old('roles') != null && in_array($item, old('roles'))) selected @endif>
                      {{ $item }}</option>
                  @endforeach
                </select>

                @error('roles')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <input type="submit" value="SUBMIT" class="btn btn-success">
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
@endsection
