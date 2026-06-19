@extends('layouts.app')
@section('title', 'Danh mục Kho bãi')
@section('header_title', 'Danh mục Kho bãi')

@section('content')
<div x-data="{
        showCreateModal: false,
        showEditModal: false,
        editForm: { id: '', code: '', name: '', address: '', is_active: 1 },
        openEdit(warehouse) {
            this.editForm = warehouse;
            this.showEditModal = true;
        }
    }"
    class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">

        <form action="{{ route('warehouses.index') }}" method="GET" class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm mã kho, tên kho (Nhấn Enter)..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
        </form>

        <button @click="showCreateModal = true" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm Kho Mới
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Mã Kho</th>
                    <th class="p-4">Tên Kho</th>
                    <th class="p-4">Địa Chỉ</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-center pr-6">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($warehouses ?? [] as $wh)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6">
                        <span class="font-extrabold text-indigo-600 tracking-tight">{{ $wh->code }}</span>
                    </td>
                    <td class="p-4 font-bold text-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            {{ $wh->name }}
                        </div>
                    </td>
                    <td class="p-4 text-slate-500 font-medium">
                        {{ $wh->address ?: '-' }}
                    </td>
                    <td class="p-4 text-center">
                        @if($wh->is_active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Hoạt động
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Đã khóa
                            </span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                @click="openEdit({ id: '{{ $wh->id }}', code: '{{ addslashes($wh->code) }}', name: '{{ addslashes($wh->name) }}', address: '{{ addslashes($wh->address) }}', is_active: '{{ $wh->is_active }}' })"
                                class="text-indigo-600 hover:text-white font-bold bg-indigo-50 hover:bg-indigo-600 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                Sửa
                            </button>
                            <form id="del-wh-{{ $wh->id }}" action="{{ route('warehouses.destroy', $wh->id) }}" method="POST" class="m-0 inline-block">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete('del-wh-{{ $wh->id }}')" class="text-rose-500 hover:text-white font-bold bg-rose-50 hover:bg-rose-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Bạn chưa cấu hình kho bãi nào (hoặc không tìm thấy kết quả).</p>
                        <button @click="showCreateModal = true" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Thêm kho bãi ngay</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-cloak x-show="showCreateModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-sm"
         x-transition:leave-end="opacity-0 backdrop-blur-none"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4 py-8">

        <div @click.away="showCreateModal = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md border border-slate-100 flex flex-col max-h-[90vh] overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="font-extrabold text-xl text-slate-900">Thêm Kho Mới</h3>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('warehouses.store') }}" method="POST" class="flex flex-col overflow-hidden">
                @csrf

                <div class="p-6 sm:p-8 space-y-5 overflow-y-auto">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Mã Kho <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" required placeholder="VD: KHO01" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400 uppercase">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tên Kho <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Kho trung tâm ABC" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Địa Chỉ</label>
                        <textarea name="address" rows="3" placeholder="Nhập địa chỉ chi tiết..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400 resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 p-6 border-t border-slate-100 bg-slate-50/50 shrink-0">
                    <button type="button" @click="showCreateModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition">
                        Hủy Bỏ
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Lưu Kho Bãi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-cloak x-show="showEditModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-sm"
         x-transition:leave-end="opacity-0 backdrop-blur-none"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4 py-8">

        <div @click.away="showEditModal = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md border border-slate-100 flex flex-col max-h-[90vh] overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="font-extrabold text-xl text-slate-900">Cập Nhật Kho Bãi</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'{{ route('warehouses.index') }}/' + editForm.id" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-5 overflow-y-auto">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Mã Kho <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" x-model="editForm.code" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none uppercase">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tên Kho <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="editForm.name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Địa Chỉ</label>
                        <textarea name="address" x-model="editForm.address" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Trạng Thái <span class="text-rose-500">*</span></label>
                        <select name="is_active" x-model="editForm.is_active" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none cursor-pointer">
                            <option value="1">Hoạt động</option>
                            <option value="0">Khóa (Ngừng hoạt động)</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3 p-6 border-t border-slate-100 bg-slate-50/50 shrink-0">
                    <button type="button" @click="showEditModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition">
                        Hủy Bỏ
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
