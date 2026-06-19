@extends('layouts.app')
@section('title', 'Danh mục Đối tác')
@section('header_title', 'Danh mục Đối tác')

@section('content')
<div x-data="{
        showCreateModal: false,
        showEditModal: false,
        editForm: { id: '', type: 'supplier', code: '', name: '', phone: '' },
        openEdit(partner) {
            this.editForm = partner;
            this.showEditModal = true;
        }
    }"
    class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">

        <form method="GET" action="{{ route('partners.index') }}" class="flex flex-col sm:flex-row w-full sm:w-auto gap-3">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã, tên, SĐT..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
            </div>

            <div class="relative w-full sm:w-48">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <select name="type" class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer" onchange="this.form.submit()">
                    <option value="">Tất cả phân loại</option>
                    <option value="supplier" {{ request('type') == 'supplier' ? 'selected' : '' }}>Nhà cung cấp</option>
                    <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="both" {{ request('type') == 'both' ? 'selected' : '' }}>Song phương</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <button type="submit" class="hidden">Lọc</button>
        </form>

        <button @click="showCreateModal = true" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm Đối Tác
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Mã Đối Tác</th>
                    <th class="p-4">Tên Đối Tác</th>
                    <th class="p-4">Phân Loại</th>
                    <th class="p-4">Điện Thoại</th>
                    <th class="p-4 text-center pr-6">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($partners ?? [] as $partner)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6 font-extrabold text-slate-800">{{ $partner->code }}</td>
                    <td class="p-4 font-bold text-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ mb_substr($partner->name, 0, 1) }}
                            </div>
                            {{ $partner->name }}
                        </div>
                    </td>
                    <td class="p-4">
                        @if($partner->type == 'supplier')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-violet-50 text-violet-700 border border-violet-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Nhà cung cấp
                            </span>
                        @elseif($partner->type == 'customer')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Khách hàng
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                Song phương
                            </span>
                        @endif
                    </td>
                    <td class="p-4 text-slate-600 font-medium">
                        @if($partner->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $partner->phone }}
                            </div>
                        @else
                            <span class="text-slate-300 italic">-</span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                @click="openEdit({ id: '{{ $partner->id }}', type: '{{ $partner->type }}', code: '{{ addslashes($partner->code) }}', name: '{{ addslashes($partner->name) }}', phone: '{{ addslashes($partner->phone) }}' })"
                                class="text-indigo-600 hover:text-white font-bold bg-indigo-50 hover:bg-indigo-600 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                Sửa
                            </button>
                            <form id="del-pn-{{ $partner->id }}" action="{{ route('partners.destroy', $partner->id) }}" method="POST" class="m-0 inline-block">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete('del-pn-{{ $partner->id }}')" class="text-rose-500 hover:text-white font-bold bg-rose-50 hover:bg-rose-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
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
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Không tìm thấy đối tác nào phù hợp.</p>
                        <button @click="showCreateModal = true" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Thêm đối tác ngay</button>
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
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg border border-slate-100 flex flex-col max-h-[90vh] overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="font-extrabold text-xl text-slate-900">Thêm Đối Tác Mới</h3>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('partners.store') }}" method="POST" class="flex flex-col overflow-hidden">
                @csrf

                <div class="p-6 sm:p-8 space-y-5 overflow-y-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Phân Loại <span class="text-rose-500">*</span></label>
                            <select name="type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                                <option value="supplier">Nhà cung cấp</option>
                                <option value="customer">Khách hàng</option>
                                <option value="both">Song phương</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mã Đối Tác <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" required placeholder="VD: NCC01" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400 uppercase">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tên Đối Tác <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Công ty TNHH ABC" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Số điện thoại</label>
                        <input type="text" name="phone" placeholder="0901234567" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
                    </div>
                </div>

                <div class="flex justify-end gap-3 p-6 border-t border-slate-100 bg-slate-50/50 shrink-0">
                    <button type="button" @click="showCreateModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition">
                        Hủy Bỏ
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Lưu Đối Tác
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
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg border border-slate-100 flex flex-col max-h-[90vh] overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="font-extrabold text-xl text-slate-900">Cập Nhật Đối Tác</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'{{ route('partners.index') }}/' + editForm.id" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-5 overflow-y-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Phân Loại <span class="text-rose-500">*</span></label>
                            <select name="type" x-model="editForm.type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                                <option value="supplier">Nhà cung cấp</option>
                                <option value="customer">Khách hàng</option>
                                <option value="both">Song phương</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mã Đối Tác <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" x-model="editForm.code" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none uppercase">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tên Đối Tác <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="editForm.name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Số điện thoại</label>
                        <input type="text" name="phone" x-model="editForm.phone" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
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
