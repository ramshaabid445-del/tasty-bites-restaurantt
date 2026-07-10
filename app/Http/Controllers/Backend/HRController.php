<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User; 
use App\Models\Attendance; 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class HRController extends Controller
{
    // --- 1. EMPLOYEES SECTION ---
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('backend.management.hr.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:employees,email',
            'phone'        => 'required',
            'designation'  => 'required',
            'salary'       => 'required|numeric',
            'joining_date' => 'required|date',
        ]);

        Employee::create($request->all());
        return redirect()->back()->with('success', 'Bhai, Employee add ho gaya!');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return redirect()->back()->with('success', 'Employee details update ho gayin!');
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Employee nikaal diya gaya!');
    }

    // --- 2. ROLES & PERMISSIONS SECTION ---
    public function roles()
    {
        $roles = Role::with('permissions')->get(); 
        $all_permissions = Permission::all();
        return view('backend.management.hr.roles', compact('roles', 'all_permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }
        return redirect()->back()->with('success', 'Naya Role ban gaya!');
    }

    // --- 3. ATTENDANCE SECTION ---
    public function attendance()
    {
        // Aaj ki attendance aur dropdown ke liye users
        $attendances = Attendance::with('user')
                        ->whereDate('date', now()->toDateString())
                        ->latest()
                        ->get();
        $employees = User::all(); 

        return view('backend.management.hr.attendance', compact('attendances', 'employees'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'user_id'  => 'required',
            'check_in' => 'required',
        ]);

        // Agar employee pehle se present hai toh update karega warna naya banayega
        Attendance::updateOrCreate(
            ['user_id' => $request->user_id, 'date' => now()->toDateString()],
            [
                'check_in' => $request->check_in,
                'status'   => $request->status ?? 'Present'
            ]
        );

        return redirect()->back()->with('success', 'Attendance lag gayi!');
    }

    // Check-out karne ke liye naya function
    public function updateCheckout(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'check_out' => now()->format('H:i:s')
        ]);
        return redirect()->back()->with('success', 'Check-out time lag gaya!');
    }

    public function destroyAttendance($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Attendance record delete kar diya!');
    }
}