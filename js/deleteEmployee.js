$(document).on("click", ".deleteBtn", function () {
    var id = $(this).data("id");

    // ดึงข้อมูลพนักงานก่อนลบเพื่อแสดงชื่อ
    $.get("http://localhost/api-crud/employee/read.php?id=" + id, function (employee) {
        var employeeName = employee.name;

        // ใช้ SweetAlert2 เพื่อยืนยันการลบ
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: `การลบพนักงาน ${employeeName} ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่, ลบเลย!",
            cancelButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                // ดึงข้อมูลพนักงานจากหน้าเพจปัจจุบัน
                $.ajax({
                    url: "http://localhost/api-crud/employee/delete.php?id=" + id,
                    type: "DELETE",
                    success: function (response) {
                        // ตรวจสอบจำนวนข้อมูลในหน้านั้นว่ามี 1 รายการหรือไม่
                        const totalEmployeesInPage = $("#employeeTable tr").length;

                        Swal.fire("ลบเรียบร้อย!", `พนักงาน ${employeeName} ได้ถูกลบแล้ว.`, "success").then(() => {
                            if (totalEmployeesInPage === 1) {
                                // ถ้ามีข้อมูลเหลือเพียงรายการเดียว ให้ไปที่หน้าแรก
                                window.location.href = `http://127.0.0.1/api-crud/index.php?page=1`;
                            } else {
                                // ถ้าไม่ได้อยู่ที่หน้าแรก ให้รีเฟรชข้อมูลในหน้าปัจจุบัน
                                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
                                loadEmployees(currentPage);
                            }
                        });
                    },
                    error: function () {
                        Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถลบพนักงานได้.", "error");
                    },
                });
            }
        });
    });
});
