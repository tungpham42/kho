@extends('layouts.app')
@section('title', 'Lập Phiếu Nhập / Xuất Kho')
@section('header_title', 'Lập Phiếu Nhập / Xuất Kho')

@section('content')
<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Quay lại danh sách
    </a>
</div>

<form action="{{ route('orders.store') }}" method="POST" x-data="orderForm()">
    @csrf

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
        <div class="p-6 sm:p-8">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">1</span>
                Thông Tin Chứng Từ
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Loại Chứng Từ <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition outline-none">
                        <option value="import">Nhập Kho (Mua hàng)</option>
                        <option value="export">Xuất Kho (Bán hàng)</option>
                        <option value="customer_return">Khách trả hàng (Nhập lại)</option>
                        <option value="supplier_return">Trả hàng NCC (Xuất đi)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kho Thực Hiện <span class="text-rose-500">*</span></label>
                    <select name="warehouse_id" required class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition outline-none">
                        <option value="">-- Chọn Kho --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Đối Tác (NCC / Khách Hàng)</label>
                    <select name="partner_id" class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition outline-none">
                        <option value="">-- Nội bộ (Bỏ qua) --</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->name }} ({{ $partner->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ngày Lập <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="order_date" required value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="w-full border-slate-200 rounded-xl bg-slate-50 border p-3 font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition outline-none">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">2</span>
                Chi Tiết Hàng Hóa
            </h2>
            <button type="button" @click="addItem()" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold py-2.5 px-5 rounded-xl transition flex items-center gap-2 justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Thêm Dòng Mới
            </button>
        </div>

        <div class="overflow-x-auto p-4 sm:p-6">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase tracking-wider font-bold border-b-2 border-slate-100">
                        <th class="p-3 w-12 text-center">STT</th>
                        <th class="p-3 w-1/3">Sản Phẩm</th>
                        <th class="p-3 w-24 text-center">ĐVT</th>
                        <th class="p-3 w-32 text-right">Số Lượng</th>
                        <th class="p-3 w-40 text-right">Đơn Giá</th>
                        <th class="p-3 w-40 text-right">Thành Tiền</th>
                        <th class="p-3 w-16 text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 text-center text-slate-400 font-bold" x-text="index + 1"></td>
                            <td class="p-3">
                                <select :name="`details[${index}][product_id]`" x-model="item.product_id" @change="onProductChange(index)" required class="w-full border border-slate-200 bg-white rounded-lg p-2.5 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                                    <option value="">-- Chọn sản phẩm --</option>
                                    <template x-for="product in products" :key="product.id">
                                        <option :value="product.id" x-text="product.sku + ' - ' + product.name"></option>
                                    </template>
                                </select>
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" :name="`details[${index}][unit_name]`" x-model="item.unit_name" readonly class="w-full bg-slate-50 border-transparent text-center rounded-lg p-2.5 text-sm font-bold text-slate-500 outline-none">
                            </td>
                            <td class="p-3">
                                <input type="number" step="0.01" min="0.01" :name="`details[${index}][quantity]`" x-model.number="item.quantity" required class="w-full border border-slate-200 bg-white rounded-lg p-2.5 text-sm font-bold text-slate-700 text-right focus:ring-2 focus:ring-emerald-500 outline-none transition">
                                <input type="hidden" :name="`details[${index}][base_quantity]`" :value="item.quantity">
                            </td>
                            <td class="p-3">
                                <input type="number" step="0.01" min="0" :name="`details[${index}][price]`" x-model.number="item.price" required class="w-full border border-slate-200 bg-white rounded-lg p-2.5 text-sm font-bold text-slate-700 text-right focus:ring-2 focus:ring-emerald-500 outline-none transition">
                            </td>
                            <td class="p-3 text-right font-black text-slate-800" x-text="formatCurrency(item.quantity * item.price)"></td>
                            <td class="p-3 text-center">
                                <button type="button" @click="removeItem(index)" class="text-rose-400 hover:text-rose-600 p-2 rounded-lg hover:bg-rose-50 transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50/80 border-t-2 border-slate-200">
                        <td colspan="5" class="p-5 text-right font-bold text-slate-600 text-sm uppercase tracking-wider">Tổng Giá Trị:</td>
                        <td class="p-5 text-right font-black text-emerald-600 text-xl" x-text="formatCurrency(grandTotal)"></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
            <a href="{{ route('orders.index') }}" class="px-8 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition text-center">
                Hủy Bỏ
            </a>
            <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all text-center">
                Lưu Phiếu Nháp
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderForm', () => ({
            products: @json($products),
            items: [],
            init() { this.addItem(); },
            addItem() { this.items.push({ product_id: '', unit_name: '', quantity: 1, price: 0 }); },
            removeItem(index) {
                this.items.splice(index, 1);
                if(this.items.length === 0) { this.addItem(); }
            },
            onProductChange(index) {
                let pid = this.items[index].product_id;
                let product = this.products.find(p => p.id == pid);
                if(product) {
                    this.items[index].unit_name = product.unit;
                    this.items[index].price = product.sale_price || 0;
                } else {
                    this.items[index].unit_name = '';
                    this.items[index].price = 0;
                }
            },
            get grandTotal() {
                return this.items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            },
            formatCurrency(value) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value || 0);
            }
        }))
    })
</script>
@endsection
