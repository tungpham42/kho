@extends('layouts.app')
@section('header_title', 'Điều Chuyển Kho Nội Bộ')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <!-- Toolbar -->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Danh sách luân chuyển</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Quản lý các lệnh điều chuyển hàng hóa giữa các kho</p>
        </div>
        <a href="{{ route('transfers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Lập Phiếu Chuyển
        </a>
    </div>

    <!-- Table content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Mã Phiếu</th>
                    <th class="p-4">Ngày Chuyển</th>
                    <th class="p-4">Từ Kho (Xuất)</th>
                    <th class="p-4">Đến Kho (Nhập)</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-center pr-6">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transfers ?? [] as $transfer)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6 font-extrabold text-slate-800">{{ $transfer->code }}</td>
                    <td class="p-4 text-slate-600 font-medium">{{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d/m/Y H:i') }}</td>
                    <td class="p-4 font-bold text-rose-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        {{ $transfer->fromWarehouse->name ?? 'N/A' }}
                    </td>
                    <td class="p-4 font-bold text-emerald-600">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            {{ $transfer->toWarehouse->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        @if($transfer->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                Đang chờ duyệt
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                Đã hoàn thành
                            </span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 flex justify-center gap-2">
                        @if($transfer->status == 'pending')
                            <form action="{{ route('transfers.approve', $transfer->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                    Duyệt Phiếu
                                </button>
                            </form>
                        @else
                            <span class="text-slate-300 font-medium text-sm italic">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Chưa có phiếu chuyển kho nào.</p>
                        <a href="{{ route('transfers.create') }}" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Tạo phiếu đầu tiên</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
