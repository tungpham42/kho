<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMS SaaS - Nền Tảng Quản Lý Kho Thông Minh</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-white text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="fixed w-full top-0 bg-white/80 backdrop-blur-lg border-b border-slate-100 z-50 transition-all">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold">W</div>
                <span class="text-2xl font-black text-slate-900 tracking-tight">WMS<span class="text-indigo-600">SaaS</span></span>
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

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-50 via-white to-white px-4 pt-32 pb-20">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block mb-6 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 font-semibold text-sm tracking-wide">
                🚀 Phiên bản 2.0 đã ra mắt
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
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-600 text-white font-extrabold text-lg px-8 py-4 rounded-full shadow-xl hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">
                        Bắt đầu miễn phí ngay
                    </a>
                    <a href="#features" class="w-full sm:w-auto bg-white text-slate-700 border border-slate-200 font-extrabold text-lg px-8 py-4 rounded-full hover:bg-slate-50 transition-all duration-300">
                        Khám phá tính năng
                    </a>
                </div>
                <p class="mt-6 text-sm text-slate-400 font-medium">Không cần thẻ tín dụng · Hủy bất kỳ lúc nào</p>
            @endguest
        </div>
    </main>

    <footer class="border-t border-slate-100 bg-white text-slate-500 py-10 text-center font-medium">
        <p>&copy; {{ date('Y') }} WMS SaaS. Xây dựng cho doanh nghiệp hiện đại.</p>
    </footer>
</body>
</html>
