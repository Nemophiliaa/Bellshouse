<?php
session_start();
require_once '../../backend/db.php';

$id_destinasi = isset($_GET['id']) ? $_GET['id'] : '';
$data = null;
$in_wishlist = false;

if($id_destinasi){
    $data = db_fetch_one($conn, 'SELECT destinasi.id, destinasi.nama_destinasi, destinasi.deskripsi, destinasi.harga, destinasi.foto, kota.kota, provinsi.provinsi, kategori.kategori 
                                 FROM destinasi 
                                 JOIN kota ON destinasi.id_kota = kota.id 
                                 JOIN provinsi ON kota.id_provinsi = provinsi.id 
                                 JOIN kategori ON destinasi.id_kategori = kategori.id
                                 WHERE destinasi.id = ?', [$id_destinasi]);
    
    // Check if in wishlist
    if(isset($_SESSION['user_id'])){
        $check = db_fetch_one($conn, 'SELECT COUNT(*) as ada FROM wishlist WHERE id_user = ? AND id_destinasi = ?', 
                             [$_SESSION['user_id'], $id_destinasi]);
        $in_wishlist = ($check['ada'] > 0);
    }
}

if(!$data){
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_destinasi']) ?> - BellsHouse</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-[poppins] bg-gradient-to-b from-orange-50 to-white">
    <?php include '../components/navigation.php'; ?>

    <main class="py-16">
        <div class="w-[90%] max-w-7xl mx-auto">
            
            <!-- Header -->
            <div class="mb-8">
                <a href="home.php" class="text-orange-600 hover:text-orange-700 mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
                <h1 class="text-4xl font-bold text-slate-800 mb-2"><?= htmlspecialchars($data['nama_destinasi']) ?></h1>
                <div class="flex items-center gap-4 text-slate-600">
                    <span><i class="fa-solid fa-location-dot text-red-500 mr-2"></i><?= htmlspecialchars($data['provinsi']) ?>, <?= htmlspecialchars($data['kota']) ?></span>
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium"><?= htmlspecialchars($data['kategori']) ?></span>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Left: Image & Description -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Main Image -->
                    <div class="rounded-3xl overflow-hidden shadow-xl">
                        <img src="../../backend/img/<?= htmlspecialchars($data['foto']) ?>" 
                             alt="<?= htmlspecialchars($data['nama_destinasi']) ?>"
                             class="w-full h-[400px] object-cover">
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-8 shadow-md">
                        <h2 class="text-2xl font-bold text-slate-800 mb-4">Tentang Destinasi</h2>
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                            <?= $data['deskripsi'] ? htmlspecialchars($data['deskripsi']) : 'Nikmati pengalaman tak terlupakan di destinasi wisata ini. Tempat yang sempurna untuk liburan bersama keluarga atau teman-teman.' ?>
                        </p>
                    </div>



                </div>

                <!-- Right: Booking Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 shadow-xl sticky top-20">
                        <div class="mb-6">
                            <p class="text-slate-600 text-sm mb-2">Harga mulai dari</p>
                            <p class="text-3xl font-bold text-orange-600">Rp <?= number_format($data['harga'], 0, ',', '.') ?></p>
                            <p class="text-slate-500 text-sm">per orang / malam</p>
                        </div>

                        <form action="pemesanan.php" method="GET" class="space-y-4">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            
                            <!-- Tanggal Keberangkatan -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fa-solid fa-calendar-days text-orange-500 mr-2"></i>Tanggal Keberangkatan
                                </label>
                                <input type="date" name="tgl_berangkat" required 
                                       min="<?= date('Y-m-d') ?>"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all">
                            </div>

                            <!-- Tanggal Kepulangan -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fa-solid fa-calendar-check text-orange-500 mr-2"></i>Tanggal Kepulangan
                                </label>
                                <input type="date" name="tgl_pulang" required 
                                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all">
                            </div>

                            <!-- Jumlah Orang -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fa-solid fa-users text-orange-500 mr-2"></i>Jumlah Peserta
                                </label>
                                <select name="jumlah_orang" required 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 outline-none transition-all">
                                    <option value="">Pilih Jumlah</option>
                                    <option value="1">1 Orang</option>
                                    <option value="2">2 Orang</option>
                                    <option value="3">3 Orang</option>
                                    <option value="4">4 Orang</option>
                                    <option value="5">5 Orang</option>
                                </select>
                            </div>

                            <!-- Total Estimasi -->
                            <div class="bg-orange-50 rounded-xl p-4 border border-orange-200">
                                <p class="text-sm text-slate-600 mb-1">Total Estimasi</p>
                                <p class="text-2xl font-bold text-orange-600" id="total-price">Rp <?= number_format($data['harga'], 0, ',', '.') ?></p>
                                <p class="text-xs text-slate-500 mt-1">*Harga dapat berubah sesuai jumlah peserta</p>
                            </div>

                            <!-- Buttons -->
                            <div class="space-y-3">
                                <button type="submit" 
                                        class="w-full py-4 rounded-xl text-white text-lg font-semibold bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                                    <i class="fas fa-arrow-right mr-2"></i>Lanjut Pemesanan
                                </button>
                                
                                <?php if(isset($_SESSION['user_id'])): ?>
                                <button type="button" 
                                        id="wishlistBtn"
                                        onclick="toggleWishlistDetail()"
                                        data-in-wishlist="<?= $in_wishlist ? 'true' : 'false' ?>"
                                        class="w-full py-4 rounded-xl text-orange-600 text-lg font-semibold border-2 border-orange-500 bg-white hover:bg-orange-50 transition-all duration-300">
                                    <i class="<?= $in_wishlist ? 'fa-solid' : 'fa-regular' ?> fa-heart mr-2"></i>
                                    <span id="wishlistText"><?= $in_wishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' ?></span>
                                </button>
                                <?php endif; ?>
                            </div>

                            <p class="text-xs text-center text-slate-500 mt-3">
                                <i class="fas fa-shield-alt mr-1"></i>Pemesanan Anda aman dan terlindungi
                            </p>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </main>

    <?php include '../components/footer.php'; ?>

    <script>
        // Update total price based on jumlah hari and jumlah orang
        const hargaPerOrang = <?= $data['harga'] ?>;
        const selectJumlah = document.querySelector('select[name="jumlah_orang"]');
        const totalPrice = document.getElementById('total-price');
        const inputTglBerangkat = document.querySelector('input[name="tgl_berangkat"]');
        const inputTglPulang = document.querySelector('input[name="tgl_pulang"]');

        function updateTotalPrice() {
            const jumlah = parseInt(selectJumlah.value) || 1;
            const tglBerangkat = inputTglBerangkat.value;
            const tglPulang = inputTglPulang.value;
            
            let jumlahHari = 1;
            
            if (tglBerangkat && tglPulang) {
                const date1 = new Date(tglBerangkat);
                const date2 = new Date(tglPulang);
                const diffTime = Math.abs(date2 - date1);
                jumlahHari = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }
            
            const total = hargaPerOrang * jumlah * jumlahHari;
            totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        selectJumlah.addEventListener('change', updateTotalPrice);
        inputTglBerangkat.addEventListener('change', updateTotalPrice);
        inputTglPulang.addEventListener('change', updateTotalPrice);
        
        // Wishlist toggle function
        function toggleWishlistDetail() {
            const btn = document.getElementById('wishlistBtn');
            const icon = btn.querySelector('i');
            const text = document.getElementById('wishlistText');
            const inWishlist = btn.getAttribute('data-in-wishlist') === 'true';
            const action = inWishlist ? 'remove' : 'add';
            
            btn.disabled = true;
            
            fetch('../../backend/wishlist-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_destinasi=<?= $id_destinasi ?>&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    if(data.action === 'added') {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        text.textContent = 'Hapus dari Wishlist';
                        btn.setAttribute('data-in-wishlist', 'true');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        text.textContent = 'Tambah ke Wishlist';
                        btn.setAttribute('data-in-wishlist', 'false');
                    }
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
                btn.disabled = false;
            });
        }
        
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `fixed top-20 right-5 z-[100] px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all transform translate-x-0 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        // Validation: tgl_pulang must be after tgl_berangkat
        const tglBerangkat = document.querySelector('input[name="tgl_berangkat"]');
        const tglPulang = document.querySelector('input[name="tgl_pulang"]');

        tglBerangkat.addEventListener('change', function() {
            const minPulang = new Date(this.value);
            minPulang.setDate(minPulang.getDate() + 1);
            tglPulang.min = minPulang.toISOString().split('T')[0];
            if(tglPulang.value && new Date(tglPulang.value) <= new Date(this.value)) {
                tglPulang.value = '';
            }
        });
    </script>
    <script src="../../js/main.js" type="module"></script>
</body>
</html>
