<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" />

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
              Rencanakan<br />
              Perjalanan Kamu 🚗
            </h1>

            <p class="text-slate-600 text-lg leading-relaxed max-w-md">
              Kelola semua tiket perjalananmu dan pastikan setiap destinasi
              berjalan sesuai rencana bersama
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
                Tambah Pesanan
              </a>

              <a
                href="wishlist.php"
                class="px-7 py-3 rounded-2xl text-orange-600 text-lg font-medium border border-orange-500 bg-white hover:bg-orange-50 hover:scale-[1.04] transition-all duration-300">
                Check Wishlist
              </a>
            </div>
          </div>
          <!-- Button Start -->

          <!-- RIGHT: Wishlist Card Start -->
          <div
            class="p-8 rounded-3xl bg-orange-50 border border-orange-200 shadow-sm hover:shadow-md transition-all duration-300">
            <h2 class="text-sm text-slate-500 font-semibold tracking-wide">
              TOTAL PESANAN
            </h2>

            <p class="text-3xl font-bold text-orange-600 mt-1">1 TRIP</p>

            <p class="text-sm text-slate-500 mt-3">
              Selalu Cek Status Sebelum
              <span class="text-orange-700 font-medium">Keberangkatan</span>
            </p>
          </div>
          <!-- RIGHT: Wishlist Card Ens -->
        </header>
      </section>
      <!-- Header Section End -->

      <!-- Card Section Start -->
      <section>
        <!-- Title Start -->
        <div class="mx-auto w-[92%] lg:w-[85%] max-w-7xl m-5">
          <h1 class="font-semibold text-2xl">Daftar Pesanan Kamu</h1>
        </div>
        <!-- Title End -->

        <!-- Card Container Start -->
        <div
          class="mx-auto w-[92%] lg:w-[85%] max-w-7xl grid md:grid-cols-2 xl:grid-cols-2 gap-5 justify-items-center">
          <!-- Card Start -->

          <!-- If On Going -->
          <div
            class="cursor-pointer bg-slate-100 rounded-2xl shadow-md overflow-hidden w-full max-w-2xl flex flex-col md:flex-row transition hover:shadow-lg hover:-translate-y-1 duration-300">
            <!-- Gambar -->
            <div class="md:w-1/2 w-full h-48 md:h-auto">
              <img
                src="../../assets/product-1.png"
                alt="Taman Samarinda"
                class="w-full h-full object-cover object-center" />
            </div>

            <!-- Detail -->
            <div
              class="md:w-1/2 w-full p-5 space-y-3 flex flex-col justify-between">
              <div class="space-y-2">
                <div class="flex justify-between items-center">
                  <span
                    class="text-sm font-semibold text-orange-600 bg-orange-100 px-3 py-1 rounded-full"
                    >Wisata Budaya</span
                  >
                  <span class="text-sm font-semibold text-yellow-600"
                    >On Going</span
                  >
                </div>
                <h3 class="text-lg font-bold text-slate-900">
                  Taman Samarinda
                </h3>
                <p class="text-slate-500 text-sm">💸 Rp. 200.000</p>
                <p class="text-slate-500 text-sm">⏳ Durasi: 4 Hari</p>
                <p class="text-slate-500 text-sm">👥 2 Orang</p>
                <p class="text-slate-500 text-sm">
                  🗓️ Berangkat: 20 November 2025
                </p>
              </div>

              <!-- Tombol -->
              <div class="text-right">
                <button
                  type="submit"
                  class="px-5 py-2 text-sm font-semibold text-white rounded-md bg-linear-to-r/oklch from-red-500 to-orange-500 relative hover:before:[''] hover:before:absolute hover:before:inset-0 hover:before:bg-[rgba(0,0,0,0.05)]  transition-all duration-150 cursor-pointer">
                  Cancel
                </button>
              </div>
            </div>
          </div>

          <!-- If Succes  -->
          <div
            class="cursor-pointer bg-slate-100 rounded-2xl shadow-md overflow-hidden w-full max-w-2xl flex flex-col md:flex-row transition hover:shadow-lg hover:-translate-y-1 duration-300">
            <!-- Gambar -->
            <div class="md:w-1/2 w-full h-48 md:h-auto">
              <img
                src="../../assets/product-1.png"
                alt="Taman Samarinda"
                class="w-full h-full object-cover object-center" />
            </div>

            <!-- Detail -->
            <div
              class="md:w-1/2 w-full p-5 space-y-3 flex flex-col justify-between">
              <div class="space-y-2">
                <div class="flex justify-between items-center">
                  <span
                    class="text-sm font-semibold text-orange-600 bg-orange-100 px-3 py-1 rounded-full"
                    >Wisata Budaya</span
                  >
                  <span class="text-sm font-semibold text-green-600"
                    >Successfull</span
                  >
                </div>
                <h3 class="text-lg font-bold text-slate-900">
                  Taman Samarinda
                </h3>
                <p class="text-slate-500 text-sm">💸 Rp. 200.000</p>
                <p class="text-slate-500 text-sm">⏳ Durasi: 4 Hari</p>
                <p class="text-slate-500 text-sm">👥 2 Orang</p>
                <p class="text-slate-500 text-sm">
                  🗓️ Berangkat: 20 November 2025
                </p>
              </div>

              <!-- Tombol -->
              <div class="text-right">
                <button
                  type="submit"
                  class="px-5 py-2 text-sm font-semibold text-white rounded-md bg-linear-to-r/oklch from-red-500 to-orange-500 relative hover:before:[''] hover:before:absolute hover:before:inset-0 hover:before:bg-[rgba(0,0,0,0.05)]  transition-all duration-150 cursor-pointer">
                  Cancel
                </button>
              </div>
            </div>
          </div>

          <!-- If canceled -->
          <div
            class="cursor-pointer bg-slate-100 rounded-2xl shadow-md overflow-hidden w-full max-w-2xl flex flex-col md:flex-row transition hover:shadow-lg hover:-translate-y-1 duration-300">
            <!-- Gambar -->
            <div class="md:w-1/2 w-full h-48 md:h-auto">
              <img
                src="../../assets/product-1.png"
                alt="Taman Samarinda"
                class="w-full h-full object-cover object-center" />
            </div>

            <!-- Detail -->
            <div
              class="md:w-1/2 w-full p-5 space-y-3 flex flex-col justify-between">
              <div class="space-y-2">
                <div class="flex justify-between items-center">
                  <span
                    class="text-sm font-semibold text-orange-600 bg-orange-100 px-3 py-1 rounded-full"
                    >Wisata Budaya</span
                  >
                  <span class="text-sm font-semibold text-red-700"
                    >Canceled</span
                  >
                </div>
                <h3 class="text-lg font-bold text-slate-900">
                  Taman Samarinda
                </h3>
                <p class="text-slate-500 text-sm">💸 Rp. 200.000</p>
                <p class="text-slate-500 text-sm">⏳ Durasi: 4 Hari</p>
                <p class="text-slate-500 text-sm">👥 2 Orang</p>
                <p class="text-slate-500 text-sm">
                  🗓️ Berangkat: 20 November 2025
                </p>
              </div>

              <!-- Tombol -->
              <div class="text-right">
                <!-- Button Hidden  -->
                <!-- <button
                  type="submit"
                  class="px-5 py-2 text-sm font-semibold text-white rounded-md bg-linear-to-r/oklch from-red-500 to-orange-500 relative hover:before:[''] hover:before:absolute hover:before:inset-0 hover:before:bg-[rgba(0,0,0,0.05)]  transition-all duration-150 cursor-pointer">
                  Cancel
                </button> -->
              </div>
            </div>
          </div>
          
          <!-- Card End -->
        </div>
        <!-- Card Container End -->
      </section>
      <!-- Card Section End -->
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php' ?>

    <!-- JS -->
    <script type="module" src="../../js/main.js"></script>
  </body>
</html>
