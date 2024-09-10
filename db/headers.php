<?php
header("Content-Type: application/json; charset=UTF-8"); // กำหนดประเภทเนื้อหาที่จะส่งเป็น JSON
header("Access-Control-Allow-Origin: *"); // อนุญาตทุกโดเมนเข้าถึง
header("Access-Control-Max-Age: 3600"); // ระบุอายุของการอนุญาต CORS (เป็นวินาที)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); // อนุญาตให้ใช้วิธี GET, POST, OPTIONS, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // อนุญาต headers ที่จะถูกส่งมาในคำขอ

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { // ถ้าคำขอเป็น OPTIONS (preflight request)
    http_response_code(200); // ส่งกลับสถานะ 200 OK
    exit; // จบการทำงานเพื่อไม่ต้องดำเนินการต่อในคำขอ OPTIONS
}
?>
