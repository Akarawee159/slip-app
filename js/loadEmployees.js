    const recordsPerPage = 5; // แสดง 5 รายการต่อหน้า

    // ฟังก์ชันดึงข้อมูลพนักงานพร้อมแบ่งหน้า
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
  
  // ฟังก์ชันดึงข้อมูลพนักงานพร้อมแบ่งหน้า
  function loadEmployees(page = 1) {
    $.ajax({
      url: `http://localhost/api-crud/employee/read.php`,
      type: "GET",
      data: { page: page, limit: recordsPerPage }, // ส่ง page และ limit ไปที่ API
      success: function (response) {
        var employeeTable = $("#employeeTable");
        employeeTable.empty();
  
        if (response.records) {
          let index = (page - 1) * recordsPerPage + 1; // คำนวณลำดับที่สำหรับหน้าใหม่
  
          response.records.forEach(function (employee) {
            employeeTable.append(`
              <tr class="border-b border-gray-200 hover:bg-gray-100">
                  <td class="py-3 px-6 text-left">${index++}</td>
                  <td class="py-3 px-6 text-left">${employee.student_id}</td>
                  <td class="py-3 px-6 text-left">${employee.name} ${employee.lname}</td>
                  <td class="py-3 px-6 text-left">
                    <img src="img/slip/${employee.slip_img}" alt="Profile Pic" 
                         class="w-16 h-16 object-cover rounded-full cursor-pointer viewImage" 
                         data-img="img/slip/${employee.slip_img}" 
                         data-name="${employee.name}" 
                         data-lname="${employee.lname}">
                  </td>
                  <td class="py-3 px-6 text-center lg:flex lg:justify-center lg:space-x-4">
                      <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 w-full lg:w-20 rounded mb-2 lg:mb-0 editBtn" data-id="${
                        employee.id
                      }">อัปเดต</button>
                  </td>
              </tr>
            `);
          });
  
          // เรียกฟังก์ชันสร้างปุ่ม Pagination
          createPagination(response.totalPages, page);
        } else {
          employeeTable.append(
            '<tr><td colspan="6">ไม่พบข้อมูลพนักงาน</td></tr>'
          );
        }
      },
      error: function (xhr, status, error) {
        console.log("Error:", error); // ตรวจสอบว่ามีข้อผิดพลาดใดๆ เกิดขึ้นหรือไม่
      },
    });
  }
  
    

    // ฟังก์ชันสร้าง Pagination
    function createPagination(totalPages, currentPage) {
      var paginationContainer = $("#pagination");
      paginationContainer.empty(); // ล้างข้อมูลก่อนหน้าที่

      // ปุ่ม "ก่อนหน้า"
      if (currentPage > 1) {
        paginationContainer.append(
          `<button class="bg-gray-300 px-3 py-1 rounded" id="prevPage">ก่อนหน้า</button>`
        );
      }

      // แสดงปุ่มเลขหน้า
      for (let i = 1; i <= totalPages; i++) {
        if (i == currentPage) {
          paginationContainer.append(
            `<button class="bg-blue-500 text-white px-3 py-1 rounded mx-1">${i}</button>`
          );
        } else {
          paginationContainer.append(
            `<button class="bg-gray-300 px-3 py-1 rounded mx-1" data-page="${i}">${i}</button>`
          );
        }
      }

      // ปุ่ม "ถัดไป"
      if (currentPage < totalPages) {
        paginationContainer.append(
          `<button class="bg-gray-300 px-3 py-1 rounded" id="nextPage">ถัดไป</button>`
        );
      }

      // ปุ่ม "ก่อนหน้า" คลิก
      $("#prevPage").on("click", function () {
        var newPage = currentPage - 1;
        updateURL(newPage);
        loadEmployees(newPage);
      });

      // ปุ่ม "ถัดไป" คลิก
      $("#nextPage").on("click", function () {
        var newPage = currentPage + 1;
        updateURL(newPage);
        loadEmployees(newPage);
      });

      // คลิกที่ปุ่มเลขหน้า
      $("button[data-page]").on("click", function () {
        var newPage = $(this).data("page");
        updateURL(newPage);
        loadEmployees(newPage);
      });
    }

    // ฟังก์ชันอัปเดต URL
    function updateURL(page) {
      const newURL = `http://127.0.0.1/api-crud/index.php?page=${page}`;
      window.history.pushState({ path: newURL }, "", newURL); // อัปเดต URL
    }

    // โหลดพนักงานครั้งแรกโดยเช็ค URL ว่ามี page หรือไม่
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get("page")
      ? parseInt(urlParams.get("page"))
      : 1;
    loadEmployees(currentPage); // โหลดพนักงานตาม page ปัจจุบัน