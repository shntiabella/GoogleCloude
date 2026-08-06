<?php
// =============================================================================
//  HALAMAN LOGIN (UI)
// -----------------------------------------------------------------------------
//  Form mengarah ke controller/AuthController.php. Jika sudah login, langsung
//  diarahkan ke dashboard.
// =============================================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk · CAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">

<div class="flex min-h-screen items-center justify-center p-4">
    <div class="grid w-full max-w-4xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl lg:grid-cols-2">

        <!-- Panel branding (kiri, tersembunyi di layar kecil) -->
        <div class="hidden flex-col justify-between bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-600 p-10 text-white lg:flex">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/20 font-extrabold text-white backdrop-blur">P</div>
                <div>
                    <p class="text-sm font-bold">CAY Admin</p>
                    <p class="text-[11px] uppercase tracking-widest text-indigo-200">Crave All Yours</p>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-extrabold leading-snug">Dapatkan makanan dan minuman yang kekinian.</h2>
                <ul class="mt-6 space-y-3 text-sm text-indigo-100">
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Kelola isi perutmuu
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        surganya GEN Z
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        harga ramah dikantong
                    </li>
                </ul>
            </div>

            <p class="text-xs text-indigo-200">© <?php echo date('Y'); ?> CAY Admin</p>
        </div>

        <!-- Form login (kanan) -->
        <div class="p-8 sm:p-10" x-data="loginForm">
            <div class="mb-8 flex items-center gap-3 lg:hidden">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 font-extrabold text-white">P</div>
                <p class="text-sm font-bold text-slate-900">CAY Admin</p>
            </div>

            <h1 class="text-2xl font-extrabold text-slate-900">Masuk</h1>
            <p class="mt-1 text-sm text-slate-500">Silakan masuk menggunakan akun Anda.</p>

            <form action="controllers/auth/authControllers.php" method="POST" class="mt-8 space-y-4">
                <input type="hidden" name="action" value="login">

                <!-- Email -->
                <label class="block">
                    <span class="mb-1.5 block text-sm font-medium text-slate-700">Email</span>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.9 5.3a2 2 0 002.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <input type="email" name="email" x-model="email" required autocomplete="email" placeholder="nama@email.com"
                               class="w-full rounded-xl border border-slate-300 py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    </div>
                </label>

                <!-- Password -->
                <label class="block">
                    <span class="mb-1.5 block text-sm font-medium text-slate-700">Password</span>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input :type="showPassword ? 'text' : 'password'" name="password" x-model="password" required autocomplete="current-password" placeholder="••••••••"
                               class="w-full rounded-xl border border-slate-300 py-2.5 pl-10 pr-11 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 rounded p-1 text-slate-400 transition hover:text-slate-600">
                            <svg x-show="!showPassword" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S5.5 5.5 12 5.5 21.5 12 21.5 12 18.5 18.5 12 18.5 2.5 12 2.5 12z"/></svg>
                            <svg x-show="showPassword" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.9 11a3 3 0 10-4.3 4.3M10.1 15l-1.6 1.6M6.4 19.7L4 22M17 15l4-4m-2.5 2.5L21 16m-5.9-6.3L13 5m-2.5 4L9 9M4 4l16 16"/></svg>
                        </button>
                    </div>
                </label>

                <!-- Remember + forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex cursor-pointer items-center gap-2">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-slate-600">Ingat saya</span>
                    </label>
                    <a href="#" class="font-medium text-indigo-600 transition hover:text-indigo-700">Lupa password?</a>
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-60">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">
                Belum punya akun?
                <a href="register.php" class="font-semibold text-indigo-600 transition hover:text-indigo-700">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('loginForm', () => ({
        email: '',
        password: '',
        showPassword: false,
    }));
});
</script>
</body>
</html>