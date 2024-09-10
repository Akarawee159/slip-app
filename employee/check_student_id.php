<?php
include_once '../db/database.php';
include_once '../db/headers.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ดึงข้อมูล student_id จาก request
    $student_id = $_POST['student_id'];

    // ตรวจสอบว่ามีข้อมูล student_id ซ้ำในระบบหรือไม่
    $checkQuery = "SELECT COUNT(*) FROM employees WHERE student_id = :student_id";
    $stmtCheck = $db->prepare($checkQuery);
    $stmtCheck->bindParam(':student_id', $student_id);
    $stmtCheck->execute();
    $rowCount = $stmtCheck->fetchColumn();

    // ส่งข้อมูลกลับว่า student_id มีอยู่ในระบบหรือไม่
    if ($rowCount > 0) {
        echo json_encode(["exists" => true]);
    } else {
        echo json_encode(["exists" => false]);
    }
} else {
    http_response_code(405); // Method not allowed
}
?>
