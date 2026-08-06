<?php
require 'koneksi/database.php';
require  'models/kategori/Kategori.php';
require  'models/barang/Barang.php';

$kategoriModel = new Kategori($connection);
$kategoriList = $kategoriModel->getAllKategori();
$totalKategori = $kategoriList->num_rows;
$kategoriRows = $kategoriList->fetch_all(MYSQLI_ASSOC);
$recentKategori = array_slice($kategoriRows, 0, 5);

$barangModel = new Barang($connection);
$barangRows = $barangModel->getAllBarang()->fetch_all(MYSQLI_ASSOC);
$totalBarang = count($barangRows);
$recentBarang = array_slice($barangRows, 0, 5);

$nilaiStok = 0;
foreach ($barangRows as $b) {
    $nilaiStok += $b['harga_beli'] * $b['stok'];
}

$base_url = '';
$page_title = 'Dashboard';
$active = 'dashboard';

include __DIR__ . '/views/partials/header.php';
?>

<div class="mx-auto max-w-6xl space-y-6">
    <!-- Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 p-6 text-white shadow-xl shadow-indigo-500/20 sm:p-8">
        <div class="relative z-10">
            <p class="text-sm font-medium text-indigo-200">Selamat datang kembali</p>
            <h2 class="mt-1 text-2xl font-extrabold">Dashboard CAY</h2>
            <p class="mt-2 max-w-md text-sm text-indigo-100">Pantau kategori dan stok barang Anda dengan cepat dan mudah.</p>
        </div>
        <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-16 -right-16 h-56 w-56 rounded-full bg-white/10"></div>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <a href="views/kategori/index.php" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2 2h10a1 1 0 011 1v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM16 3h4v4"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Kategori</p>
                <p class="text-2xl font-extrabold text-slate-900"><?php echo $totalKategori; ?></p>
            </div>
        </a>

        <a href="views/barang/index.php" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Barang</p>
                <p class="text-2xl font-extrabold text-slate-900"><?php echo $totalBarang; ?></p>
            </div>
        </a>

        <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.2 0-4 1-4 2.3 0 2.6 6 1.4 6 4.3 0 1.3-1.8 2.4-4 2.4m0-9V6m0 13v-1M9.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Nilai Stok</p>
                <p class="truncate text-xl font-extrabold text-slate-900">Rp <?php echo number_format($nilaiStok, 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>

    <!-- Recent: Kategori & Barang -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Kategori -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-sm font-bold text-slate-900">Kategori Terbaru</h3>
                <a href="views/kategori/index.php" class="text-sm font-medium text-indigo-600 transition hover:text-indigo-700">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Nama Kategori</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (count($recentKategori) === 0): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-slate-500">Belum ada data kategori.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentKategori as $i => $k): ?>
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-4 text-slate-500"><?php echo $i + 1; ?></td>
                                    <td class="px-6 py-4 font-medium text-slate-900"><?php echo htmlspecialchars($k['nama_kategori']); ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="views/kategori/edit.php?id=<?php echo $k['id']; ?>" class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-3 py-1.5 text-sm font-medium text-indigo-600 transition hover:bg-indigo-100">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Barang -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-sm font-bold text-slate-900">Barang Terbaru</h3>
                <a href="views/barang/index.php" class="text-sm font-medium text-indigo-600 transition hover:text-indigo-700">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Nama Barang</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Stok</th>
                            <th class="px-6 py-3 text-right">Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (count($recentBarang) === 0): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada data barang.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentBarang as $i => $b): ?>
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-4 text-slate-500"><?php echo $i + 1; ?></td>
                                    <td class="px-6 py-4 font-medium text-slate-900"><?php echo htmlspecialchars($b['nama_barang']); ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?php echo htmlspecialchars($b['nama_kategori'] ?? '—'); ?></td>
                                    <td class="px-6 py-4 <?php echo $b['stok']  ? 'font-bold text-rose-600' : 'text-slate-600'; ?>"><?php echo $b['stok']; ?></td>
                                    <td class="px-6 py-4 text-right font-medium text-slate-900">Rp <?php echo number_format($b['harga_jual'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>