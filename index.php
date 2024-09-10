<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ข้อมูลอัปเดตสลีป สป67/15</title>
  <!-- Tailwind CSS CDN -->
  <link
    href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
    rel="stylesheet" />
  <!-- SweetAlert2 CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body class="bg-gray-100 font-sans">
  <!-- Main Flex Container -->
  <div class="flex h-screen">

    <!-- Include Sidebar -->


    <!-- Main Content -->
    <div class="flex-1 p-10">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">
        ข้อมูลอัปเดต สลิปออนไลน์ สป67/15 (งานพิธีไหว้ครู)
      </h1>

      <!-- ฟอร์มค้นหา -->
      <div class="flex flex-col md:flex-row items-center py-4 space-y-4 md:space-y-0 md:space-x-2">
        <input
          type="text"
          id="searchInput"
          class="w-full border border-gray-300 p-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          placeholder="ค้นหานักศึกษา..." />

        <button
          id="searchEmployeeBtn"
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md w-full md:w-32">
          ค้นหา
        </button>

        <button
          id="clearEmployeeBtn"
          class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-md shadow-md w-full md:w-32">
          เคลียร์
        </button>

        <button
          id="addEmployeeBtn"
          class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md w-full md:w-56">
          เพิ่มข้อมูล
        </button>
      </div>

      <!-- ตารางแสดงข้อมูลพนักงาน -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
          <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
              <th class="py-3 px-6 text-left">ลำดับที่</th>
              <th class="py-3 px-6 text-left">รหัสนักศึกษา</th>
              <th class="py-3 px-6 text-left">ชื่อ - นามสกุล</th>
              <th class="py-3 px-6 text-left">รูปสลิป</th> <!-- เพิ่มคอลัมน์รูปภาพ -->
              <th class="py-3 px-6 text-center">การดำเนินการ</th>
            </tr>
          </thead>
          <tbody id="employeeTable" class="text-gray-600 text-sm font-light">
            <!-- ข้อมูลพนักงานจะถูกแทรกที่นี่ -->
          </tbody>

        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-4">
        <div id="pagination" class="flex space-x-2">
          <!-- ปุ่ม pagination จะถูกแทรกที่นี่ -->
        </div>
      </div>
    </div>
  </div>

  <!-- SweetAlert2 JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/addEmployee.js"></script>
  <script src="js/searchEmployees.js"></script>
  <script src="js/deleteEmployee.js"></script>
  <script src="js/updateEmployee.js"></script>
  <script src="js/loadEmployees.js"></script>

  <!-- Clear button script -->
  <script>
    $("#clearEmployeeBtn").on("click", function() {
      // ล้างข้อมูลในฟิลด์ค้นหา
      $("#searchInput").val("");

      // รีเฟรชไปที่หน้าแรก
      window.location.href = `http://127.0.0.1/api-crud/index.php?page=1`;
    });
  </script>
</body>

</html>