@extends('layouts.app')
@section('title', 'Báo Cáo Tồn Kho Thực Tế')
@section('header_title', 'Báo Cáo Tồn Kho Thực Tế')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-slate-100 bg-white">
        <form action="{{ route('inventories.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4">

            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <select name="warehouse_id" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                    <option value="">Tất cả kho bãi</option>
                    @foreach($warehouses ?? [] as $wh)
                        <option value="{{ $wh->id }}" {{ request('warehouse_id') == $wh->id ? 'selected' : '' }}>
                            {{ $wh->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="relative w-full sm:flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo SKU, tên sản phẩm..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none placeholder-slate-400">
            </div>

            @if(request('warehouse_id') || request('search'))
                <a href="{{ route('inventories.index') }}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center">
                    Xóa lọc
                </a>
            @endif

            <button type="submit" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-slate-500/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Lọc Dữ Liệu
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Kho Chứa</th>
                    <th class="p-4">Sản Phẩm (SKU)</th>
                    <th class="p-4">Số Lô / Date</th>
                    <th class="p-4 text-right pr-6">Tồn Kho Thực Tế</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($inventories ?? [] as $inv)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6 font-bold text-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            {{ $inv->warehouse->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="font-extrabold text-indigo-600 tracking-tight">{{ $inv->product->sku ?? '' }}</div>
                        <div class="text-sm font-medium text-slate-500 mt-0.5">{{ $inv->product->name ?? '' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col gap-1.5 items-start">
                            <!-- Hiển thị Số Lô -->
                            <span class="inline-block bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-md border border-slate-200">
                                Lô: {{ $inv->batch_number ?: 'N/A' }}
                            </span>

                            <!-- Hiển thị Date (Hạn Sử Dụng) -->
                            @if(!empty($inv->expiry_date))
                                @php
                                    // Kiểm tra xem đã quá hạn hay chưa
                                    $isExpired = \Carbon\Carbon::parse($inv->expiry_date)->isPast();
                                @endphp
                                <span class="inline-flex items-center gap-1 text-xs font-bold {{ $isExpired ? 'text-red-600 bg-red-100 border-red-200' : 'text-emerald-600 bg-emerald-50 border-emerald-100' }} px-2.5 py-1 rounded-md border">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    HSD: {{ \Carbon\Carbon::parse($inv->expiry_date)->format('d/m/Y') }}
                                    @if($isExpired)
                                        (Đã hết hạn)
                                    @endif
                                </span>
                            @else
                                <span class="inline-block bg-slate-50 text-slate-400 text-xs font-bold px-2.5 py-1 rounded-md border border-slate-100">
                                    Không có HSD
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="p-4 text-right pr-6">
                        <div class="flex items-baseline justify-end gap-1.5">
                            <span class="font-black text-xl {{ $inv->quantity <= 0 ? 'text-rose-500' : 'text-emerald-600' }}">
                                {{ number_format($inv->quantity, 2) }}
                            </span>
                            <span class="text-sm font-bold text-slate-400">{{ $inv->product->unit ?? '' }}</span>
                        </div>
                        @if($inv->quantity <= 0)
                            <div class="text-xs font-semibold text-rose-500 mt-1">Hết hàng</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Không tìm thấy dữ liệu tồn kho nào khớp với tìm kiếm của bạn.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
