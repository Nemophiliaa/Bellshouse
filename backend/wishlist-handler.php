<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    exit;
}

require_once 'connection.php';

$user_id = $_SESSION['user_id'];
$id_destinasi = isset($_POST['id_destinasi']) ? $_POST['id_destinasi'] : '';
$action = isset($_POST['action']) ? $_POST['action'] : ''; // 'add' or 'remove'

if(empty($id_destinasi) || empty($action)){
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

if($action === 'add'){
    // Check if already in wishlist
    $check = $conn->prepare("SELECT COUNT(*) as ada FROM wishlist WHERE id_user = ? AND id_destinasi = ?");
    $check->bind_param('ss', $user_id, $id_destinasi);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();
    
    if($result['ada'] > 0){
        echo json_encode(['success' => false, 'message' => 'Sudah ada di wishlist']);
        exit;
    }
    
    // Add to wishlist
    $stmt = $conn->prepare("INSERT INTO wishlist (id_user, id_destinasi) VALUES (?, ?)");
    $stmt->bind_param('ss', $user_id, $id_destinasi);
    
    if($stmt->execute()){
        echo json_encode(['success' => true, 'message' => 'Berhasil ditambahkan ke wishlist', 'action' => 'added']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan ke wishlist']);
    }
    $stmt->close();
    
} elseif($action === 'remove'){
    // Remove from wishlist
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id_user = ? AND id_destinasi = ?");
    $stmt->bind_param('ss', $user_id, $id_destinasi);
    
    if($stmt->execute()){
        echo json_encode(['success' => true, 'message' => 'Berhasil dihapus dari wishlist', 'action' => 'removed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus dari wishlist']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
}

$conn->close();
?>
