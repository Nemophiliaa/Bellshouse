<?php
session_start();
require_once '../backend/connection.php';

// Handle Upload Foto & Insert Destinasi
if(isset($_POST['tambah_destinasi'])){
    $nama = ucwords(strtolower(trim($_POST['nama_destinasi'])));
    $deskripsi = trim($_POST['deskripsi']);
    $id_kota = $_POST['id_kota'];
    $id_kategori = $_POST['id_kategori'];
    $harga = (int)$_POST['harga'];
    
    // Auto-generate ID dengan format DST0001
    $result = $conn->query("SELECT id FROM destinasi WHERE id LIKE 'DST%' ORDER BY id DESC LIMIT 1");
    if($result->num_rows > 0){
        $last_row = $result->fetch_assoc();
        $last_num = (int)substr($last_row['id'], 3);
        $new_num = $last_num + 1;
    } else {
        $new_num = 1;
    }
    $new_id = 'DST' . str_pad($new_num, 4, '0', STR_PAD_LEFT);
    
    // Handle file upload
    $foto = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)){
            $newname = uniqid() . '.' . $ext;
            $target = '../backend/img/' . $newname;
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)){
                $foto = $newname;
            } else {
                $_SESSION['destinasi_error'] = 'Gagal upload foto';
            }
        } else {
            $_SESSION['destinasi_error'] = 'Format foto tidak valid (jpg, jpeg, png, gif)';
        }
    }
    
    if($foto){
        $stmt = $conn->prepare("INSERT INTO destinasi (id, nama_destinasi, deskripsi, id_kota, id_kategori, harga, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssiiss', $new_id, $nama, $deskripsi, $id_kota, $id_kategori, $harga, $foto);
        if($stmt->execute()){
            $_SESSION['destinasi_success'] = "Destinasi berhasil ditambahkan dengan ID: $new_id";
            header('Location: manage-destinasi.php');
            exit;
        } else {
            $_SESSION['destinasi_error'] = 'Gagal menambahkan destinasi: ' . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['destinasi_error'] = 'Gagal upload foto destinasi';
    }
}

// Handle Edit
if(isset($_POST['edit_destinasi'])){
    $id = $conn->real_escape_string($_POST['id']);
    $nama = ucwords(strtolower(trim($_POST['nama_destinasi'])));
    $deskripsi = trim($_POST['deskripsi']);
    $id_kota = $_POST['id_kota'];
    $id_kategori = $_POST['id_kategori'];
    $harga = (int)$_POST['harga'];
    
    // Check if new photo uploaded
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)){
            // Delete old photo
            $old_foto = $conn->query("SELECT foto FROM destinasi WHERE id = '$id'")->fetch_assoc();
            if($old_foto){
                $old_path = '../backend/img/' . $old_foto['foto'];
                if(file_exists($old_path)){
                    unlink($old_path);
                }
            }
            
            // Upload new photo
            $newname = uniqid() . '.' . $ext;
            $target = '../backend/img/' . $newname;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target);
            
            // Update with new photo
            $stmt = $conn->prepare("UPDATE destinasi SET nama_destinasi=?, deskripsi=?, id_kota=?, id_kategori=?, harga=?, foto=? WHERE id=?");
            $stmt->bind_param('ssiisss', $nama, $deskripsi, $id_kota, $id_kategori, $harga, $newname, $id);
        }
    } else {
        // Update without changing photo
        $stmt = $conn->prepare("UPDATE destinasi SET nama_destinasi=?, deskripsi=?, id_kota=?, id_kategori=?, harga=? WHERE id=?");
        $stmt->bind_param('ssiiss', $nama, $deskripsi, $id_kota, $id_kategori, $harga, $id);
    }
    
    if($stmt->execute()){
        $_SESSION['destinasi_success'] = 'Destinasi berhasil diupdate';
        header('Location: manage-destinasi.php');
        exit;
    } else {
        $_SESSION['destinasi_error'] = 'Gagal update destinasi';
    }
    $stmt->close();
}

// Handle Delete
if(isset($_GET['delete'])){
    $id = $conn->real_escape_string($_GET['delete']);
    // Get foto filename to delete
    $result = $conn->query("SELECT foto FROM destinasi WHERE id = '$id'");
    if($row = $result->fetch_assoc()){
        $foto_path = '../backend/img/' . $row['foto'];
        if(file_exists($foto_path)){
            unlink($foto_path);
        }
    }
    $conn->query("DELETE FROM destinasi WHERE id = '$id'");
    $_SESSION['destinasi_success'] = 'Destinasi berhasil dihapus';
    header('Location: manage-destinasi.php');
    exit;
}

// Get edit data
$edit_data = null;
if(isset($_GET['edit'])){
    $edit_id = $conn->real_escape_string($_GET['edit']);
    $edit_data = $conn->query("SELECT * FROM destinasi WHERE id = '$edit_id'")->fetch_assoc();
}

// Fetch data
$destinasi_list = $conn->query("SELECT d.*, k.kota, p.provinsi, kat.kategori FROM destinasi d JOIN kota k ON d.id_kota = k.id JOIN provinsi p ON k.id_provinsi = p.id JOIN kategori kat ON d.id_kategori = kat.id ORDER BY d.id DESC");
$kota_list = $conn->query("SELECT k.*, p.provinsi FROM kota k JOIN provinsi p ON k.id_provinsi = p.id");
$kategori_list = $conn->query("SELECT * FROM kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Destinasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <?php if(isset($_SESSION['destinasi_success'])): ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?= $_SESSION['destinasi_success'] ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f97316'
        });
    </script>
    <?php unset($_SESSION['destinasi_success']); endif; ?>
    
    <?php if(isset($_SESSION['destinasi_error'])): ?>
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '<?= $_SESSION['destinasi_error'] ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f97316'
        });
    </script>
    <?php unset($_SESSION['destinasi_error']); endif; ?>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Destinasi Wisata</h1>
            <a href="home-admin.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <!-- Form Tambah/Edit Destinasi -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4"><?= $edit_data ? 'Edit Destinasi' : 'Tambah Destinasi Baru' ?></h2>
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?php if($edit_data): ?>
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                <?php endif; ?>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Destinasi *</label>
                        <input type="text" name="nama_destinasi" required style="text-transform: capitalize;" value="<?= $edit_data ? htmlspecialchars($edit_data['nama_destinasi']) : '' ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Harga (Rp) *</label>
                        <input type="number" name="harga" required min="0" value="<?= $edit_data ? $edit_data['harga'] : '' ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"><?= $edit_data ? htmlspecialchars($edit_data['deskripsi']) : '' ?></textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Kota *</label>
                        <select name="id_kota" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Pilih Kota</option>
                            <?php 
                            $kota_list_form = $conn->query("SELECT k.*, p.provinsi FROM kota k JOIN provinsi p ON k.id_provinsi = p.id");
                            while($kota = $kota_list_form->fetch_assoc()): 
                                $selected = ($edit_data && $edit_data['id_kota'] == $kota['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $kota['id'] ?>" <?= $selected ?>><?= htmlspecialchars($kota['kota']) ?> - <?= htmlspecialchars($kota['provinsi']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Kategori *</label>
                        <select name="id_kategori" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Pilih Kategori</option>
                            <?php 
                            $kategori_list_form = $conn->query("SELECT * FROM kategori");
                            while($kat = $kategori_list_form->fetch_assoc()): 
                                $selected = ($edit_data && $edit_data['id_kategori'] == $kat['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $kat['id'] ?>" <?= $selected ?>><?= htmlspecialchars($kat['kategori']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Foto Destinasi <?= $edit_data ? '(Kosongkan jika tidak ingin mengubah foto)' : '*' ?> (JPG, PNG, GIF)</label>
                    <?php if($edit_data && $edit_data['foto']): ?>
                        <div class="mb-2">
                            <img src="../backend/img/<?= htmlspecialchars($edit_data['foto']) ?>" alt="Current" class="w-32 h-32 object-cover rounded">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto" <?= $edit_data ? '' : 'required' ?> accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div class="flex gap-3">
                    <button type="submit" name="<?= $edit_data ? 'edit_destinasi' : 'tambah_destinasi' ?>" class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-lg hover:from-orange-600 hover:to-red-600 font-semibold">
                        <i class="fas <?= $edit_data ? 'fa-save' : 'fa-plus' ?> mr-2"></i><?= $edit_data ? 'Update Destinasi' : 'Tambah Destinasi' ?>
                    </button>
                    <?php if($edit_data): ?>
                        <a href="manage-destinasi.php" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-semibold">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Daftar Destinasi -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-orange-500 to-red-500">
                <h2 class="text-xl font-semibold text-white">Daftar Destinasi</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php while($dest = $destinasi_list->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900"><?= $dest['id'] ?></td>
                            <td class="px-6 py-4">
                                <img src="../backend/img/<?= htmlspecialchars($dest['foto']) ?>" alt="<?= htmlspecialchars($dest['nama_destinasi']) ?>" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($dest['nama_destinasi']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($dest['kota']) ?>, <?= htmlspecialchars($dest['provinsi']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($dest['kategori']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp <?= number_format($dest['harga'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                <a href="?edit=<?= $dest['id'] ?>" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?delete=<?= $dest['id'] ?>" onclick="return confirm('Yakin ingin menghapus destinasi ini?')" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
