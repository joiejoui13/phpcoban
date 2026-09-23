<?php
//kết nối csdl mysql bằng PDO
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'quanlybanhang';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Thiết lập chế độ lỗi PDO thành ngoại lệ
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối thành công ";
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
/*. Hiển thị dữ liệu customize dạng bảng, dạng DIV: thực hiện trong file listLoaiSP.php, sử dụng thẻ <table>, <div>
     và vòng lặp foreach.

2. Kiểm tra dữ liệu trước khi thêm: thực hiện trong file formThemLoaiSP.php, sử dụng JavaScript với
 hàm kiemTraDuLieu() và sự kiện onsubmit.

3. Xác thực xóa: thực hiện trong file listLoaiSP.php, sử dụng JavaScript với hàm confirm() thông qua hàm xacNhanXoa().

4. Thông báo thêm, xóa thành công: JavaScript hiển thị thông báo trong file listLoaiSP.php. File themLoaiSP.php 
truyền ?them=1 sau khi thêm thành công, file xoaLoaiSP.php truyền ?xoa=1 sau khi xóa thành công.
 listLoaiSP.php nhận tham số và sử dụng alert() để thông báo. */
 
?>
