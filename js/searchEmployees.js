function searchEmployees(query) {
  $.ajax({
    url: `http://localhost/api-crud/employee/search.php?search=${query}`,
    type: "GET",
    success: function (response) {
      var employeeTable = $("#employeeTable");
      employeeTable.empty();

      $('#pagination').hide(); // ซ่อน pagination เมื่อทำการค้นหา

      const newURL = `http://127.0.0.1/api-crud/index.php?search=${query}`;
      window.history.pushState({ path: newURL }, '', newURL); 

      if (response.records && response.records.length > 0) {
        let index = 1;
        response.records.forEach(function (employee) {
          employeeTable.append(`
            <tr class="border-b border-gray-200 hover:bg-gray-100">
              <td class="py-3 px-6 text-left">${index++}</td>
              <td class="py-3 px-6 text-left">${employee.student_id}</td>
              <td class="py-3 px-6 text-left">${employee.name} ${employee.lname}</td>
              <td class="py-3 px-6 text-left">
                <img src="img/slip/${employee.slip_img}" alt="Profile Pic" class="w-16 h-16 object-cover rounded-full cursor-pointer viewImage" data-img="img/slip/${employee.slip_img}" data-name="${employee.name}" data-lname="${employee.lname}">
              </td>
              <td class="py-3 px-6 text-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 w-20 rounded editBtn" data-id="${employee.id}">อัปเดต</button>
              </td>
            </tr>
          `);
        });

        // เพิ่มฟังก์ชันคลิกดูรูป
        $(document).on("click", ".viewImage", function () {
          var imgSrc = $(this).data("img"); // ดึง URL รูปภาพจาก data-img
          var name = $(this).data("name");   // ดึงชื่อจาก data-name
          var lname = $(this).data("lname"); // ดึงนามสกุลจาก data-lname

          Swal.fire({
            title: `รูปสลิปของ ${name} ${lname}`, // แสดงชื่อและนามสกุลใน title
            imageUrl: imgSrc,
            imageAlt: 'Profile Pic',
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton: false, // ไม่ต้องแสดงปุ่มยืนยัน
            imageWidth: 400,
            imageHeight: 400,
            imageClass: 'rounded-full' // รูปภาพในป๊อปอัปจะเป็นวงกลม
          });
        });

      } else {
        Swal.fire({
          icon: 'warning',
          title: 'ไม่พบข้อมูลที่ค้นหา',
          text: `ไม่พบข้อมูลที่ตรงกับ "${query}" ในฐานข้อมูล.`
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
    }
  });
}

$("#searchEmployeeBtn").on("click", function () {
  var query = $("#searchInput").val().trim();
  if (!query) {
    Swal.fire({
      icon: 'warning',
      title: 'กรุณาระบุคำค้นหา',
      text: 'โปรดกรอกคำค้นหาในฟอร์มค้นหาก่อนกดปุ่มค้นหา'
    });
    return;
  }
  searchEmployees(query);
});
