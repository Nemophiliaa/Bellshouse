<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

require_once '../../backend/db.php';

$user_id = $_SESSION['user_id'];

// Get wishlist with destinasi details
$wishlist = db_fetch_all($conn, 
    "SELECT wishlist.*, destinasi.nama_destinasi, destinasi.foto, destinasi.harga, destinasi.deskripsi,
            kota.kota, provinsi.provinsi, kategori.kategori
     FROM wishlist
     JOIN destinasi ON wishlist.id_destinasi = destinasi.id
     JOIN kota ON destinasi.id_kota = kota.id
     JOIN provinsi ON kota.id_provinsi = provinsi.id
     JOIN kategori ON destinasi.id_kategori = kategori.id
     WHERE wishlist.id_user = ?
     ORDER BY wishlist.tanggal_ditambahkan DESC", 
    [$user_id]
);

$total_wishlist = count($wishlist);

// Get most expensive destination
$termahal = null;
if($total_wishlist > 0){
    $max_price = max(array_column($wishlist, 'harga'));
    foreach($wishlist as $item){
        if($item['harga'] == $max_price){
            $termahal = $item['nama_destinasi'];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wishlist - BellsHouse</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body class="font-[poppins] overflow-x-hidden">
    <!-- Navbar -->
    <?php include '../components/navigation.php' ?>

    <!-- Main -->
    <main class="pt-16 pb-24 space-y-10">
      <section>
        <!-- Header Section Start -->
        <header
          class="mx-auto w-[92%] lg:w-[85%] max-w-7xl bg-white border border-orange-300 rounded-3xl px-8 py-14 shadow-[0_10px_30px_rgba(0,0,0,0.08)] grid md:grid-cols-2 gap-10 items-center">
          <!-- left Content Start -->
          <div class="space-y-6">
            <h1
              class="text-4xl lg:text-5xl font-extrabold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-red-600">
              Pantau Semua Wishlist<br />
              Perjalanan Kamu ✈️
            </h1>

            <p class="text-slate-600 text-lg leading-relaxed max-w-md">
              Atur dan wujudkan setiap destinasi impianmu bersama
              <span class="font-semibold text-orange-600"
                >BellsHouse Travel</span
              >, tempat terbaik untuk merencanakan liburanmu.
            </p>
            <!-- left Content End -->

            <!-- Button Start -->
            <div class="gap-4 grid md:grid-cols-2 justify-items-start md:flex">
              <a
                href="home.php"
                class="px-7 py-3 rounded-2xl text-white text-lg font-medium bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 shadow-md hover:shadow-xl hover:scale-[1.04] transition-all duration-300">
                Cari Wishlist Baru
              </a>

              <a
                href="mytrip.php"
                class="px-7 py-3 rounded-2xl text-orange-600 text-lg font-medium border border-orange-500 bg-white hover:bg-orange-50 hover:scale-[1.04] transition-all duration-300">
                Lanjutkan Trip
              </a>
            </div>
          </div>
          <!-- Button Start -->

          <!-- RIGHT: Wishlist Card Start -->
          <div
            class="p-8 rounded-3xl bg-orange-50 border border-orange-200 shadow-sm hover:shadow-md transition-all duration-300">
            <h2 class="text-sm text-slate-500 font-semibold tracking-wide">
              JUMLAH WISHLIST
            </h2>

            <p class="text-3xl font-bold text-orange-600 mt-1"><?= $total_wishlist ?> DESTINASI</p>

            <?php if($termahal): ?>
            <p class="text-sm text-slate-500 mt-3">
              Termahal :
              <span class="text-orange-700 font-medium"><?= htmlspecialchars($termahal) ?></span>
            </p>
            <?php endif; ?>
          </div>
          <!-- RIGHT: Wishlist Card End -->
        </header>
      </section>
      <!-- Header Section End -->

      <!-- Card Section Start -->
      <section>
        <!-- Title Start -->
        <div class="mx-auto w-[92%] lg:w-[85%] max-w-7xl m-5">
          <h1 class="font-semibold text-2xl">Daftar wishlist kamu</h1>
        </div>
        <!-- Title End -->

        <!-- Card Container Start -->
        <div class="mx-auto w-[92%] lg:w-[85%] max-w-7xl grid gap-5  justify-center sm:justify-normal sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          
          <?php if(empty($wishlist)): ?>
          <!-- Empty State -->
          <div class="col-span-full text-center py-16">
            <i class="fas fa-heart-broken text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Wishlist Masih Kosong</h3>
            <p class="text-gray-500 mb-6">Tambahkan destinasi favorit Anda ke wishlist!</p>
            <a href="home.php" class="px-6 py-3 rounded-xl text-white font-medium bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 hover:shadow-lg transition-all inline-block">
              <i class="fas fa-search mr-2"></i>Jelajahi Destinasi
            </a>
          </div>
          <?php else: ?>
          
          <?php foreach($wishlist as $item): ?>
          <!-- Card Start -->
          <div class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150 relative">
            <a href="detail-destinasi.php?id=<?= $item['id_destinasi'] ?>">
              <header class="relative">
                <img
                  src="../../backend/img/<?= htmlspecialchars($item['foto']) ?>"
                  alt="<?= htmlspecialchars($item['nama_destinasi']) ?>"
                  class="w-full object-cover object-center h-60 group-hover:scale-105 duration-200 transition-all" />
              </header>
              <div class="p-5 space-y-5">
                <div class="flex justify-between items-center gap-1.5">
                  <h1 class="text-xl font-medium"><?= htmlspecialchars($item['nama_destinasi']) ?></h1>
                  <p class="whitespace-nowrap sm:whitespace-normal">
                    <span class="font-bold"> Rp.<?= number_format($item['harga'], 0, ',', '.') ?> </span>/ Malam
                  </p>
                </div>
                <footer class="space-y-3">
                  <div class="flex items-center gap-1.5">
                    <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                    <p><?= htmlspecialchars($item['provinsi']) ?>, <?= htmlspecialchars($item['kota']) ?></p>
                  </div>
                  <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">
                    <?= htmlspecialchars($item['kategori']) ?>
                  </span>
                </footer>
              </div>
            </a>
            
            <!-- Remove from Wishlist Button -->
            <button onclick="removeFromWishlist('<?= $item['id_destinasi'] ?>', this, event)" 
                    class="absolute top-5 right-5 z-10 w-10 h-10 rounded-full bg-white/90 hover:bg-white shadow-md flex items-center justify-center transition-all duration-200 hover:scale-110">
              <i class="fa-solid fa-heart text-red-500 text-xl"></i>
            </button>
          </div>
          <?php endforeach; ?>
          
          <?php endif; ?>
          
        </div>
        <!-- Card Container End -->
      </section>
      <!-- Card Section End -->
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php' ?>

    <!-- JS -->
    <script>
        function removeFromWishlist(idDestinasi, button, event) {
            event.preventDefault();
            event.stopPropagation();
            
            if(!confirm('Hapus destinasi ini dari wishlist?')) return;
            
            button.disabled = true;
            
            fetch('../../backend/wishlist-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_destinasi=${idDestinasi}&action=remove`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Remove card with animation
                    const card = button.closest('.max-w-md');
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#f97316'
                    });
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f97316'
                });
                button.disabled = false;
            });
        }
    </script>
    <script type="module" src="../../js/main.js"></script>
  </body>
</html>
