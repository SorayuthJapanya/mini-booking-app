<?php
require_once 'db.php';

// เช็คว่ามีค่า id และ status ส่งมากับ URL หรือไม่
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    try {
        $stmt = $conn->prepare("UPDATE bookings SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: admin.php");
            exit(); 
        }
    } catch(PDOException $e) {
        echo "เกิดข้อผิดพลาดในการอัปเดต: " . $e->getMessage();
    }
} else {
    // ถ้าไม่มีการส่งค่ามาให้กลับไปหน้า admin
    header("Location: admin.php");
    exit();
}
?>