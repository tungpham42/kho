@extends('layouts.app')

@section('title', 'Cập nhật Nhân Viên')
@section('header_title', 'Cập nhật Nhân Viên')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-10">
    <form action="{{ route('employees.update', $employee) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Tên nhân viên <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email đăng nhập <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Mật khẩu mới</label>
            <input type="password" name="password" id="password" minlength="6" placeholder="Bỏ trống nếu không muốn đổi"
                class="w-full sm:w-1/2 px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
        </div>

        <hr class="border-slate-100">

        <div>
            <label class="block text-base font-bold text-slate-800 mb-4">Cập nhật quyền hệ thống</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php $currentRoles = old('roles', $employee->roles ?? []); @endphp

                @foreach(\App\Models\Employee::AVAILABLE_ROLES as $key => $label)
                <label class="flex items-center p-4 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition">
                    <input type="checkbox" name="roles[]" value="{{ $key }}" class="w-5 h-5 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 focus:ring-2"
                        {{ in_array($key, $currentRoles) ? 'checked' : '' }}>
                    <div class="ml-3">
                        <span class="block text-sm font-bold text-slate-700">{{ $label }}</span>
                        <span class="block text-xs text-slate-500 mt-0.5">Cho phép thao tác với {{ strtolower($label) }}</span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition-all">Lưu thay đổi</button>
            <a href="{{ route('employees.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold py-3 px-6 rounded-xl border border-slate-200 transition-all">Hủy bỏ</a>
        </div>
    </form>
</div>
@endsection
