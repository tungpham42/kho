@extends('layouts.app')
@section('title', 'Danh mục Hàng hóa')
@section('header_title', 'Danh mục Hàng hóa')

@section('content')
<div x-data="{
        showCreateModal: false,
        showEditModal: false,
        showImportModal: false,
        showScanner: false,
        html5QrcodeScanner: null,
        editForm: { id: '', sku: '', name: '', unit: '', purchase_price: 0, sale_price: 0 },
        openEdit(product) {
            this.editForm = product;
            this.showEditModal = true;
        },
        startScanner() {
            this.showScanner = true;
            this.$nextTick(() => {
                this.html5QrcodeScanner = new Html5QrcodeScanner(
                    'reader',
                    { fps: 10, qrbox: {width: 250, height: 250} },
                    false
                );

                this.html5QrcodeScanner.render((decodedText, decodedResult) => {
                    // Khi quét thành công -> Điền vào ô tìm kiếm và submit form
                    document.getElementById('searchInput').value = decodedText;
                    this.stopScanner();
                    document.getElementById('searchForm').submit();
                }, (error) => {
                    // Bỏ qua các lỗi cảnh báo trong quá trình camera đang cố lấy nét
                });
            });
        },
        stopScanner() {
            if (this.html5QrcodeScanner) {
                this.html5QrcodeScanner.clear();
                this.html5QrcodeScanner = null;
            }
            this.showScanner = false;
        }
    }"
    class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    @if(session('success'))
        <div class="m-6 mb-0 p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">
            <span class="font-bold">Thành công!</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="m-6 mb-0 p-4 mb-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">
            <span class="font-bold">Lỗi!</span> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="m-6 mb-0 p-4 mb-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">
            <ul class="list-disc list-inside font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">

        <div class="flex gap-2 w-full sm:w-auto">
            <form id="searchForm" action="{{ route('products.index') }}" method="GET" class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input id="searchInput" type="text" name="search" value="{{ request('search') }}" placeholder="Tìm SKU, Tên sản phẩm (Nhấn Enter)..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
            </form>

            <button @click="startScanner()" type="button" class="bg-slate-50 hover:bg-slate-100 text-slate-600 px-3 py-2.5 rounded-xl border border-slate-200 transition-colors shadow-sm flex items-center justify-center shrink-0" title="Quét Barcode / QR Code">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H5v3a1 1 0 01-2 0V4zm14-1a1 1 0 011 1v3a1 1 0 01-2 0V5h-3a1 1 0 010-2h4zM3 20a1 1 0 011-1h4a1 1 0 110 2H5v-3a1 1 0 01-2 0v3zm14-1a1 1 0 011 1v-3a1 1 0 112 0v3a1 1 0 01-1 1h-4a1 1 0 110-2h3z"></path></svg>
            </button>
        </div>

        <div class="flex flex-wrap items-center justify-end gap-3 w-full sm:w-auto mt-4 sm:mt-0">
            <a href="{{ route('products.export') }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 border border-emerald-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span class="hidden sm:inline">Xuất Excel</span>
            </a>

            <button @click="showImportModal = true" class="bg-amber-50 hover:bg-amber-100 text-amber-600 font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 border border-amber-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span class="hidden sm:inline">Nhập Excel</span>
            </button>

            <button @click="showCreateModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Thêm Mới
            </button>
        </div>
    </div>

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
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                @click="openEdit({ id: '{{ $p->id }}', sku: '{{ addslashes($p->sku) }}', name: '{{ addslashes($p->name) }}', unit: '{{ addslashes($p->unit) }}', purchase_price: '{{ $p->purchase_price ?? 0 }}', sale_price: '{{ $p->sale_price ?? 0 }}' })"
                                class="text-indigo-600 hover:text-white font-bold bg-indigo-50 hover:bg-indigo-600 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                Sửa
                            </button>
                            <form id="del-p-{{ $p->id }}" action="{{ route('products.destroy', $p->id) }}" method="POST" class="m-0 inline-block">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete('del-p-{{ $p->id }}')" class="text-rose-500 hover:text-white font-bold bg-rose-50 hover:bg-rose-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
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
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Kho hàng hiện tại đang trống (hoặc không tìm thấy kết quả).</p>
                        <button @click="showCreateModal = true" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Thêm sản phẩm ngay</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-cloak x-show="showScanner"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-sm"
         x-transition:leave-end="opacity-0 backdrop-blur-none"
         class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm px-4 py-8">

        <div @click.away="stopScanner()"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg border border-slate-100 flex flex-col overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-xl text-slate-900">Quét Barcode / QR Code</h3>
                <button @click="stopScanner()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6">
                <div id="reader" class="w-full rounded-xl overflow-hidden border-2 border-dashed border-slate-200"></div>
                <p class="text-sm text-center text-slate-500 mt-4 font-medium">Đưa mã vạch hoặc mã QR vào khung hình để quét tự động.</p>
            </div>
        </div>
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
                <h3 class="font-extrabold text-xl text-slate-900">Thêm Sản Phẩm Mới</h3>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('products.store') }}" method="POST" class="flex flex-col overflow-hidden">
                @csrf

                <div class="p-6 sm:p-8 space-y-5 overflow-y-auto">
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
                </div>

                <div class="flex justify-end gap-3 p-6 border-t border-slate-100 bg-slate-50/50 shrink-0">
                    <button type="button" @click="showCreateModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition">
                        Hủy Bỏ
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Lưu Sản Phẩm
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
                <h3 class="font-extrabold text-xl text-slate-900">Cập Nhật Sản Phẩm</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'{{ route('products.index') }}/' + editForm.id" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-5 overflow-y-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mã SKU <span class="text-rose-500">*</span></label>
                            <input type="text" name="sku" x-model="editForm.sku" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none uppercase">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Đơn vị gốc <span class="text-rose-500">*</span></label>
                            <input type="text" name="unit" x-model="editForm.unit" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tên Sản Phẩm <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="editForm.name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Giá Mua (VND)</label>
                            <input type="number" min="0" name="purchase_price" x-model="editForm.purchase_price" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-right">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Giá Bán (VND)</label>
                            <input type="number" min="0" name="sale_price" x-model="editForm.sale_price" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-indigo-600 font-black rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-right">
                        </div>
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

    <div x-cloak x-show="showImportModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-sm"
         x-transition:leave-end="opacity-0 backdrop-blur-none"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4 py-8">

        <div @click.away="showImportModal = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md border border-slate-100 flex flex-col overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="font-extrabold text-xl text-slate-900">Nhập Sản Phẩm Từ Excel</h3>
                <button @click="showImportModal = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
                @csrf
                <div class="p-6 sm:p-8 space-y-6">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Chọn file Excel (.xlsx, .csv)</label>
                        <input type="file" name="file" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                    </div>

                    <div class="text-center pt-2">
                        <a href="{{ route('products.template') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-bold inline-flex items-center gap-1 hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Tải file Excel mẫu
                        </a>
                    </div>
                </div>

                <div class="flex justify-end gap-3 p-6 border-t border-slate-100 bg-slate-50/50 shrink-0">
                    <button type="button" @click="showImportModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition">
                        Hủy Bỏ
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg hover:shadow-amber-500/30 hover:-translate-y-0.5 transition-all">
                        Bắt Đầu Nhập
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
@endsection
