<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | @yield('site_name', 'Hệ Thống Quản Lý Kho')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title') | @yield('site_name', 'Hệ Thống Quản Lý Kho')">
    <meta property="og:description" content="@yield('meta_description', 'Kho SaaS - Hệ Thống Quản Lý Kho')">
    <meta property="og:image" content="@yield('og_image', asset('img/og_image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'Hệ Thống Quản Lý Kho')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden backdrop-blur-sm transition-opacity"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-72 bg-[#0f172a] text-slate-300 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:w-64 border-r border-slate-800 shadow-2xl lg:shadow-none">
        <div class="h-20 flex items-center justify-center border-b border-slate-800/60 font-extrabold text-2xl tracking-tight text-white bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">
            KHO SAAS
        </div>
        <nav class="flex-1 px-4 py-8 space-y-1.5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('dashboard') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span class="font-medium">Tổng quan</span>
            </a>

            <div class="text-[11px] uppercase tracking-wider text-slate-500 mt-6 mb-3 font-bold px-4">Danh mục</div>
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('products*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Hàng hóa</a>
            <a href="{{ route('warehouses.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('warehouses*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Kho bãi</a>
            <a href="{{ route('partners.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('partners*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Đối tác</a>

            <div class="text-[11px] uppercase tracking-wider text-slate-500 mt-6 mb-3 font-bold px-4">Nghiệp vụ</div>
            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('orders*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Nhập / Xuất</a>
            <a href="{{ route('transfers.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('transfers*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Chuyển kho</a>
            <a href="{{ route('stocktakes.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('stocktakes*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Kiểm kê kho</a>

            <div class="text-[11px] uppercase tracking-wider text-slate-500 mt-6 mb-3 font-bold px-4">Báo cáo</div>
            <a href="{{ route('inventories.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('inventories*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Tồn kho</a>

            <div class="text-[11px] uppercase tracking-wider text-slate-500 mt-6 mb-3 font-bold px-4">Hệ thống</div>
            <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('settings*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">Cấu hình</a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full">
        <header class="h-20 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 z-10">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-indigo-600 focus:outline-none p-2 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">
                    @yield('header_title', 'Bảng điều khiển')
                </h1>
            </div>

            <div class="flex items-center gap-3 sm:gap-5">
                <div class="flex items-center gap-3 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-700 hidden sm:block">{{ auth()->user()->company_name ?? auth()->user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="p-2 sm:px-4 sm:py-2 rounded-xl text-sm font-bold text-rose-500 hover:text-white hover:bg-rose-500 transition-all duration-200 shadow-sm border border-rose-100 hover:border-transparent">
                        <span class="hidden sm:inline">Đăng xuất</span>
                        <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Tuyệt vời!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false, toast: true, position: 'top-end', customClass: { popup: 'rounded-2xl shadow-xl' }});
        @endif
        @if($errors->any())
            Swal.fire({ icon: 'error', title: 'Oops...', html: '{!! implode("<br>", $errors->all()) !!}', customClass: { popup: 'rounded-2xl shadow-xl' }});
        @endif
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Xóa dữ liệu này?', text: "Hành động này không thể hoàn tác!", icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b', confirmButtonText: 'Xóa ngay', cancelButtonText: 'Hủy bỏ',
                customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
            }).then((result) => { if (result.isConfirmed) { document.getElementById(formId).submit(); } })
        }
    </script>
</body>
</html>
