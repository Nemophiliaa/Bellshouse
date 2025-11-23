<?php
require_once 'connection.php';

// Auto-generate ID untuk semua destinasi yang belum punya ID atau ID kosong
$query = $conn->query("SELECT * FROM destinasi WHERE id IS NULL OR id = '' ORDER BY id");

$counter = 1;
$updated = 0;

while($row = $query->fetch_assoc()) {
    // Generate ID dengan format DST0001, DST0002, dst
    $new_id = 'DST' . str_pad($counter, 4, '0', STR_PAD_LEFT);
    
    // Cek apakah ID sudah ada
    $check = $conn->query("SELECT id FROM destinasi WHERE id = '$new_id'");
    if($check->num_rows > 0) {
        $counter++;
        continue;
    }
    
    // Update ID
    $old_id = $row['id'];
    $stmt = $conn->prepare("UPDATE destinasi SET id = ? WHERE id = ? OR (id IS NULL AND nama_destinasi = ?)");
    $stmt->bind_param('sss', $new_id, $old_id, $row['nama_destinasi']);
    
    if($stmt->execute()) {
        echo "Updated: {$row['nama_destinasi']} -> ID: $new_id<br>";
        $updated++;
    }
    
    $stmt->close();
    $counter++;
}

echo "<br><strong>Total updated: $updated destinasi</strong><br>";
echo "<a href='../src/pages/home.php'>Kembali ke Home</a>";
?>
