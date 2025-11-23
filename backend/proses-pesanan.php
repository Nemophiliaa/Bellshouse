<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header('Location: ../src/pages/login.php');
    exit;
}

// Validate POST data
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../src/pages/home.php');
    exit;
}

$id_user = $_SESSION['user_id'];
$id_destinasi = isset($_POST['id_destinasi']) ? $_POST['id_destinasi'] : '';
$tgl_berangkat = isset($_POST['tgl_berangkat']) ? $_POST['tgl_berangkat'] : '';
$tgl_pulang = isset($_POST['tgl_pulang']) ? $_POST['tgl_pulang'] : '';
$jumlah_orang = isset($_POST['jumlah_orang']) ? (int)$_POST['jumlah_orang'] : 0;
$total_bayar = isset($_POST['total_bayar']) ? (int)$_POST['total_bayar'] : 0;
$peserta = isset($_POST['peserta']) ? $_POST['peserta'] : [];

// Validation
if(empty($id_destinasi) || empty($tgl_berangkat) || empty($tgl_pulang) || $jumlah_orang <= 0 || empty($peserta)){
    echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>
        Swal.fire({
            title: "Gagal!",
            text: "Data pemesanan tidak lengkap!",
            icon: "error",
            confirmButtonText: "OK",
            confirmButtonColor: "#f97316"
        }).then(() => {
            window.history.back();
        });
    </script></body></html>';
    exit;
}

// Validate jumlah peserta matches jumlah_orang
if(count($peserta) !== $jumlah_orang){
    echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>
        Swal.fire({
            title: "Gagal!",
            text: "Jumlah data peserta tidak sesuai!",
            icon: "error",
            confirmButtonText: "OK",
            confirmButtonColor: "#f97316"
        }).then(() => {
            window.history.back();
        });
    </script></body></html>';
    exit;
}

// Generate ID Pesanan (PSN0001)
$query_last_id = "SELECT id FROM pesanan ORDER BY id DESC LIMIT 1";
$result = $conn->query($query_last_id);

$new_id = 'PSN0001';
if($result && $result->num_rows > 0){
    $last_row = $result->fetch_assoc();
    $last_id = $last_row['id'];
    
    // Extract number from last ID (PSN0001 -> 1)
    $last_number = (int)substr($last_id, 3);
    $new_number = $last_number + 1;
    $new_id = 'PSN' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
}

// Start transaction
$conn->begin_transaction();

try {
    // Insert into pesanan table
    $tanggal_pemesanan = date('Y-m-d H:i:s');
    $status = 'pending'; // default status
    
    $sql_pesanan = "INSERT INTO pesanan (id, id_data_user, destinasi, tanggal_pemesanan, tanggal_keberangkatan, tanggal_kepulangan, jumlah_orang, total_bayar, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql_pesanan);
    $stmt->bind_param('ssssssiis', $new_id, $id_user, $id_destinasi, $tanggal_pemesanan, $tgl_berangkat, $tgl_pulang, $jumlah_orang, $total_bayar, $status);
    
    if(!$stmt->execute()){
        throw new Exception('Gagal menyimpan data pesanan: ' . $stmt->error);
    }
    $stmt->close();
    
    // Insert into pesanan_peserta table
    $sql_peserta = "INSERT INTO pesanan_peserta (id_pesanan, nama_lengkap, jenis_kelamin, no_identitas, tipe_peserta) 
                    VALUES (?, ?, ?, ?, ?)";
    
    $stmt_peserta = $conn->prepare($sql_peserta);
    
    foreach($peserta as $index => $data_peserta){
        $nama = trim($data_peserta['nama_lengkap']);
        $jenis_kelamin = $data_peserta['jenis_kelamin'];
        $no_identitas = trim($data_peserta['no_identitas']);
        $tipe_peserta = $data_peserta['tipe_peserta'];
        
        // Validate each peserta data
        if(empty($nama) || empty($jenis_kelamin) || empty($no_identitas) || empty($tipe_peserta)){
            throw new Exception('Data peserta ' . ($index + 1) . ' tidak lengkap!');
        }
        
        $stmt_peserta->bind_param('sssss', $new_id, $nama, $jenis_kelamin, $no_identitas, $tipe_peserta);
        
        if(!$stmt_peserta->execute()){
            throw new Exception('Gagal menyimpan data peserta ' . ($index + 1) . ': ' . $stmt_peserta->error);
        }
    }
    
    $stmt_peserta->close();
    
    // Commit transaction
    $conn->commit();
    
    // Redirect to success page or mytrip
    echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>
        Swal.fire({
            title: "Berhasil!",
            text: "Pemesanan berhasil! ID Pesanan: ' . $new_id . '",
            icon: "success",
            confirmButtonText: "OK",
            confirmButtonColor: "#f97316"
        }).then(() => {
            window.location.href="../src/pages/mytrip.php";
        });
    </script></body></html>';
    exit;
    
} catch(Exception $e){
    // Rollback transaction on error
    $conn->rollback();
    
    echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>
        Swal.fire({
            title: "Gagal!",
            text: "Pemesanan gagal: ' . addslashes($e->getMessage()) . '",
            icon: "error",
            confirmButtonText: "OK",
            confirmButtonColor: "#f97316"
        }).then(() => {
            window.history.back();
        });
    </script></body></html>';
    exit;
}

$conn->close();
?>
