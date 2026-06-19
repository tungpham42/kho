@extends('layouts.app')
@section('title', 'Quản lý Kiểm kê kho')
@section('header_title', 'Quản lý Kiểm kê kho')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Danh sách Phiếu Kiểm Kê</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Theo dõi đối soát và cân bằng tồn kho thực tế</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <form action="{{ route('stocktakes.index') }}" method="GET" class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã phiếu..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none placeholder-slate-400">
            </form>

            <a href="{{ route('stocktakes.create') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Lập Phiếu Mới
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                    <th class="p-4 pl-6">Mã Phiếu</th>
                    <th class="p-4">Ngày Kiểm Kê</th>
                    <th class="p-4">Kho Thực Hiện</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-center pr-6">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($stocktakes ?? [] as $st)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="p-4 pl-6">
                        <span class="font-extrabold text-slate-800">{{ $st->code }}</span>
                    </td>
                    <td class="p-4 text-slate-600 font-medium">
                        {{ \Carbon\Carbon::parse($st->created_at)->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-4 font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        {{ $st->warehouse->name ?? 'N/A' }}
                    </td>
                    <td class="p-4 text-center">
                        @if($st->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                Đang kiểm kê
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                Đã cân bằng
                            </span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 flex justify-center gap-2">
                        @if($st->status == 'pending')
                            <form action="{{ route('stocktakes.approve', $st->id) }}" method="POST" class="m-0 inline-block">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:text-white font-bold bg-blue-50 hover:bg-blue-600 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                    Cân bằng kho
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Chưa có phiếu kiểm kê nào trong hệ thống.</p>
                        <a href="{{ route('stocktakes.create') }}" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Tạo phiếu kiểm kê đầu tiên</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
