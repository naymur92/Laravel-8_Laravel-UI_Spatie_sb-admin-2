<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:users-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
    // $this->middleware('permission:users-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $roles = DB::table('rbac_roles')->where('role_id', '>', 1)->where('role_type', '>=', Auth::user()->type)->pluck('role_name', 'role_id');

    $users = User::orderBy('created_at', 'desc')->get();

    return view('admin.pages.users.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name');

    return view('admin.pages.users.create', compact('roles'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $request->validate(
      [
        'name' => 'required|max:255',
        'email' => 'required|unique:users,email|max:255',
        'password' => 'required|regex:/^\S*$/u|min:6|confirmed',
        'roles' => 'required',
      ],
      [
        'name.required' => 'Name is required!',
        'email.required' => 'Email is required!',
        'password.required' => 'Password is required!',
        'password.regex' => 'Invalid input!',
        'password.min' => 'Minimum length is 6!',
        'password.confirmed' => 'Password Confirmation dose not match!',
        'email.unique' => 'This email has been taken!',
        'roles.required' => 'Role is required!',
      ]
    );

    // $role_type = Role::findOrFail($request->role)->role_type;

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'status' => 1,
      'created_by' => Auth::user()->id,
    ]);

    $user->assignRole($request->input('roles'));

    flash()->addSuccess('User Created');
    return redirect()->route('users.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    return view('admin.pages.users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    // $roles = DB::table('rbac_roles')->where('role_id', '>', 1)->where('role_type', '>=', Auth::user()->type)->pluck('role_name', 'role_id');
    $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name');
    $userRoles = $user->roles->pluck('name')->toArray();
    return view('admin.pages.users.edit', compact('user', 'roles', 'userRoles'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $request->validate(
      [
        'name' => 'required|max:255',
        'email' => 'required|unique:users,email,' . $user->id . ',id|max:255',
        'roles' => 'required',
      ],
      [
        'name.required' => 'Name is required!',
        'email.required' => 'Email is required!',
        'email.unique' => 'This email has been taken!',
        'roles.required' => 'Role is required!',
      ]
    );

    // $role_type = Role::findOrFail($request->role)->role_type;

    $user->update([
      'name' => $request->name,
      'email' => $request->email,
      // 'type' => $role_type,
      'updated_by' => Auth::user()->id,
    ]);

    DB::table('model_has_roles')->where('model_id', $user->id)->delete();

    $user->assignRole($request->input('roles'));

    flash()->addSuccess("User updated successfully!");
    return redirect()->route('users.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  // public function destroy(User $user)
  // {
  //   //
  // }

  // change status
  public function changeStatus(Request $request, User $user)
  {
    $user->update(['status' => $request->status, 'updated_by' => Auth::user()->id]);

    flash()->addSuccess("Status changed successfully!");
    return redirect()->route('users.index');
  }

  // show user profile
  public function userProfile()
  {
    $user = Auth::user();
    return view('admin.pages.user-profile.show', compact('user'));
  }

  // edit profile
  public function editUserProfile()
  {
    $user = Auth::user();
    return view('admin.pages.user-profile.edit', compact('user'));
  }

  // change profile picture
  public function changeProfilePicture(Request $request)
  {
    // dd($request->file('profile_picture'));
    // die();
    // delete existing picute first
    $file = Auth::user()->profile_picture->first() ? Auth::user()->profile_picture->first() : NULL;
    if ($file != NULL) {
      unlink($file->filepath . '/' . $file->filename);

      $file->update([
        'deleted_by' => Auth::user()->id
      ]);

      $file->delete();
    }

    // upload new picture
    $opName = 'users';
    // path name
    $filePath = 'assets/uploads/' . $opName;

    $supported_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($request->file('profile_picture')->extension(), $supported_types) && $request->file('profile_picture')->getSize() <= 1024 * 1024) {
      $fileName = Auth::user()->id . '_' . time() . '.' . $request->file('profile_picture')->extension();
      $request->file('profile_picture')->move($filePath, $fileName);

      // save it to files table
      $uploaded_file = File::create([
        'operation_name' => $opName,
        'table_id' => Auth::user()->id,
        'filepath' => $filePath,
        'filename' => $fileName,
        'created_by' => Auth::user()->id
      ]);
    }

    flash()->addSuccess("Profile picture updated successfully!");
    return redirect()->route('user-profile.show');
  }

  // update profile
  public function updateUserProfile(Request $request)
  {
    $user = User::findOrFail(Auth::user()->id);

    $request->validate(
      [
        'name' => 'required|max:255',
        'email' => 'required|unique:users,email,' . $user->id . ',id|max:255',
      ],
      [
        'name.required' => 'Name is required!',
        'email.required' => 'Email is required!',
        'email.unique' => 'This email has been taken!',
      ]
    );

    $user->update([
      'name' => $request->name,
      'email' => $request->email,
      'updated_by' => Auth::user()->id
    ]);

    flash()->addSuccess('User profile updated successfully!');
    return redirect()->route('user-profile.show');
  }

  // change password
  public function changePassword(Request $request)
  {
    return view('admin.pages.user-profile.change-password');
  }

  // update password
  public function updatePassword(Request $request)
  {
    $user = User::findOrFail(Auth::user()->id);
    // validate
    $request->validate(
      [
        'password' => ['required', 'regex:/^\S*$/u', 'min:6', 'confirmed']
      ],
      [
        'password.required' => 'Password is required',
        'password.confirmed' => 'Password Confirmation dose not match!',
        'password.min' => 'Minimum length is 6!',
        'password.regex' => 'Invalid input!',
      ]
    );

    $user->update([
      'password' => bcrypt($request->password),
      'updated_by' => Auth::user()->id
    ]);

    flash()->addSuccess('Password changed successfully!');
    return redirect()->route('user-profile.change-password');
  }
}
