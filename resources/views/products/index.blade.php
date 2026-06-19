@extends('layouts.app')
@section('header_title', 'Danh mục Hàng hóa')

@section('content')
<div x-data="{ showModal: false }" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <!-- Toolbar -->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" placeholder="Tìm kiếm SKU, Tên sản phẩm..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
        </div>

        <button @click="showModal = true" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm Hàng Hóa
        </button>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Mã Hàng (SKU)</th>
                    <th class="p-4">Tên Sản Phẩm</th>
                    <th class="p-4">Đơn Vị</th>
                    <th class="p-4 text-right">Giá Bán</th>
                    <th class="p-4 text-center pr-6">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products ?? [] as $p)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6">
                        <span class="font-extrabold text-indigo-600 tracking-tight">{{ $p->sku }}</span>
                    </td>
                    <td class="p-4 font-bold text-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            {{ $p->name }}
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $p->unit }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <span class="font-black text-slate-800">{{ number_format($p->sale_price) }}</span>
                        <span class="text-sm font-semibold text-slate-400 ml-1">đ</span>
                    </td>
                    <td class="p-4 pr-6 text-center">
                        <form id="del-p-{{ $p->id }}" action="{{ route('products.destroy', $p->id) }}" method="POST" class="m-0 inline-block">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('del-p-{{ $p->id }}')" class="text-rose-500 hover:text-white font-bold bg-rose-50 hover:bg-rose-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Kho hàng hiện tại đang trống.</p>
                        <button @click="showModal = true" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Thêm sản phẩm đầu tiên</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form (Alpine.js) -->
    <div x-cloak x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-sm"
         x-transition:leave-end="opacity-0 backdrop-blur-none"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4">

        <div @click.away="showModal = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-xl text-slate-900">Thêm Sản Phẩm Mới</h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('products.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Mã SKU <span class="text-rose-500">*</span></label>
                        <input type="text" name="sku" required placeholder="VD: SP001" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400 uppercase">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Đơn vị gốc <span class="text-rose-500">*</span></label>
                        <input type="text" name="unit" required placeholder="Cái, Hộp, Thùng..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tên Sản Phẩm <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Nhập tên hàng hóa" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Giá Mua (VND)</label>
                        <input type="number" min="0" name="purchase_price" value="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-right">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Giá Bán (VND)</label>
                        <input type="number" min="0" name="sale_price" value="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-indigo-600 font-black rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-right">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
                    <button type="button" @click="showModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition">
                        Hủy Bỏ
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Lưu Sản Phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
