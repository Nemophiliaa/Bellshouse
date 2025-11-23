<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

require_once '../../backend/connection.php';

$id_pesanan = isset($_GET['id']) ? $_GET['id'] : '';
$user_id = $_SESSION['user_id'];

if(!$id_pesanan){
    $_SESSION['cancel_error'] = 'ID Pesanan tidak valid!';
    header('Location: mytrip.php');
    exit;
}

// Verify ownership and check if cancellable
$stmt = $conn->prepare("SELECT status FROM pesanan WHERE id = ? AND id_data_user = ?");
$stmt->bind_param('ss', $id_pesanan, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    $_SESSION['cancel_error'] = 'Pesanan tidak ditemukan!';
    $stmt->close();
    header('Location: mytrip.php');
    exit;
}

$pesanan = $result->fetch_assoc();
$stmt->close();

// Check if can be cancelled
if($pesanan['status'] === 'cancelled' || $pesanan['status'] === 'completed'){
    $_SESSION['cancel_warning'] = 'Pesanan tidak dapat dibatalkan!';
    header('Location: mytrip.php');
    exit;
}

// Update status to cancelled
$stmt = $conn->prepare("UPDATE pesanan SET status = 'cancelled' WHERE id = ?");
$stmt->bind_param('s', $id_pesanan);

if($stmt->execute()){
    $_SESSION['cancel_success'] = 'Pesanan berhasil dibatalkan!';
} else {
    $_SESSION['cancel_error'] = 'Gagal membatalkan pesanan!';
}

$stmt->close();
$conn->close();
header('Location: mytrip.php');
exit;
?>
