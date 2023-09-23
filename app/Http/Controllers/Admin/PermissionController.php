<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:permissions-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:permissions-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:permissions-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:permissions-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $permissions = Permission::get();
    return view('admin.pages.permissions.index', compact('permissions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'name.*' => 'required|unique:permissions,name'
      ],
      [
        'name.*.required' => 'Please enter Permission Name!',
        'name.*.unique' => 'Permission Name has been taken!'
      ]
    );

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    // $request->validate(
    //   [
    //     'name.*' => 'required'
    //   ],
    //   [
    //     'name.*.required' => 'Please enter Permission Name!'
    //   ]
    // );
    $names = array_unique($request->name);
    // return response()->json($names);
    foreach ($names as $item) {
      Permission::create(['name' => trim($item)]);
    }

    flash()->addSuccess('Permissions Added');
    return response()->json(['success' => true]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  // public function show(Permission $permission)
  // {
  //   //
  // }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  // public function edit(Permission $permission)
  // {
  //   //
  // }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  // public function update(Request $request, Permission $permission)
  // {
  //   //
  // }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  public function destroy(Permission $permission)
  {
    // $permission = Permission::findOrFail($permission);
    $permission->delete();

    flash()->addSuccess('Permission Deleted');
    return back();
  }
}
