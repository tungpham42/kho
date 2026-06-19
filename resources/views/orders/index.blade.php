@extends('layouts.app')
@section('title', 'Phiếu Nhập / Xuất Kho')
@section('header_title', 'Phiếu Nhập / Xuất Kho')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <!-- Toolbar -->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Danh sách Chứng từ</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Quản lý toàn bộ giao dịch nhập, xuất và trả hàng</p>
        </div>
        <a href="{{ route('orders.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Lập Phiếu Mới
        </a>
    </div>

    <!-- Table content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Mã Phiếu</th>
                    <th class="p-4">Thời Gian</th>
                    <th class="p-4">Phân Loại</th>
                    <th class="p-4">Kho Hàng</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-center pr-6">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders ?? [] as $order)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6 font-extrabold text-slate-800">{{ $order->code }}</td>
                    <td class="p-4 text-slate-600 font-medium">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                    <td class="p-4">
                        @if($order->type == 'import')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                Nhập kho
                            </span>
                        @elseif($order->type == 'export')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                Xuất kho
                            </span>
                        @elseif($order->type == 'customer_return')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                                Khách trả hàng
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                Trả hàng NCC
                            </span>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-slate-700">{{ $order->warehouse->name ?? 'N/A' }}</td>
                    <td class="p-4 text-center">
                        @if($order->status == 'draft')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                Bản Nháp
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                Đã Hoàn Thành
                            </span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 flex justify-center gap-2">
                        @if($order->status == 'draft')
                            <form action="{{ route('orders.approve', $order->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-white font-bold bg-indigo-50 hover:bg-indigo-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                    Duyệt
                                </button>
                            </form>
                        @endif
                        <form id="del-ord-{{ $order->id }}" action="{{ route('orders.destroy', $order->id) }}" method="POST" class="m-0">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('del-ord-{{ $order->id }}')" class="text-rose-500 hover:text-white font-bold bg-rose-50 hover:bg-rose-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Chưa có chứng từ nào được tạo.</p>
                        <a href="{{ route('orders.create') }}" class="text-emerald-600 font-bold hover:underline mt-2 inline-block">Bắt đầu tạo phiếu ngay</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
