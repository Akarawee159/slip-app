<?php
include_once '../db/database.php';
include_once '../db/headers.php';

$database = new Database();
$db = $database->getConnection();

if (!empty($_GET['id']) && !empty($_POST['name']) && !empty($_POST['lname']) && !empty($_POST['student_id'])) {

    $id = $_GET['id'];

    // คัดลอกข้อมูลจาก tb employees ไป tb employees_log ก่อน
    $copyQuery = "INSERT INTO employees_log (employee_id, name, lname, student_id, slip_img, update_date, created_at, status)
    SELECT id AS employee_id, name, lname, student_id, slip_img, update_date, created_at, status FROM employees WHERE id = :id";

    $stmtCopy = $db->prepare($copyQuery);
    $stmtCopy->bindParam(':id', $id);

    // ตรวจสอบว่าการคัดลอกสำเร็จหรือไม่
    if ($stmtCopy->execute()) {
        // ตรวจสอบว่าได้อัปโหลดไฟล์ใหม่หรือไม่
        $slip_img = "";
        if (isset($_FILES['slip_img']) && $_FILES['slip_img']['error'] == 0) {
            $fileType = mime_content_type($_FILES['slip_img']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // ประเภทไฟล์ที่อนุญาต

            // ตรวจสอบว่าประเภทไฟล์ที่อัปโหลดคือรูปภาพ
            if (!in_array($fileType, $allowedTypes)) {
                http_response_code(400); // Bad request
                echo json_encode(["message" => "กรุณาอัปโหลดเฉพาะไฟล์รูปภาพ (.jpeg, .png, .gif) เท่านั้น"]);
                exit();
            }

            $target_dir = "../img/slip/";

            // อ่านค่าลำดับที่จากไฟล์ update_slipcounter.txt
            $counterFile = '../img/slip/update_slipcounter.txt';
            if (file_exists($counterFile)) {
                $counter = (int)file_get_contents($counterFile); // อ่านค่าปัจจุบัน
            } else {
                $counter = 0; // ถ้าไฟล์ไม่อยู่ ให้เริ่มต้นที่ 0
            }

            // เพิ่มค่าลำดับที่
            $counter++;
            // อัปเดตไฟล์ update_slipcounter.txt ด้วยลำดับที่ใหม่
            file_put_contents($counterFile, $counter);

            // ตั้งชื่อไฟล์ใหม่ slipUpdate-ตามด้วยลำดับที่
            $newFileName = 'slipUpdate-' . str_pad($counter, 5, '0', STR_PAD_LEFT) . '.' . pathinfo($_FILES['slip_img']['name'], PATHINFO_EXTENSION);

            $target_file = $target_dir . $newFileName;

            // ย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย
            if (!move_uploaded_file($_FILES["slip_img"]["tmp_name"], $target_file)) {
                http_response_code(500);
                echo json_encode(["message" => "Unable to upload profile picture."]);
                exit();
            }

            // อัปเดตชื่อไฟล์ใหม่สำหรับเก็บในฐานข้อมูล
            $slip_img = $newFileName;
        }

        // สร้างคำสั่ง SQL สำหรับการอัปเดต (ถ้ามีรูปให้ใส่ข้อมูลรูปด้วย)
        $query = "UPDATE employees SET name = :name, lname = :lname, student_id = :student_id, update_date = NOW(), status = '200' ";
        if ($slip_img) {
            $query .= ", slip_img = :slip_img";
        }
        $query .= " WHERE id = :id";

        $stmt = $db->prepare($query);

        // bind ค่า
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':lname', $_POST['lname']);
        $stmt->bindParam(':student_id', $_POST['student_id']);
        if ($slip_img) {
            $stmt->bindParam(':slip_img', $slip_img);
        }

        // ดำเนินการอัปเดตข้อมูล
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["message" => "Employee was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update employee."]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Unable to log employee data before update."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Incomplete data."]);
}
?>
