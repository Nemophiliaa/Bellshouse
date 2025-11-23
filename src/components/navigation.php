<!-- Header Hero Start -->
<header class="sticky top-0 left-0 z-50">
  <nav id="stickyNavbar" class="flex p-5 items-center justify-between relative">
    <h1 class="text-3xl bg-clip-text text-transparent bg-linear-to-r/oklch from-orange-500 via-red-500 to-yellow-500 font-extrabold">BellsHouse</h1>
    <!-- Icons Start -->
    <div class="flex items-center gap-1.5">
      <!-- Humberger Icon Container Start -->
      <a
        href="#"
        id="openToggle"
        class="w-11 h-11 flex items-center justify-center rounded-full bg-white cursor-pointer hover:bg-slate-200 duration-150 transition-all">
        <!-- Hamburger Lines Start -->
        <div class="space-y-1">
          <div class="w-6 h-1 bg-black rounded"></div>
          <div class="w-6 h-1 bg-black rounded"></div>
          <div class="w-6 h-1 bg-black rounded"></div>
        </div>
        <!-- Hamburger Lines End -->
      </a>
      <!-- Humberger Icon Container End -->

      <!-- Sidebar Start -->
      <div
        id="sidebar"
        class="absolute space-y-15 top-0 right-0 px-6 py-10 rounded-tl-3xl backdrop-blur-sm bg-white h-[100dvh] w-1/2 md:w-80 translate-x-full shadow-xl transition-all duration-300 z-55]">
        <header class="flex justify-between items-center">
          <div class="flex items-center gap-5">
            <!-- Porfile Icon Container Start -->
            <a
              href="#"
              class="w-10 h-10 flex items-center justify-center rounded-full border bg-black">
              <!-- Profile Silhouette -->
              <div class="flex flex-col items-center">
                <!-- Head -->
                <div class="w-2 h-2 bg-white rounded-full"></div>
                <!-- Body -->
                <div class="w-4 h-2 bg-white rounded-t-full mt-1"></div>
              </div>
            </a>
            <!-- Porfile Icon Container End -->
            <p class="font-medium text-lg">UserName</p>
          </div>
          <a
            href="#"
            id="closeToggle"
            class="text-xl flex items-center justify-center">
            <i class="fa-solid fa-xmark text-3xl"></i>
          </a>
        </header>
        <div>
          <ul class="space-y-10 text-slate-500 [&>li>a:hover]:text-black">
            <li>
              <a href="home.php" class="text-xl flex items-center gap-5"
                ><i class="fa-solid fa-house"></i> Beranda
              </a>
            </li>
            <li>
              <a href="wishlist.php" class="text-xl flex items-center gap-5"
                ><i class="fa-solid fa-heart"></i>Wishlist</a
              >
            </li>
            <li>
              <a href="mytrip.php" class="text-xl flex items-center gap-5"
                ><i class="fa-solid fa-plane-departure"></i>My Trip</a
              >
            </li>
          </ul>
        </div>
        <div class="grid gap-5">
          <button
            type="submit"
            class="px-y5 py-3 rounded-full text-white font-medium bg-orange-300 cursor-pointer hover:bg-orange-400">
            Masuk
          </button>
          <button
            type="submit"
            class="px-y5 py-3 rounded-full text-white font-medium bg-orange-500 cursor-pointer hover:bg-orange-600">
            Daftar Sekarang
          </button>
          <!-- Kalo User Sudah Login (Dua Button Di Atas Hilang)  -->
          <!-- <button type="submit" class="px-y5 py-3 rounded-full text-white font-medium bg-red-500 cursor-pointer hover:bg-red-600">Keluar</button> -->
        </div>
      </div>
      <!-- Sidebar End -->

      <!-- Porfile Icon Container Start -->
      <a
        href="#"
        class="w-10 h-10 flex items-center justify-center rounded-full border bg-black">
        <!-- Profile Silhouette -->
        <div class="flex flex-col items-center">
          <!-- Head -->
          <div class="w-2 h-2 bg-white rounded-full"></div>
          <!-- Body -->
          <div class="w-4 h-2 bg-white rounded-t-full mt-1"></div>
        </div>
      </a>
      <!-- Porfile Icon Container End -->
    </div>
    <!-- Icons End -->
  </nav>
</header>
<!-- Header Hero End -->
