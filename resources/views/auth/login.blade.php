<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Kho SaaS</title>

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
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 antialiased flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full max-w-md border border-slate-100">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 mb-6 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Chào mừng trở lại!</h1>
            <p class="text-slate-500 mt-2 font-medium">Đăng nhập vào không gian làm việc của bạn</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email làm việc</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com"
                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all">
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-bold text-slate-700">Mật khẩu</label>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">Quên mật khẩu?</a>
                </div>
                <input type="password" name="password" id="password" required placeholder="••••••••"
                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded-md transition">
                <label for="remember" class="ml-3 block text-sm font-medium text-slate-600">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-200">
                Đăng Nhập
            </button>
        </form>

        <p class="mt-8 text-center text-sm font-medium text-slate-600">
            Doanh nghiệp chưa có tài khoản?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-bold transition">Đăng ký ngay</a>
        </p>
    </div>

    <script>
        @if($errors->any()) Swal.fire({ icon: 'error', title: 'Oops...', html: '{!! implode("<br>", $errors->all()) !!}', customClass: { popup: 'rounded-2xl' } }); @endif
        @if(session('success')) Swal.fire({ icon: 'success', title: 'Thành công!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' }); @endif
    </script>
</body>
</html>
