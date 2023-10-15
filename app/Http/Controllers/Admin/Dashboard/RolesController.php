<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
//    public function __construct()
//    {
//        $this->authorizeResource(Role::class, 'role');
//    }

    public function index()
    {
        $roles = Role::paginate(1);
        return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('dashboard.roles.create',[
            'role' => new Role(),
        ]);
    }

    public function store(RoleRequest $request)
    {
        Role::createRoleWithAbilities($request);
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        $role_abilities = $role->abilities()->pluck( 'type','ability')->toArray(); //type ->value , ability->key //default 0, 1, 2
        return view('dashboard.roles.edit', compact('role','role_abilities'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->updateRoleWithAbilities($request);
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        Role::destroy($role->id);
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }

    public function ajax_search(Request $request)
    {
        $roles = Role::where('name', 'LIKE', "%{$request->search_string}%")->orderby('id', 'desc')->paginate(1);
        return view('dashboard.roles.pagination', compact('roles'))->render();
    }

    public function ajax_paginate()
    {
        $roles = Role::paginate(1);
        return view('dashboard.roles.pagination', compact('roles'))->render();
    }
}
