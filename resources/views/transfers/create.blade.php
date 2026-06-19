@extends('layouts.app')
@section('header_title', 'Lập Phiếu Điều Chuyển Kho')

@section('content')
<div class="mb-6">
    <a href="{{ route('transfers.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Quay lại danh sách
    </a>
</div>

<form action="{{ route('transfers.store') }}" method="POST" x-data="transferForm()">
    @csrf

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
        <div class="p-6 sm:p-8">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">1</span>
                Thông Tin Luân Chuyển
            </h2>

            @if ($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-r-xl mb-6 text-sm font-medium">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Từ Kho (Xuất đi) <span class="text-rose-500">*</span></label>
                    <select name="from_warehouse_id" x-model="from_warehouse" required class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition outline-none">
                        <option value="">-- Chọn Kho Xuất --</option>
                        @foreach($warehouses as $wh) <option value="{{ $wh->id }}">{{ $wh->name }}</option> @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Đến Kho (Nhập vào) <span class="text-rose-500">*</span></label>
                    <select name="to_warehouse_id" x-model="to_warehouse" required class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition outline-none">
                        <option value="">-- Chọn Kho Nhập --</option>
                        @foreach($warehouses as $wh) <option value="{{ $wh->id }}">{{ $wh->name }}</option> @endforeach
                    </select>

                    <p x-cloak x-show="isSameWarehouse" class="text-rose-500 text-xs mt-2 font-bold flex items-center gap-1 bg-rose-50 p-2 rounded-lg inline-flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Kho xuất và nhập không được trùng!
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ngày Chuyển <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="transfer_date" required value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition outline-none">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">2</span>
                Danh Sách Mặt Hàng
            </h2>
            <button type="button" @click="addItem()" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold py-2.5 px-5 rounded-xl transition flex items-center gap-2 justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Thêm Dòng Mới
            </button>
        </div>

        <div class="overflow-x-auto p-4 sm:p-6">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase tracking-wider font-bold border-b-2 border-slate-100">
                        <th class="p-3 w-12 text-center">STT</th>
                        <th class="p-3 w-1/2">Sản Phẩm</th>
                        <th class="p-3 w-32 text-center">ĐVT</th>
                        <th class="p-3 w-40 text-right">Số Lượng</th>
                        <th class="p-3 w-16 text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 text-center text-slate-400 font-bold" x-text="index + 1"></td>
                            <td class="p-3">
                                <select :name="`details[${index}][product_id]`" x-model="item.product_id" @change="onProductChange(index)" required class="w-full border border-slate-200 bg-white rounded-lg p-2.5 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                                    <option value="">-- Chọn sản phẩm --</option>
                                    <template x-for="product in products" :key="product.id">
                                        <option :value="product.id" x-text="product.sku + ' - ' + product.name"></option>
                                    </template>
                                </select>
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" x-model="item.unit_name" readonly class="w-full bg-slate-50 border-transparent text-center rounded-lg p-2.5 text-sm font-bold text-slate-500 outline-none">
                            </td>
                            <td class="p-3">
                                <input type="number" step="0.01" min="0.01" :name="`details[${index}][quantity]`" x-model.number="item.quantity" required class="w-full border border-slate-200 bg-white rounded-lg p-2.5 text-sm font-medium text-slate-700 text-right focus:ring-2 focus:ring-indigo-500 outline-none transition">
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" @click="removeItem(index)" class="text-rose-400 hover:text-rose-600 p-2 rounded-lg hover:bg-rose-50 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
            <a href="{{ route('transfers.index') }}" class="px-8 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition text-center">
                Hủy Bỏ
            </a>
            <button type="submit"
                :disabled="isSameWarehouse"
                :class="isSameWarehouse ? 'opacity-50 cursor-not-allowed bg-slate-400' : 'bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5'"
                class="px-8 py-3 text-white font-bold rounded-xl transition-all text-center">
                Hoàn Tất & Lưu
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('transferForm', () => ({
            products: @json($products),
            items: [], from_warehouse: '', to_warehouse: '',
            init() { this.addItem(); },
            get isSameWarehouse() { return this.from_warehouse !== '' && this.to_warehouse !== '' && this.from_warehouse === this.to_warehouse; },
            addItem() { this.items.push({ product_id: '', unit_name: '', quantity: 1 }); },
            removeItem(index) { this.items.splice(index, 1); if(this.items.length === 0) { this.addItem(); } },
            onProductChange(index) {
                let pid = this.items[index].product_id;
                let product = this.products.find(p => p.id == pid);
                this.items[index].unit_name = product ? product.unit : '';
            }
        }))
    })
</script>
@endsection
