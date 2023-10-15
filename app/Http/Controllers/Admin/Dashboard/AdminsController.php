<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminsController extends Controller
{

//    public function __construct()
//    {
//        $this->authorizeResource(Admin::class,'admin');
//    }

    public function index()
    {
        $admins = Admin::paginate(5);
        return view('dashboard.admins.index', compact('admins'));
    }


    public function create()
    {
        return view('dashboard.admins.create', [
            'roles' => Role::all(),
            'admin' => new Admin(),
        ]);
    }

    public function store(StoreAdminRequest $request)
    {
        try {
            DB::beginTransaction();
            $admin = Admin::create([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'username' => 'not defined',  // for test (required in db)
                'password' => 'password',     // for test (required in db)
            ]);
            $admin->roles()->attach($request->post('roles')); //attach -> add , sync -> check if in array or no
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
      return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully');
    }

    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $adminRoles = $admin->roles()->pluck('id')->toArray();
        return view('dashboard.admins.edit', compact('admin', 'roles', 'adminRoles'));
    }


    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        try {
            DB::beginTransaction();
            $admin->update([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
            ]);
            $admin->roles()->sync($request->roles);
            DB::commit();
        }
        catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully');
    }


    public function destroy(string $id)
    {
        Admin::destroy($id);
        return redirect()->route('admin.admins.index')->with('delete', 'Admin deleted successfully');
    }

    public function ajax_search(Request $request)
    {
        $admins = Admin::where('name', 'LIKE', "%{$request->search_string}%")->orderby('id', 'desc')->paginate(5);
        return view('dashboard.admins.pagination', compact('admins'))->render();
    }

    public function ajax_paginate()
    {
        $admins = Admin::paginate(5);
        return view('dashboard.admins.pagination', compact('admins'));
    }

}
