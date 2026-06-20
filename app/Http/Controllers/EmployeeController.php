<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        // Lọc thủ công: Chỉ lấy nhân viên của Chủ doanh nghiệp đang đăng nhập
        $employees = Employee::where('user_id', auth('web')->id())->get();

        return view('employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'string'
        ]);

        Employee::create([
            'user_id' => auth('web')->id(), // GÁN THỦ CÔNG ID của chủ doanh nghiệp
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles ?? [],
        ]);

        return redirect()->route('employees.index')->with('success', 'Thêm nhân viên thành công!');
    }

    public function create()
    {
        $roles = Employee::AVAILABLE_ROLES;
        return view('employees.create', compact('roles'));
    }

    // HIỂN THỊ FORM CẬP NHẬT
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // XỬ LÝ LƯU CẬP NHẬT
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Bỏ qua check unique email cho chính nhân viên đang sửa
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'password' => 'nullable|min:6', // Password có thể trống nếu không muốn đổi
            'roles' => 'nullable|array',
            'roles.*' => 'string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $request->roles ?? [],
        ];

        // Chỉ cập nhật mật khẩu nếu người dùng có nhập mật khẩu mới
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    // XỬ LÝ XÓA NHÂN VIÊN
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Xóa nhân viên thành công!');
    }
}
