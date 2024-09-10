<?php
include_once '../db/database.php';
include_once '../db/headers.php';

$database = new Database();
$db = $database->getConnection();

// ตรวจสอบว่ามีการส่ง id มาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // สร้างคำสั่ง SQL เพื่อค้นหาพนักงานตาม id
    $query = "SELECT id, name, lname, student_id, created_at FROM employees WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $employee_arr = [
            "id" => $row['id'],
            "name" => $row['name'],
            "lname" => $row['lname'],
            "student_id" => $row['student_id'],
            "created_at" => $row['created_at']
        ];

        // ส่งค่ากลับในรูปแบบ JSON
        http_response_code(200);
        echo json_encode($employee_arr);
    } else {
        // หากไม่พบพนักงาน
        http_response_code(404);
        echo json_encode(["message" => "Employee not found."]);
    }
} else {
    // ตรวจสอบว่ามีการส่ง page และ limit หรือไม่
    if (isset($_GET['page']) && isset($_GET['limit'])) {
        // กำหนดค่าเริ่มต้นสำหรับหน้าและจำนวนรายการต่อหน้า
        $page = intval($_GET['page']);
        $limit = intval($_GET['limit']); 
        $offset = ($page - 1) * $limit;

        // ดึงข้อมูลจำนวนพนักงานทั้งหมด
        $countQuery = "SELECT COUNT(*) as total FROM employees ORDER BY student_id ASC";
        $countStmt = $db->prepare($countQuery);
        $countStmt->execute();
        $row = $countStmt->fetch(PDO::FETCH_ASSOC);
        $totalEmployees = $row['total'];
        $totalPages = ceil($totalEmployees / $limit);

        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลพนักงานตามหน้า
        $query = "SELECT id, name, lname, student_id, slip_img, created_at FROM employees LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $employees_arr = [];
            $employees_arr["records"] = [];
            $employees_arr["totalPages"] = $totalPages; // จำนวนหน้าทั้งหมด
            $employees_arr["currentPage"] = $page; // หน้าปัจจุบัน

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $employee_item = [
                    "id" => $id,
                    "name" => $name,
                    "lname" => $lname,
                    "student_id" => $student_id,
                    "slip_img" => $slip_img, 
                    "created_at" => $created_at
                ];
                

                array_push($employees_arr["records"], $employee_item);
            }

            http_response_code(200);
            echo json_encode($employees_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No employees found."]);
        }
    } else {
        // ถ้าไม่ส่ง page และ limit ให้แสดงพนักงานทั้งหมด
        $query = "SELECT id, name, lname, student_id, created_at FROM employees";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $employees_arr = [];
            $employees_arr["records"] = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $employee_item = [
                    "id" => $id,
                    "name" => $name,
                    "lname" => $lname,
                    "student_id" => $student_id,
                    "created_at" => $created_at
                ];

                array_push($employees_arr["records"], $employee_item);
            }

            http_response_code(200);
            echo json_encode($employees_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No employees found."]);
        }
    }
}
?>
