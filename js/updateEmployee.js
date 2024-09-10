$(document).on("click", ".editBtn", function () {
  var id = $(this).data("id");

  $.get("http://localhost/api-crud/employee/read.php?id=" + id, function (employee) {
    let profilePicPath = employee.slip_img ? `img/slip/${employee.slip_img}` : "img/slip/default-profile.png"; // ตรวจสอบรูป

    Swal.fire({
      title: "อัปเดตข้อมูล",
      html: `
        <div class="flex justify-between items-center mb-4">
          <label for="updateStudentId" class="mr-4 w-1/3 text-right">รหัสนักศึกษา</label>
          <input type="text" id="updateStudentId" class="swal2-input w-2/3" placeholder="รหัสนักศึกษา" value="${employee.student_id}" readonly>
        </div>

        <div class="flex justify-between items-center mb-4">
          <label for="updateName" class="mr-4 w-1/3 text-right">ชื่อ</label>
          <input type="text" id="updateName" class="swal2-input w-2/3" placeholder="ชื่อ" value="${employee.name}">
        </div>

        <div class="flex justify-between items-center mb-4">
          <label for="updatelname" class="mr-4 w-1/3 text-right">นามสกุล</label>
          <input type="text" id="updatelname" class="swal2-input w-2/3" placeholder="นามสกุล" value="${employee.lname}">
        </div>

        <div class="flex justify-between items-center mb-4">
          <label for="updateSlipImg" class="mr-4 w-1/3 text-right">โปรไฟล์</label>
          <input type="file" id="updateSlipImg" class="swal2-input w-2/3" accept="image/*">
        </div>

        <div class="flex justify-center">
          <img id="previewImage" src="${profilePicPath}" alt="Profile Pic" class="w-32 h-32 object-cover rounded-lg mt-2">
        </div>
      `,
      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: "อัปเดต",
      cancelButtonText: "ยกเลิก",
      preConfirm: () => {
        const name = Swal.getPopup().querySelector("#updateName").value;
        const lname = Swal.getPopup().querySelector("#updatelname").value;
        const student_id = Swal.getPopup().querySelector("#updateStudentId").value;
        const slip_img = Swal.getPopup().querySelector("#updateSlipImg").files[0];

        if (!name || !lname || !student_id) {
          Swal.showValidationMessage(`กรุณากรอกข้อมูลให้ครบถ้วน`);
          return false;
        }

        // ตรวจสอบประเภทไฟล์ว่าถูกต้องหรือไม่
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (slip_img && !allowedTypes.includes(slip_img.type)) {
          Swal.showValidationMessage(`ฮั่นแน่! คุณไม่ได้อัปโหลดรูป (JPEG, PNG, GIF)`);
          return false;
        }

        return { name, lname, slip_img };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
        formData.append('name', result.value.name);
        formData.append('lname', result.value.lname);
        formData.append('student_id', employee.student_id); // student_id ถูกตั้งค่าเป็น readonly
        if (result.value.slip_img) {
          formData.append('slip_img', result.value.slip_img); // ส่งรูปภาพ
        }

        $.ajax({
          url: "http://localhost/api-crud/employee/update.php?id=" + id,
          type: "POST",
          processData: false,
          contentType: false,
          data: formData,
          success: function (response) {
            Swal.fire("อัปเดตเรียบร้อย!", `ข้อมูล ${result.value.name} ได้ถูกอัปเดตเรียบร้อยแล้ว.`, "success").then(() => {
              const searchParams = new URLSearchParams(window.location.search);
              const currentSearch = searchParams.get("search"); // ดึงค่าคำค้นหาจาก URL
              
              if (currentSearch) {
                searchEmployees(currentSearch);  // รีเฟรชข้อมูลตามการค้นหา
              } else {
                const currentPage = searchParams.get("page") || 1;
                loadEmployees(currentPage); // รีเฟรชข้อมูลตามหน้า
              }
            });
          },
          error: function () {
            Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถอัปเดตข้อมูลได้.", "error");
          },
        });
      }
    });

    // แสดงตัวอย่างรูปภาพใหม่เมื่อเลือกไฟล์
    $("#updateSlipImg").on("change", function (event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          $("#previewImage").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
      }
    });
  });
});
