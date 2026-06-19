@extends('layouts.app')
@section('title', 'Tổng quan Bảng điều khiển')
@section('header_title', 'Tổng quan Bảng điều khiển')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-8 flex justify-between items-center text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-16 -mr-16 opacity-10">
            <svg width="200" height="200" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="20" fill="none"></circle></svg>
        </div>

        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold tracking-tight mb-2">Xin chào, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-indigo-100 text-lg font-medium">Chào mừng bạn trở lại không gian quản lý kho của <span class="text-white font-black">{{ auth()->user()->company_name ?? 'doanh nghiệp' }}</span>.</p>
        </div>
        <div class="hidden md:block text-right relative z-10 bg-white/10 px-6 py-3 rounded-xl backdrop-blur-sm border border-white/20">
            <p class="text-sm text-indigo-100 font-medium mb-1 uppercase tracking-wider">Hôm nay</p>
            <p class="text-xl font-black">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 group hover:border-indigo-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hàng Hóa</p>
                    <p class="text-3xl font-black text-slate-800 mt-2">{{ \App\Models\Product::count() }}</p>
                </div>
                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 group hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kho Bãi</p>
                    <p class="text-3xl font-black text-slate-800 mt-2">{{ \App\Models\Warehouse::count() }}</p>
                </div>
                <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 group hover:border-amber-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Đối Tác</p>
                    <p class="text-3xl font-black text-slate-800 mt-2">{{ \App\Models\Partner::count() }}</p>
                </div>
                <div class="p-3.5 bg-amber-50 text-amber-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 group hover:border-rose-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Chứng Từ</p>
                    <p class="text-3xl font-black text-slate-800 mt-2">{{ \App\Models\Order::count() }}</p>
                </div>
                <div class="p-3.5 bg-rose-50 text-rose-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 group hover:border-sky-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kiểm Kê</p>
                    <p class="text-3xl font-black text-slate-800 mt-2">{{ class_exists('\App\Models\Stocktake') ? \App\Models\Stocktake::count() : 0 }}</p>
                </div>
                <div class="p-3.5 bg-sky-50 text-sky-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Thao tác nhanh
            </h3>
        </div>

        <div class="p-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
            <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-indigo-50 hover:border-indigo-200 hover:shadow-sm transition-all group">
                <svg class="w-10 h-10 mb-3 text-indigo-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-700 text-center">Sản phẩm</span>
            </a>

            <a href="{{ route('orders.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-emerald-50 hover:border-emerald-200 hover:shadow-sm transition-all group">
                <svg class="w-10 h-10 mb-3 text-emerald-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-bold text-slate-600 group-hover:text-emerald-700 text-center">Lập Phiếu</span>
            </a>

            <a href="{{ route('transfers.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-purple-50 hover:border-purple-200 hover:shadow-sm transition-all group">
                <svg class="w-10 h-10 mb-3 text-purple-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                <span class="text-sm font-bold text-slate-600 group-hover:text-purple-700 text-center">Chuyển kho</span>
            </a>

            <a href="{{ route('stocktakes.create') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-sky-50 hover:border-sky-200 hover:shadow-sm transition-all group">
                <svg class="w-10 h-10 mb-3 text-sky-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span class="text-sm font-bold text-slate-600 group-hover:text-sky-700 text-center">Kiểm kê</span>
            </a>

            <a href="{{ route('inventories.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-amber-50 hover:border-amber-200 hover:shadow-sm transition-all group">
                <svg class="w-10 h-10 mb-3 text-amber-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="text-sm font-bold text-slate-600 group-hover:text-amber-700 text-center">Báo cáo tồn</span>
            </a>

            <a href="{{ route('settings.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-slate-200 hover:border-slate-300 hover:shadow-sm transition-all group">
                <svg class="w-10 h-10 mb-3 text-slate-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-sm font-bold text-slate-600 group-hover:text-slate-800 text-center">Cấu hình</span>
            </a>
        </div>
    </div>
</div>
@endsection
