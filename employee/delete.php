<?php
include_once '../db/database.php';
include_once '../db/headers.php';

$database = new Database();
$db = $database->getConnection();

// ตรวจสอบว่ามีการส่ง 'id' มาหรือไม่
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // สร้างคำสั่ง SQL สำหรับการลบข้อมูล
    $query = "DELETE FROM employees WHERE id = :id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);

    // ดำเนินการลบข้อมูล
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["message" => "Employee was deleted."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Unable to delete employee."]);
    }
} else {
    // ถ้าข้อมูลไม่ครบ
    http_response_code(400);
    echo json_encode(["message" => "Incomplete data."]);
}
?>
