<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Permission; // Naya Model include kiya
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

    // 3. Roles List (Database se fetch karega)
    public function roles()
    {
        // Database se roles aur unki permissions uthao
        $roles = Role::with('permissions')->latest()->get(); 
        
        // Modal mein dikhane ke liye saari permissions fetch karo
        $all_permissions = Permission::all();

        return view('backend.management.hr.roles', compact('roles', 'all_permissions'));
    }

    // 4. Store New Role & Assign Permissions
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array' // Checkboxes se array aayega
        ]);

        // 1. Role create karo
        $role = Role::create([
            'name' => $request->name,
        ]);

        // 2. Agar permissions select ki hain, toh pivot table (permission_role) mein dalo
        if ($request->has('permissions')) {
            // sync() function pivot table mein entry khud hi manage kar leta hai
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->back()->with('success', 'New Role: ' . $request->name . ' created successfully!');
    }

    // 5. Attendance View
    public function attendance()
    {
        return view('backend.management.hr.attendance');
    }
}