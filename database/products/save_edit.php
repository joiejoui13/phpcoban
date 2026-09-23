<?php
//sửa thông tin sản phẩm trong bảng SanPham
#Bước 0. Lấy dữ liệu từ form gửi lên
$maSP = $_POST['MaSP'];
$tenSP = $_POST['TenSP'];
$moTa = $_POST['MoTa'];
$soLuong = $_POST['SoLuong'];
$donGia = $_POST['DonGia'];
$maLoaiSP = $_POST['MaLoaiSP'];
$moTaHinhAnh = $_POST['MoTaHinhAnh'];
#Bước 1. Kết nối CSDL
include_once("../connect.php");
try{
    # Lấy tên ảnh cũ từ CSDL (an toàn hơn tin vào dữ liệu gửi từ form)
    $stmtCu = $conn->prepare("SELECT HinhAnh FROM SanPham WHERE MaSP = :MaSP");
    $stmtCu->bindParam(':MaSP', $maSP);
    $stmtCu->execute();
    $hinhAnhCu = $stmtCu->fetchColumn();
    $hinhAnh = $hinhAnhCu; // Mặc định giữ ảnh cũ
    $uploadDir = '../../public/image/';
    $anhMoi = false; // Đánh dấu có upload ảnh mới hay không

    # Xử lý upload ảnh mới (nếu người dùng có chọn)
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['HinhAnh']['error'] !== UPLOAD_ERR_OK) {
            die("Có lỗi xảy ra khi upload file. <a href='edit.php?MaSP=$maSP'>Quay lại</a>");
        }
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Kiểm tra kiểu file dạng ảnh và kích thước file < 2MB
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $fileType = strtolower(pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedTypes)) {
            die("Chỉ cho phép upload file ảnh (JPG, JPEG, PNG, GIF). <a href='edit.php?MaSP=$maSP'>Quay lại</a>");
        }
        if ($_FILES['HinhAnh']['size'] > $maxFileSize) {
            die("Kích thước file không được vượt quá 2MB. <a href='edit.php?MaSP=$maSP'>Quay lại</a>");
        }
        if (getimagesize($_FILES['HinhAnh']['tmp_name']) === false) {
            die("File tải lên không phải là ảnh hợp lệ. <a href='edit.php?MaSP=$maSP'>Quay lại</a>");
        }

        // Đặt tên mới để tránh trùng tên làm ghi đè ảnh khác
        $newName = uniqid('sp_') . '.' . $fileType;
        if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $uploadDir . $newName)) {
            $hinhAnh = $newName;
            $anhMoi = true;
        } else {
            die("Có lỗi xảy ra khi lưu file. <a href='edit.php?MaSP=$maSP'>Quay lại</a>");
        }
    }

    #Bước 2. Viết câu lệnh truy vấn
    $sql = "UPDATE SanPham SET TenSP = :TenSP, MoTa = :MoTa, SoLuong = :SoLuong, DonGia = :DonGia,
            MaLoaiSP = :MaLoaiSP, HinhAnh = :HinhAnh, MoTaHinhAnh = :MoTaHinhAnh
            WHERE MaSP = :MaSP";
    #Bước 3. Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    #Bước 4. Gán giá trị cho các tham số
    $stmt->bindParam(':MaSP', $maSP);
    $stmt->bindParam(':TenSP', $tenSP);
    $stmt->bindParam(':MoTa', $moTa);
    $stmt->bindParam(':SoLuong', $soLuong);
    $stmt->bindParam(':DonGia', $donGia);
    $stmt->bindParam(':MaLoaiSP', $maLoaiSP);
    $stmt->bindParam(':HinhAnh', $hinhAnh);
    $stmt->bindParam(':MoTaHinhAnh', $moTaHinhAnh);
    #Bước 5. Thực thi câu lệnh
    $stmt->execute();

    # Sửa thành công và có ảnh mới thì xóa file ảnh cũ khỏi thư mục
    if ($anhMoi && !empty($hinhAnhCu) && file_exists($uploadDir . basename($hinhAnhCu))) {
        unlink($uploadDir . basename($hinhAnhCu));
    }
    #echo "Sửa sản phẩm thành công!";
    header("Location: list.php?info=updatesuccess"); // Chuyển hướng về trang danh sách sản phẩm sau khi sửa thành công
    exit();
}
catch(PDOException $e){
    # Nếu lỗi CSDL mà đã lỡ upload ảnh mới thì xóa ảnh đó đi cho khỏi thừa file
    if (!empty($anhMoi) && file_exists($uploadDir . $hinhAnh)) {
        unlink($uploadDir . $hinhAnh);
    }
    echo "Lỗi: " . $e->getMessage();
}
    $conn=null;
?>