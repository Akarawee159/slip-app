<?php
include_once '../db/database.php';
include_once '../db/headers.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ดึงข้อมูลจาก request
    $name = $_POST['name'];
    $lname = $_POST['lname'];
    $student_id = $_POST['student_id'];

    // ตรวจสอบว่ามีข้อมูล student_id ซ้ำในระบบหรือไม่
    $checkQuery = "SELECT COUNT(*) FROM employees WHERE student_id = :student_id";
    $stmtCheck = $db->prepare($checkQuery);
    $stmtCheck->bindParam(':student_id', $student_id);
    $stmtCheck->execute();
    $rowCount = $stmtCheck->fetchColumn();

    if ($rowCount > 0) {
        // ถ้ามีข้อมูล student_id ซ้ำ
        http_response_code(409); // Conflict
        echo json_encode(["message" => "รหัสนักศึกษานี้มีอยู่แล้วในระบบ"]);
        exit();
    }

    // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปหรือไม่
    if (isset($_FILES['slip_img']) && $_FILES['slip_img']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // ประเภทไฟล์ที่อนุญาต
        $fileType = mime_content_type($_FILES['slip_img']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            http_response_code(400); // Bad request
            echo json_encode(["message" => "ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น (JPEG, PNG, GIF)"]);
            exit();
        }

        $uploadDir = '../img/slip/'; // โฟลเดอร์สำหรับเก็บไฟล์

        // อ่านค่าลำดับที่จากไฟล์ slipcounter.txt
        $counterFile = '../img/slip/slipcounter.txt';
        if (file_exists($counterFile)) {
            $counter = (int)file_get_contents($counterFile); // อ่านค่าปัจจุบัน
        } else {
            $counter = 0; // ถ้าไฟล์ไม่อยู่ ให้เริ่มต้นที่ 0
        }

        // เพิ่มค่าลำดับที่
        $counter++;
        // อัปเดตไฟล์ slipcounter.txt ด้วยลำดับที่ใหม่
        file_put_contents($counterFile, $counter);

        // ตั้งชื่อไฟล์ใหม่ slip-ตามด้วยลำดับที่
        $newFileName = 'slip-' . str_pad($counter, 5, '0', STR_PAD_LEFT) . '.' . pathinfo($_FILES['slip_img']['name'], PATHINFO_EXTENSION);
        $uploadFilePath = $uploadDir . $newFileName;

        // ทำการย้ายไฟล์ไปยังโฟลเดอร์
        if (move_uploaded_file($_FILES['slip_img']['tmp_name'], $uploadFilePath)) {
            // ถ้าการอัปโหลดสำเร็จ ให้เก็บชื่อไฟล์ในฐานข้อมูล
            $slip_imgPath = $newFileName;

            // เพิ่มข้อมูลพนักงานพร้อมรูปภาพลงในฐานข้อมูล
            $query = "INSERT INTO employees (name, lname, student_id, slip_img, status) 
                      VALUES (:name, :lname, :student_id, :slip_img, 100)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':slip_img', $slip_imgPath);
            
            if ($stmt->execute()) {
                // หลังจากเพิ่มข้อมูลพนักงานใหม่สำเร็จ ให้คัดลอกข้อมูลไปที่ employees_log
                $lastInsertId = $db->lastInsertId(); // ดึง id ล่าสุดที่เพิ่งเพิ่มเข้าไป

                $logQuery = "INSERT INTO employees_log (employee_id, name, lname, student_id, slip_img, status) 
                             VALUES (:employee_id, :name, :lname, :student_id, :slip_img, 100)";
                $stmtLog = $db->prepare($logQuery);
                $stmtLog->bindParam(':employee_id', $lastInsertId);
                $stmtLog->bindParam(':name', $name);
                $stmtLog->bindParam(':lname', $lname);
                $stmtLog->bindParam(':student_id', $student_id);
                $stmtLog->bindParam(':slip_img', $slip_imgPath);
                $stmtLog->execute(); // บันทึกลง employees_log

                http_response_code(201); // Created
                echo json_encode(["message" => "Employee created successfully and logged."]);
            } else {
                http_response_code(500); // Server error
                echo json_encode(["message" => "Failed to create employee."]);
            }
        } else {
            http_response_code(500); // Server error
            echo json_encode(["message" => "Failed to upload profile picture."]);
        }
    } else {
        http_response_code(400); // Bad request
        echo json_encode(["message" => "No profile picture uploaded or error during upload."]);
    }
}
?>
