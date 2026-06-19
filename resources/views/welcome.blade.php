<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kho SaaS - Nền Tảng Quản Lý Kho Thông Minh</title>

    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="Kho SaaS - Nền Tảng Quản Lý Kho Thông Minh">
    <meta property="og:description" content="Kho SaaS - Hệ Thống Quản Lý Kho">
    <meta property="og:image" content="@yield('og_image', asset('img/og_image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Hệ Thống Quản Lý Kho">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-white text-slate-800 antialiased flex flex-col min-h-screen">

    <nav class="fixed w-full top-0 bg-white/80 backdrop-blur-lg border-b border-slate-100 z-50 transition-all">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold">K</div>
                <span class="text-2xl font-black text-slate-900 tracking-tight">Kho<span class="text-indigo-600">SaaS</span></span>
            </a>
            <div class="flex items-center space-x-3 sm:space-x-5">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white font-bold px-6 py-2.5 rounded-full shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">Vào Bảng Điều Khiển &rarr;</a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-bold px-4 py-2 hidden sm:block transition">Đăng Nhập</a>
                    <a href="{{ route('register') }}" class="bg-slate-900 text-white font-bold px-6 py-2.5 rounded-full shadow-lg hover:bg-slate-800 hover:-translate-y-0.5 transition-all">Dùng thử miễn phí</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-50 via-white to-white px-4 pt-32 pb-20">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center mb-6 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 font-semibold text-sm tracking-wide shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Phiên bản mới đã ra mắt
            </div>
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-slate-900 mb-8 leading-[1.1] tracking-tight">
                Quản lý kho thông minh <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Đa nền tảng, Đa chi nhánh</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-500 mb-10 max-w-2xl mx-auto font-medium leading-relaxed">
                Hệ thống lưu trữ độc lập, bảo mật tuyệt đối. Tối ưu hóa toàn diện quy trình nhập, xuất, chuyển kho và kiểm kê với giao diện tinh gọn, tốc độ siêu tốc.
            </p>
            @guest
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-600 text-white font-extrabold text-lg px-8 py-4 rounded-full shadow-xl hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        Bắt đầu miễn phí ngay
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="#features" class="w-full sm:w-auto bg-white text-slate-700 border border-slate-200 font-extrabold text-lg px-8 py-4 rounded-full hover:bg-slate-50 transition-all duration-300">
                        Khám phá tính năng
                    </a>
                </div>
                <p class="mt-6 text-sm text-slate-400 font-medium">Không cần thẻ tín dụng · Hủy bất kỳ lúc nào</p>
            @endguest
        </div>
    </main>

    <section id="features" class="py-24 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-4">Tính Năng Nổi Bật</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto font-medium">Mọi công cụ bạn cần để kiểm soát luồng hàng hóa, tối ưu chi phí và đưa ra quyết định kinh doanh chính xác.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-white border border-slate-100 hover:border-indigo-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Nhập & Xuất Kho</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Tạo phiếu nhập xuất, trả hàng nhà cung cấp hay khách trả hàng một cách linh hoạt, lưu nháp và duyệt dễ dàng.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-white border border-slate-100 hover:border-purple-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Điều Chuyển Nội Bộ</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Quản lý luân chuyển hàng hóa giữa các kho/chi nhánh với cơ chế trừ/cộng tồn kho hoàn toàn tự động.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-white border border-slate-100 hover:border-sky-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Kiểm Kê Kho Bãi</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Định kỳ đối soát tồn hệ thống và thực tế. Tự động tính chênh lệch thừa/thiếu và cập nhật số dư cuối cùng.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-white border border-slate-100 hover:border-amber-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Báo Cáo Tồn Thời Gian Thực</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Nắm bắt chính xác số lượng tồn kho theo lô, date hoặc mã hàng tại mọi thời điểm, tránh rủi ro đứt gãy cung ứng.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-white border border-slate-100 hover:border-emerald-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Danh Mục Mở Rộng</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Quản lý không giới hạn số lượng Hàng hóa, Đối tác (Nhà cung cấp, Khách hàng) và Kho bãi vật lý.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-white border border-slate-100 hover:border-rose-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Tùy Biến Chuyên Sâu</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Cá nhân hóa hệ thống bằng cách tự định nghĩa tiền tố mã chứng từ và thông tin doanh nghiệp hiển thị trên báo cáo.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-100 bg-white text-slate-500 py-10 text-center font-medium">
        <p>&copy; {{ date('Y') }} Kho SaaS. Xây dựng cho doanh nghiệp hiện đại.</p>
    </footer>
</body>
</html>
