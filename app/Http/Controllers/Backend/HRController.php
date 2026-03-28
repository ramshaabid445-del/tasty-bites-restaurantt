<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HRController extends Controller
{
    // 1. Employees List
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('backend.management.hr.index', compact('employees'));
    }

    // 2. Store Employee
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:employees',
            'phone'        => 'required',
            'designation'  => 'required',
            'salary'       => 'required|numeric',
            'joining_date' => 'required|date',
        ]);

        Employee::create($request->all());
        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    // 3. Roles List (Spatie Models)
    public function roles()
    {
        $roles = Role::with('permissions')->latest()->get(); 
        $all_permissions = Permission::all();

        return view('backend.management.hr.roles', compact('roles', 'all_permissions'));
    }

    // 4. Store New Role & Assign Permissions
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'New Role: ' . $request->name . ' created successfully!');
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully!');
    }

    // 5. Attendance View
    public function attendance()
    {
        return view('backend.management.hr.attendance');
    }
}