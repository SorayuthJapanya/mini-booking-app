<?php
require_once "db.php";
require "navbar.html";

// Validate method post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["customer_name"];
    $date = $_POST["booking_date"];
    $time = $_POST["booking_time"];

    try {
        // Prepare Statement for Protect SQL Injection
        $stmt = $conn->prepare("INSERT INTO bookings (customer_name, booking_date, booking_time) VALUES (:name, :date, :time)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time);

        // Alert
        if ($stmt->execute()) {
            echo "<script>alert('จองคิวสำเร็จ ระบบกำลังรอการอนุมัติ!'); window.location.href='index.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Internal Server Error!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Booking System</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">จองคิว / นัดหมาย</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">ชื่อ-สกุล</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">วันที่ต้องการจอง</label>
                                <input type="date" name="booking_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="booking_time" class="form-label">เวลา</label>
                                <input type="time" name="booking_time" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">ยืนยันการจอง</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>