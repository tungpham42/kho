@extends('layouts.app')
@section('header_title', 'Tổng quan Bảng điều khiển')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Xin chào, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-gray-600 mt-1">Chào mừng bạn đến với không gian quản lý kho của <span class="font-semibold text-blue-600">{{ auth()->user()->company_name ?? 'doanh nghiệp' }}</span>.</p>
        </div>
        <div class="hidden md:block text-right">
            <p class="text-sm text-gray-500">Ngày hiện tại</p>
            <p class="text-lg font-semibold text-gray-700">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Hàng Hóa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Product::count() }}</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Kho Bãi</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Warehouse::count() }}</p>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Đối Tác</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Partner::count() }}</p>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Phiếu Nhập/Xuất</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Order::count() }}</p>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-4 border-b bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-semibold text-gray-700">Thao tác nhanh</h3>
        </div>
        <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-200 transition group">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📦</span>
                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Quản lý Sản phẩm</span>
            </a>

            <a href="{{ route('orders.index') }}" class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-green-50 hover:border-green-200 transition group">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📝</span>
                <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">Lập Phiếu Nhập/Xuất</span>
            </a>

            <a href="{{ route('inventories.index') }}" class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-yellow-50 hover:border-yellow-200 transition group">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📊</span>
                <span class="text-sm font-medium text-gray-700 group-hover:text-yellow-700">Xem Báo cáo Tồn kho</span>
            </a>

            <a href="{{ route('transfers.index') }}" class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-purple-50 hover:border-purple-200 transition group">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">🔄</span>
                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Chuyển kho nội bộ</span>
            </a>
        </div>
    </div>
</div>
@endsection
