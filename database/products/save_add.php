<?php
    #Thực hiện thêm sản phẩm mới vào bảng SanPham
    #Bước 0. Lấy dữ liệu từ form gửi lên
    $tenSP = $_POST['TenSP'];
    $moTa = $_POST['MoTa'];
    $soLuong = $_POST['SoLuong'];
    $donGia = $_POST['DonGia'];
    $maLoaiSP = $_POST['MaLoaiSP'];
    $moTaHinhAnh = $_POST['MoTaHinhAnh'];
    $hinhAnh = null; // Tên file ảnh sẽ lưu vào CSDL

    #Xử lý upload hình ảnh (không bắt buộc phải chọn ảnh)
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['HinhAnh']['error'] !== UPLOAD_ERR_OK) {
            die("Có lỗi xảy ra khi upload file. <a href='add.php'>Quay lại</a>");
        }

        $uploadDir = '../../public/image/'; // Thư mục lưu ảnh
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Kiểm tra kiểu file dạng ảnh và kích thước file < 2MB
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $fileType = strtolower(pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedTypes)) {
            die("Chỉ cho phép upload file ảnh (JPG, JPEG, PNG, GIF). <a href='add.php'>Quay lại</a>");
        }
        if ($_FILES['HinhAnh']['size'] > $maxFileSize) {
            die("Kích thước file không được vượt quá 2MB. <a href='add.php'>Quay lại</a>");
        }
        if (getimagesize($_FILES['HinhAnh']['tmp_name']) === false) {
            die("File tải lên không phải là ảnh hợp lệ. <a href='add.php'>Quay lại</a>");
        }

        // Đặt tên mới để tránh trùng tên làm ghi đè ảnh cũ
        $newName = uniqid('sp_') . '.' . $fileType;

        // Di chuyển file từ thư mục tạm sang thư mục lưu ảnh
        if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $uploadDir . $newName)) {
            $hinhAnh = $newName;
        } else {
            die("Có lỗi xảy ra khi lưu file. <a href='add.php'>Quay lại</a>");
        }
    }

    #Bước 1. Kết nối CSDL
    include_once("../connect.php");
    try{
        #Bước 2. Viết câu lệnh truy vấn (MaSP tự tăng nên không cần insert)
        $sql = "INSERT INTO SanPham (TenSP, MoTa, SoLuong, DonGia, MaLoaiSP, HinhAnh, MoTaHinhAnh)
                VALUES (:TenSP, :MoTa, :SoLuong, :DonGia, :MaLoaiSP, :HinhAnh, :MoTaHinhAnh)";
        #Bước 3. Chuẩn bị câu lệnh
        $stmt = $conn->prepare($sql);
        #Bước 4. Gán giá trị cho các tham số
        $stmt->bindParam(':TenSP', $tenSP);
        $stmt->bindParam(':MoTa', $moTa);
        $stmt->bindParam(':SoLuong', $soLuong);
        $stmt->bindParam(':DonGia', $donGia);
        $stmt->bindParam(':MaLoaiSP', $maLoaiSP);
        $stmt->bindParam(':HinhAnh', $hinhAnh);
        $stmt->bindParam(':MoTaHinhAnh', $moTaHinhAnh);
        #Bước 5. Thực thi câu lệnh
        $stmt->execute();
        #echo "Thêm sản phẩm thành công!";
        header("Location: list.php?info=addsuccess"); // Chuyển hướng về trang danh sách sản phẩm sau khi thêm thành công
        exit();
    }
    catch(PDOException $e){
        echo "Lỗi: " . $e->getMessage();
    }
    #Bước 6. Đóng kết nối
    $conn = null;
?>