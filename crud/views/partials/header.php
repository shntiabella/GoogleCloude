<?php
$base_url = isset($base_url) ? $base_url : '';
$page_title = isset($page_title) ? $page_title : 'Dashboard';
$active = isset($active) ? $active : '';

// ---- Proteksi halaman: wajib login ----
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $base_url . 'login.php');
    exit;
}

$sessionNama = $_SESSION['nama'] ?? 'User';
$sessionEmail = $_SESSION['email'] ?? '';
$sessionInisial = strtoupper(substr($sessionNama, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> · CAY</title>
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
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">

<div x-data="{ mobileOpen: false }" class="flex h-screen overflow-hidden">

    <!-- Overlay mobile -->
    <div x-show="mobileOpen" x-cloak x-transition.opacity @click="mobileOpen = false"
         class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar -->
    <aside x-cloak :class="mobileOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col bg-slate-900 transition-transform duration-300 lg:static lg:translate-x-0">

        <!-- Brand -->
        <div class="flex h-16 items-center gap-3 border-b border-slate-800 px-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 font-extrabold text-white shadow-lg shadow-indigo-500/30">P</div>
            <div>
                <p class="text-sm font-bold text-white">CAY Admin</p>
                <p class="text-[11px] uppercase tracking-widest text-slate-500">Crave All Yours</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
            <a href="<?php echo $base_url; ?>index.php"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
               <?php echo $active === 'dashboard' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10"/>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="<?php echo $base_url; ?>views/kategori/index.php"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
               <?php echo $active === 'kategori' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2 2h10a1 1 0 011 1v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM16 3h4v4"/>
                </svg>
                <span>Kategori</span>
            </a>
            <a href="<?php echo $base_url; ?>views/barang/index.php"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
               <?php echo $active === 'barang' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Barang</span>
            </a>
            <a href="<?php echo $base_url; ?>controller/AuthController.php?action=logout"
               class="mt-4 flex items-center gap-3 rounded-xl border-t border-slate-800 px-3 py-2.5 text-sm font-medium text-rose-400 transition hover:bg-slate-800 hover:text-rose-300">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
                <span>Logout</span>
            </a>
        </nav>

        <!-- User -->
        <div class="border-t border-slate-800 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-slate-800/60 px-3 py-2.5">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-sm font-bold text-white"><?php echo htmlspecialchars($sessionInisial); ?></div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white"><?php echo htmlspecialchars($sessionNama); ?></p>
                    <p class="truncate text-xs text-slate-400"><?php echo htmlspecialchars($sessionEmail); ?></p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main column -->
    <div class="flex min-w-0 flex-1 flex-col">

        <!-- Topbar -->
        <header class="flex h-16 shrink-0 items-center justify-between gap-4 border-b border-slate-200 bg-white/80 px-4 backdrop-blur sm:px-6">
            <div class="flex items-center gap-3">
                <button @click="mobileOpen = true" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900"><?php echo htmlspecialchars($page_title); ?></h1>
                    <p class="hidden text-xs text-slate-500 sm:block"><?php echo date('l, d M Y'); ?></p>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                <button class="relative rounded-xl border border-slate-200 bg-white p-2.5 text-slate-500 shadow-sm transition hover:bg-slate-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-rose-500"></span>
                </button>
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 text-sm font-bold text-white shadow-md shadow-indigo-500/30"><?php echo htmlspecialchars($sessionInisial); ?></div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-6">