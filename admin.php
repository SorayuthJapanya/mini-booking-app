<?php
require_once "db.php";

try {
    $stmt = $conn->prepare("SELECT * FROM bookings ORDER  BY booking_date ASC, booking_time ASC");
    $stmt->execute();

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Internel Server Error!! " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - จัดการคิว</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard จัดการคิว</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ชื่อลูกค้า</th>
                            <th>วันที่จอง</th>
                            <th>เวลา</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) > 0): ?>
                            <?php foreach ($bookings as $row): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['booking_date'])) ?></td>
                                    <td><?= date('H:i', strtotime($row['booking_time'])) ?> น.</td>

                                    <td>
                                        <?php
                                        // เปลี่ยนสี Badge ตามสถานะ
                                        if ($row['status'] == 'รออนุมัติ') echo '<span class="badge bg-warning text-dark">รออนุมัติ</span>';
                                        elseif ($row['status'] == 'ยืนยันแล้ว') echo '<span class="badge bg-success">ยืนยันแล้ว</span>';
                                        else echo '<span class="badge bg-danger">ยกเลิก</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 'รออนุมัติ'): ?>
                                            <a href="update_status.php?id=<?= $row['id'] ?>&status=ยืนยันแล้ว" class="btn btn-sm btn-success">ยืนยัน</a>
                                            <a href="update_status.php?id=<?= $row['id'] ?>&status=ยกเลิก" class="btn btn-sm btn-danger">ยกเลิก</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">ยังไม่มีข้อมูลการจอง</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>