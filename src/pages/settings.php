<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

require_once '../../backend/db.php';

$user_id = $_SESSION['user_id'];
$success_msg = '';
$error_msg = '';

// Get user data
$user = db_fetch_one($conn, "SELECT * FROM data_user WHERE id = ?", [$user_id]);

if(!$user){
    session_destroy();
    header('Location: login.php');
    exit;
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $no_tlp = trim($_POST['no_tlp']);
    $alamat = trim($_POST['alamat']);
    $password_lama = isset($_POST['password_lama']) ? $_POST['password_lama'] : '';
    $password_baru = isset($_POST['password_baru']) ? $_POST['password_baru'] : '';
    $konfirmasi_password = isset($_POST['konfirmasi_password']) ? $_POST['konfirmasi_password'] : '';
    
    // Validation
    if(empty($nama) || empty($email) || empty($no_tlp) || empty($alamat)){
        $error_msg = "Semua field wajib diisi!";
    } else {
        // Check if email already exists (except current user)
        $check_email = db_fetch_one($conn, "SELECT id FROM data_user WHERE email = ? AND id != ?", [$email, $user_id]);
        
        if($check_email){
            $error_msg = "Email sudah digunakan oleh user lain!";
        } else {
            // Update user data
            $update_success = true;
            
            // If changing password
            if(!empty($password_baru)){
                if(empty($password_lama)){
                    $error_msg = "Password lama harus diisi untuk mengubah password!";
                    $update_success = false;
                } elseif($password_baru !== $konfirmasi_password){
                    $error_msg = "Password baru dan konfirmasi password tidak cocok!";
                    $update_success = false;
                } elseif(strlen($password_baru) < 6){
                    $error_msg = "Password baru minimal 6 karakter!";
                    $update_success = false;
                } else {
                    // Verify old password
                    if(!password_verify($password_lama, $user['password'])){
                        $error_msg = "Password lama tidak sesuai!";
                        $update_success = false;
                    } else {
                        // Hash new password
                        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
                        
                        // Update with new password
                        $result = db_execute($conn, 
                            "UPDATE data_user SET nama = ?, email = ?, no_tlp = ?, alamat = ?, password = ? WHERE id = ?",
                            [$nama, $email, $no_tlp, $alamat, $hashed_password, $user_id]
                        );
                        
                        if($result){
                            $success_msg = "Profil dan password berhasil diupdate!";
                            $user = db_fetch_one($conn, "SELECT * FROM data_user WHERE id = ?", [$user_id]);
                        } else {
                            $error_msg = "Gagal update data!";
                        }
                    }
                }
            } else {
                // Update without password change
                if($update_success){
                    $result = db_execute($conn, 
                        "UPDATE data_user SET nama = ?, email = ?, no_tlp = ?, alamat = ? WHERE id = ?",
                        [$nama, $email, $no_tlp, $alamat, $user_id]
                    );
                    
                    if($result){
                        $success_msg = "Profil berhasil diupdate!";
                        $user = db_fetch_one($conn, "SELECT * FROM data_user WHERE id = ?", [$user_id]);
                    } else {
                        $error_msg = "Gagal update data!";
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - BellsHouse</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumar+One&family=Poppins:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="font-[poppins] bg-gradient-to-b from-orange-50 to-white">
    <?php include '../components/navigation.php'; ?>

    <main class="py-16">
        <div class="w-[90%] max-w-4xl mx-auto">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800 mb-2">
                    <i class="fas fa-cog text-orange-500 mr-3"></i>Pengaturan Akun
                </h1>
                <p class="text-slate-600">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <!-- Alert Messages -->
            <?php if($success_msg): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <span><?= $success_msg ?></span>
            </div>
            <?php endif; ?>
            
            <?php if($error_msg): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <span><?= $error_msg ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                
                <!-- Informasi Profil -->
                <div class="bg-white rounded-2xl p-8 shadow-md">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-user-circle text-orange-500"></i>
                        Informasi Profil
                    </h2>

                    <div class="space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" required 
                                   value="<?= htmlspecialchars($user['nama']) ?>"
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                                   placeholder="Nama lengkap Anda">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required 
                                   value="<?= htmlspecialchars($user['email']) ?>"
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                                   placeholder="email@example.com">
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                No. Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="no_tlp" required 
                                   value="<?= htmlspecialchars($user['no_tlp']) ?>"
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all"
                                   placeholder="+62 xxx xxx xxx">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" required rows="3"
                                      class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all resize-none"
                                      placeholder="Alamat lengkap Anda"><?= htmlspecialchars($user['alamat']) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="bg-white rounded-2xl p-8 shadow-md">
                    <h2 class="text-xl font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-lock text-orange-500"></i>
                        Ubah Password
                    </h2>
                    <p class="text-sm text-slate-500 mb-6">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="space-y-4">
                        <!-- Password Lama -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Password Lama
                            </label>
                            <div class="relative">
                                <input type="password" name="password_lama" id="password_lama"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all pr-12"
                                       placeholder="Masukkan password lama">
                                <button type="button" onclick="togglePassword('password_lama')" 
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700">
                                    <i class="fas fa-eye" id="icon_password_lama"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" name="password_baru" id="password_baru"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all pr-12"
                                       placeholder="Minimal 6 karakter">
                                <button type="button" onclick="togglePassword('password_baru')" 
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700">
                                    <i class="fas fa-eye" id="icon_password_baru"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-700 font-medium focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all pr-12"
                                       placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePassword('konfirmasi_password')" 
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700">
                                    <i class="fas fa-eye" id="icon_konfirmasi_password"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 justify-end">
                    <a href="home.php" 
                       class="px-6 py-3 rounded-xl text-slate-700 font-medium border border-slate-300 hover:bg-slate-50 transition-all">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-red-500 via-orange-400 to-yellow-300 shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>

            </form>
            
        </div>
    </main>

    <?php include '../components/footer.php'; ?>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('icon_' + fieldId);
            
            if(field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    <script src="../../js/main.js" type="module"></script>
</body>
</html>
