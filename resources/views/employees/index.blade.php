@extends('layouts.app')

@section('title', 'Quản lý Nhân viên')
@section('header_title', 'Danh sách Nhân viên')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <p class="text-slate-500 font-medium">Quản lý tài khoản và phân quyền cho nhân viên của bạn.</p>
    <a href="{{ route('employees.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-sm hover:-translate-y-0.5 transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Thêm nhân viên
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm uppercase tracking-wider font-bold">
                    <th class="px-6 py-4">Nhân viên</th>
                    <th class="px-6 py-4">Quyền hạn (Roles)</th>
                    <th class="px-6 py-4">Ngày tạo</th>
                    <th class="px-6 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($employees as $employee)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $employee->name }}</div>
                        <div class="text-sm text-slate-500">{{ $employee->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            @php $roles = $employee->roles ?? []; @endphp
                            @if(empty($roles))
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold">Chưa cấp quyền</span>
                            @else
                                @foreach($roles as $roleKey)
                                    <span class="px-2.5 py-1 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-lg text-xs font-bold">
                                        {{ \App\Models\Employee::AVAILABLE_ROLES[$roleKey] ?? $roleKey }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $employee->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-form-{{ $employee->id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-800 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 font-medium">Chưa có nhân viên nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
