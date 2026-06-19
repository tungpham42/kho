<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Doanh Nghiệp - Kho SaaS</title>

    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title') | @yield('site_name', 'Hệ Thống Quản Lý Kho')">
    <meta property="og:description" content="@yield('meta_description', 'Kho SaaS - Hệ Thống Quản Lý Kho')">
    <meta property="og:image" content="@yield('og_image', asset('img/og_image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'Hệ Thống Quản Lý Kho')">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-white to-indigo-50 antialiased flex items-center justify-center min-h-screen p-4 py-12">

    <div class="bg-white p-8 sm:p-12 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full max-w-2xl border border-slate-100">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Khởi tạo không gian làm việc</h1>
            <p class="text-slate-500 mt-2 font-medium">Bắt đầu quản lý kho đa điểm chỉ trong vài bước</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="company_name" class="block text-sm font-bold text-slate-700 mb-2">Tên Doanh Nghiệp <span class="text-rose-500">*</span></label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required autofocus placeholder="Công ty TNHH ABC..."
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-slate-800">
                </div>

                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Họ tên người quản lý <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Nguyễn Văn A"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-slate-800">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email đăng nhập <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="admin@congty.com"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-slate-800">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Mật khẩu <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-slate-800">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Xác nhận mật khẩu <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-slate-800">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-200">
                    Đăng Ký & Khởi Tạo
                </button>
            </div>
        </form>

        <p class="mt-8 text-center text-sm font-medium text-slate-600">
            Đã có tài khoản?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-bold transition">Đăng nhập ngay</a>
        </p>
    </div>

    <script>
        @if($errors->any()) Swal.fire({ icon: 'error', title: 'Đăng ký thất bại!', html: '{!! implode("<br>", $errors->all()) !!}', customClass: { popup: 'rounded-2xl' }}); @endif
    </script>
</body>
</html>
