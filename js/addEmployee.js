$(document).on("click", "#addEmployeeBtn", function () {
  Swal.fire({
    title: "เพิ่มข้อมูลสลิป",
    html: `
      <input type="text" id="addName" class="swal2-input" placeholder="ชื่อ">
      <input type="text" id="addLname" class="swal2-input" placeholder="นามสกุล">
      <input type="text" id="addStudentId" class="swal2-input" placeholder="รหัสนักศึกษา">
      <label for="addSlipImg" class="swal2-input" style="padding: 0;">
        <input type="file" id="addSlipImg" accept="image/*" display: inline-block; padding: 10px; box-sizing: border-box;">
      </label>
      <img id="previewImage" style="max-width: 100%; margin-top: 10px; display:none;">
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: "เพิ่ม",
    cancelButtonText: "ยกเลิก",
    preConfirm: () => {
      const name = Swal.getPopup().querySelector("#addName").value;
      const lname = Swal.getPopup().querySelector("#addLname").value;
      const student_id = Swal.getPopup().querySelector("#addStudentId").value;
      const slip_img = Swal.getPopup().querySelector("#addSlipImg").files[0]; // เก็บข้อมูลไฟล์รูปภาพ

      if (!name || !lname || !student_id || !slip_img) {
        Swal.showValidationMessage(`กรุณากรอกข้อมูลให้ครบถ้วน`);
        return false;
      }

      // ตรวจสอบว่าประเภทไฟล์ที่อัปโหลดเป็นรูปภาพหรือไม่
      const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
      if (!allowedTypes.includes(slip_img.type)) {
        Swal.showValidationMessage(`ฮั่นแน่! คุณไม่ได้อัปโหลดรูป (JPEG, PNG, GIF)`);
        return false;
      }

      return { name, lname, student_id, slip_img };
    },
    didOpen: () => {
      const inputSlipImg = Swal.getPopup().querySelector("#addSlipImg");
      const previewImage = Swal.getPopup().querySelector("#previewImage");

      inputSlipImg.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            previewImage.src = e.target.result; // แสดงรูปตัวอย่าง
            previewImage.style.display = "block"; // แสดงภาพ
          };
          reader.readAsDataURL(file);
        }
      });
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append("name", result.value.name);
      formData.append("lname", result.value.lname);
      formData.append("student_id", result.value.student_id);
      formData.append("slip_img", result.value.slip_img);

      $.ajax({
        url: "http://localhost/api-crud/employee/create.php",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
          Swal.fire("เพิ่มเรียบร้อย!", `${result.value.name} ได้ถูกเพิ่มเรียบร้อยแล้ว.`, "success");
          loadEmployees(); // โหลดข้อมูลพนักงานใหม่หลังเพิ่มเสร็จ
        },
        error: function (xhr) {
          if (xhr.status === 409) {
            Swal.fire("เกิดข้อผิดพลาด!", "รหัสนักศึกษานี้มีอยู่แล้วในระบบ.", "warning");
          } else {
            Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถเพิ่มพนักงานได้.", "error");
          }
        }
      });
    }
  });
});
