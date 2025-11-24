<?php
// Get user data if logged in
$logged_in_user = null;
if(isset($_SESSION['user_id'])){
    require_once __DIR__ . '/../../backend/db.php';
    $logged_in_user = db_fetch_one($conn, "SELECT nama, email FROM data_user WHERE id = ?", [$_SESSION['user_id']]);
}
?>
<!-- Header Hero Start -->
<header class="sticky top-0 left-0 z-50">
  <nav id="stickyNavbar" class="flex p-5 items-center justify-between relative">
    <a href="home.php"><h1 class="text-3xl bg-clip-text text-transparent bg-linear-to-r/oklch from-orange-500 via-red-500 to-yellow-500 font-extrabold">BellsHouse</h1></a>
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
        class="fixed top-0 right-0 h-screen w-80 max-w-[80vw] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-[60] flex flex-col">
        
        <!-- Header Sidebar -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
          <div class="flex items-center gap-3">
            <!-- Profile Icon -->
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-orange-500 to-red-500 shadow-md">
              <div class="flex flex-col items-center">
                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                <div class="w-5 h-2.5 bg-white rounded-t-full mt-1"></div>
              </div>
            </div>
            <p class="font-semibold text-gray-800 text-lg">
              <?= $logged_in_user ? htmlspecialchars($logged_in_user['nama']) : 'Guest' ?>
            </p>
          </div>
          <!-- Close Button -->
          <button
            id="closeToggle"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors cursor-pointer">
            <i class="fa-solid fa-xmark text-2xl text-gray-600"></i>
          </button>
        </div>

        <!-- Menu Items -->
        <nav class="flex-1 px-6 py-8">
          <ul class="space-y-4">
            <li>
              <a href="home.php" 
                 class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                <i class="fa-solid fa-house text-xl w-6 text-center"></i>
                <span class="font-medium">Beranda</span>
              </a>
            </li>
            <?php if($logged_in_user): ?>
            <li>
              <a href="wishlist.php" 
                 class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                <i class="fa-solid fa-heart text-xl w-6 text-center"></i>
                <span class="font-medium">Wishlist</span>
              </a>
            </li>
            <li>
              <a href="mytrip.php" 
                 class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                <i class="fa-solid fa-plane-departure text-xl w-6 text-center"></i>
                <span class="font-medium">My Trip</span>
              </a>
            </li>
            <li>
              <a href="settings.php" 
                 class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                <i class="fa-solid fa-cog text-xl w-6 text-center"></i>
                <span class="font-medium">Pengaturan</span>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>

        <!-- Bottom Buttons -->
        <div class="p-6 border-t border-gray-200 space-y-3">
          <?php if($logged_in_user): ?>
          <form action="../../backend/logout.php" method="POST">
            <button type="submit" class="block w-full py-3 rounded-full text-white font-medium bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-md hover:shadow-lg transition-all">
              <i class="fa-solid fa-sign-out-alt mr-2"></i>Keluar
            </button>
          </form>
          <?php else: ?>
          <a
            href="login.php"
            class="block w-full py-3 rounded-full text-center text-white font-medium bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 shadow-md hover:shadow-lg transition-all">
            Masuk
          </a>
          <a
            href="register.php"
            class="block w-full py-3 rounded-full text-center text-white font-medium bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 shadow-md hover:shadow-lg transition-all">
            Daftar Sekarang
          </a>
          <?php endif; ?>
        </div>
      </div>
      <!-- Sidebar End -->
    </div>
    <!-- Icons End -->
  </nav>
</header>
<!-- Header Hero End -->
