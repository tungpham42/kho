@extends('layouts.app')
@section('title', 'Cấu hình Hệ thống')
@section('header_title', 'Cấu hình Hệ thống')

@section('content')
<form action="{{ route('settings.store') }}" method="POST" class="space-y-6 max-w-5xl mx-auto">
    @csrf

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Thông Tin Doanh Nghiệp</h2>
                <p class="text-sm font-medium text-slate-500 mt-0.5">Sử dụng để hiển thị trên các mẫu in chứng từ</p>
            </div>
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Tên Doanh Nghiệp / Cửa Hàng <span class="text-rose-500">*</span></label>
                <input type="text" name="company_name" value="{{ old('company_name', $setting->company_name) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email Liên Hệ</label>
                <input type="email" name="company_email" value="{{ old('company_email', $setting->company_email) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Số Điện Thoại</label>
                <input type="text" name="company_phone" value="{{ old('company_phone', $setting->company_phone) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Địa Chỉ Chi Tiết</label>
                <textarea name="company_address" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none resize-none">{{ old('company_address', $setting->company_address) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Cấu Hình Tiền Tố (Prefix)</h2>
                <p class="text-sm font-medium text-slate-500 mt-0.5">Tự động gắn vào mã chứng từ khi hệ thống phát sinh</p>
            </div>
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tiền tố Phiếu Nhập/Xuất <span class="text-rose-500">*</span></label>
                <input type="text" name="order_prefix" value="{{ old('order_prefix', $setting->order_prefix) }}" required placeholder="VD: ORD-" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all outline-none uppercase">
                <p class="text-xs font-medium text-slate-400 mt-2">Mã mẫu: <span class="text-emerald-600 font-bold">{{ $setting->order_prefix }}</span>12345</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tiền tố Chuyển Kho <span class="text-rose-500">*</span></label>
                <input type="text" name="transfer_prefix" value="{{ old('transfer_prefix', $setting->transfer_prefix) }}" required placeholder="VD: TRF-" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all outline-none uppercase">
                <p class="text-xs font-medium text-slate-400 mt-2">Mã mẫu: <span class="text-emerald-600 font-bold">{{ $setting->transfer_prefix }}</span>12345</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tiền tố Kiểm Kê <span class="text-rose-500">*</span></label>
                <input type="text" name="stocktake_prefix" value="{{ old('stocktake_prefix', $setting->stocktake_prefix) }}" required placeholder="VD: STK-" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all outline-none uppercase">
                <p class="text-xs font-medium text-slate-400 mt-2">Mã mẫu: <span class="text-emerald-600 font-bold">{{ $setting->stocktake_prefix }}</span>12345</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-4">
        <button type="submit" class="px-10 py-3.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg hover:shadow-slate-500/30 hover:-translate-y-0.5 transition-all text-center flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Lưu Cấu Hình
        </button>
    </div>
</form>
@endsection
