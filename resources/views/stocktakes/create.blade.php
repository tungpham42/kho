@extends('layouts.app')
@section('title', 'Lập Phiếu Kiểm Kê')
@section('header_title', 'Lập Phiếu Kiểm Kê')

@section('content')
<div class="mb-6">
    <a href="{{ route('stocktakes.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Quay lại danh sách
    </a>
</div>

<form action="{{ route('stocktakes.store') }}" method="POST" x-data="stocktakeForm()">
    @csrf

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
        <div class="p-6 sm:p-8">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">1</span>
                Thông Tin Cơ Bản
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kho Cần Kiểm Kê <span class="text-rose-500">*</span></label>
                    <select name="warehouse_id" required class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-blue-500 focus:bg-white transition outline-none cursor-pointer">
                        <option value="">-- Chọn Kho --</option>
                        @foreach($warehouses ?? [] as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ghi chú phiếu</label>
                    <input type="text" name="note" placeholder="VD: Kiểm kê định kỳ tháng 10" class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-blue-500 focus:bg-white transition outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ngày Kiểm Kê <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="stocktake_date" required value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-blue-500 focus:bg-white transition outline-none">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">2</span>
                Chi Tiết Cân Bằng Kho
            </h2>
            <button type="button" @click="addItem()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 font-bold py-2.5 px-5 rounded-xl transition flex items-center gap-2 justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Thêm Sản Phẩm
            </button>
        </div>

        <div class="overflow-x-auto p-4 sm:p-6">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase tracking-wider font-bold border-b-2 border-slate-100">
                        <th class="p-3 w-12 text-center">STT</th>
                        <th class="p-3 w-1/3">Sản Phẩm</th>
                        <th class="p-3 w-32 text-center">ĐVT</th>
                        <th class="p-3 w-32 text-right text-slate-400">Tồn Hệ Thống</th>
                        <th class="p-3 w-32 text-right text-blue-600">Tồn Thực Tế</th>
                        <th class="p-3 w-32 text-center">Chênh Lệch</th>
                        <th class="p-3 w-16 text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 text-center text-slate-400 font-bold" x-text="index + 1"></td>
                            <td class="p-3">
                                <select :name="`details[${index}][product_id]`" x-model="item.product_id" @change="onProductChange(index)" required class="w-full border border-slate-200 bg-white rounded-lg p-2.5 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none transition">
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
                                <input type="number" step="0.01" :name="`details[${index}][system_qty]`" x-model.number="item.system_qty" readonly class="w-full bg-slate-100 border-transparent rounded-lg p-2.5 text-sm font-bold text-slate-400 text-right outline-none cursor-not-allowed">
                            </td>
                            <td class="p-3">
                                <input type="number" step="0.01" min="0" :name="`details[${index}][actual_qty]`" x-model.number="item.actual_qty" required class="w-full border border-blue-200 bg-blue-50 rounded-lg p-2.5 text-sm font-black text-blue-700 text-right focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                            </td>
                            <td class="p-3 text-center">
                                <span :class="{
                                        'bg-slate-100 text-slate-600': (item.actual_qty - item.system_qty) === 0,
                                        'bg-emerald-100 text-emerald-700': (item.actual_qty - item.system_qty) > 0,
                                        'bg-rose-100 text-rose-700': (item.actual_qty - item.system_qty) < 0
                                    }"
                                    class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-sm font-black w-full border border-transparent border-opacity-50"
                                    x-text="formatDiff(item.actual_qty - item.system_qty)">
                                </span>
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
            <a href="{{ route('stocktakes.index') }}" class="px-8 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition text-center">
                Hủy Bỏ
            </a>
            <button type="submit" name="action" value="draft" class="px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg hover:shadow-slate-500/30 hover:-translate-y-0.5 transition-all text-center">
                Lưu Nháp
            </button>
            <button type="submit" name="action" value="complete" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all text-center">
                Lưu & Cân Bằng Kho
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('stocktakeForm', () => ({
            products: @json($products ?? []),
            items: [],

            init() {
                this.addItem();
            },

            addItem() {
                this.items.push({ product_id: '', unit_name: '', system_qty: 0, actual_qty: 0 });
            },

            removeItem(index) {
                this.items.splice(index, 1);
                if(this.items.length === 0) { this.addItem(); }
            },

            onProductChange(index) {
                let pid = this.items[index].product_id;
                let product = this.products.find(p => p.id == pid);
                if(product) {
                    this.items[index].unit_name = product.unit;
                    // LƯU Ý LẬP TRÌNH: Tại đây bạn cần gọi API hoặc map dữ liệu tồn kho hiện tại (system_qty) của sản phẩm đó trong kho đang được chọn.
                    // Tạm thời set = 0 để làm demo.
                    this.items[index].system_qty = 0;
                    this.items[index].actual_qty = 0;
                } else {
                    this.items[index].unit_name = '';
                    this.items[index].system_qty = 0;
                    this.items[index].actual_qty = 0;
                }
            },

            formatDiff(value) {
                if(value > 0) return '+' + value;
                return value;
            }
        }))
    })
</script>
@endsection
