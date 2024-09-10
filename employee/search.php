<?php
include_once '../db/database.php';
include_once '../db/headers.php';

$database = new Database();
$db = $database->getConnection();

// ตรวจสอบว่ามีพารามิเตอร์ค้นหาหรือไม่
$search = isset($_GET['search']) ? $_GET['search'] : '';

// คำสั่ง SQL สำหรับค้นหาข้อมูลพนักงานจากหลายคอลัมน์ พร้อมดึงข้อมูล slip_img
$query = "SELECT id, name, lname, student_id, slip_img, created_at 
          FROM employees 
          WHERE name LIKE :search 
             OR lname LIKE :search 
             OR student_id LIKE :search";

$stmt = $db->prepare($query);
$search_param = "%{$search}%";
$stmt->bindParam(":search", $search_param);

$stmt->execute();
$num = $stmt->rowCount();

// ตรวจสอบว่าพบข้อมูลหรือไม่
if($num > 0){
    $employees_arr = [];
    $employees_arr["records"] = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $employee_item = [
            "id" => $id,
            "name" => $name,
            "lname" => $lname,
            "student_id" => $student_id,
            "slip_img" => $slip_img, // เพิ่มการดึงข้อมูลรูปภาพ
            "created_at" => $created_at
        ];

        array_push($employees_arr["records"], $employee_item);
    }

    // ตั้งค่า HTTP response เป็น 200 OK และส่งข้อมูลในรูปแบบ JSON
    http_response_code(200);
    echo json_encode($employees_arr);
} else {
    // ถ้าไม่พบข้อมูลใด ๆ
    http_response_code(404);
    echo json_encode(["message" => "ไม่พบข้อมูลพนักงานที่คุณค้นหา."]);
}
?>
