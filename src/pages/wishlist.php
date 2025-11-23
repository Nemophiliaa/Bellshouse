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

            <p class="text-3xl font-bold text-orange-600 mt-1">1 DESTINASI</p>

            <p class="text-sm text-slate-500 mt-3">
              Termahal :
              <span class="text-orange-700 font-medium">Gunung Masamba</span>
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
          <h1 class="font-semibold text-2xl">Daftar wishlist kamu</h1>
        </div>
        <!-- Title End -->

        <!-- Card Container Start -->
        <div class="mx-auto w-[92%] lg:w-[85%] max-w-7xl grid gap-5  justify-center sm:justify-normal sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <!-- Card Start -->
          <a
            href="pemesanan.php"
            class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
            <header class="relative">
              <img
                src="../../assets/gunungMasamba.png"
                alt="Gunung Masamba"
                class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all" />
              <!-- Misal Udah Ditambah Ke Wishlist -->
              <i
                class="fa-solid fa-heart text-red-500 absolute right-0 top-5 -translate-x-5 text-xl"></i>
            </header>
            <div class="p-5 space-y-5">
              <div class="flex justify-between items-center gap-1.5">
                <h1 class="text-xl font-medium">Gunung Masamba</h1>
                <p class="whitespace-nowrap sm:whitespace-normal">
                  <span class="font-bold"> Rp.200.000 </span>/ Malam
                </p>
              </div>
              <footer class="space-y-3">
                <div class="flex items-center gap-1.5">
                  <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                  <p>Kalimantan Timur, Samarinda</p>
                </div>
                <div class="md:flex md:justify-between">
                  <div class="flex gap-1.5">
                    <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                    <p class="text-slate-500">4.9</p>
                  </div>
                  <p class="text-slate-500">89 Reviews</p>
                </div>
              </footer>
            </div>
          </a>
          
          <a
            href="pemesanan.php"
            class="max-w-md rounded-3xl overflow-hidden shadow-md bg-slate-100 group hover:shadow-xl hover:scale-105 transition-all duration-150">
            <header class="relative">
              <img
                src="../../assets/gunungMasamba.png"
                alt="Gunung Masamba"
                class="w-full object-cover object-center group-hover:scale-105 duration-200 transition-all" />
              <!-- Misal Udah Ditambah Ke Wishlist -->
              <i
                class="fa-solid fa-heart text-red-500 absolute right-0 top-5 -translate-x-5 text-xl"></i>
            </header>
            <div class="p-5 space-y-5">
              <div class="flex justify-between items-center gap-1.5">
                <h1 class="text-xl font-medium">Gunung Masamba</h1>
                <p class="whitespace-nowrap sm:whitespace-normal">
                  <span class="font-bold"> Rp.200.000 </span>/ Malam
                </p>
              </div>
              <footer class="space-y-3">
                <div class="flex items-center gap-1.5">
                  <i class="fa-solid fa-location-dot text-lg text-red-500"></i>
                  <p>Kalimantan Timur, Samarinda</p>
                </div>
                <div class="md:flex md:justify-between">
                  <div class="flex gap-1.5">
                    <i class="fa-regular fa-star text-yellow-300 text-lg"></i>
                    <p class="text-slate-500">4.9</p>
                  </div>
                  <p class="text-slate-500">89 Reviews</p>
                </div>
              </footer>
            </div>
          </a>
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
