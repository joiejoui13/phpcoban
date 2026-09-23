<?php
    #Thực hiện xóa sản phẩm khỏi bảng SanPham
    #Bước 0. Lấy mã sản phẩm từ URL
    $maSP = $_GET['MaSP']; // Khớp với link del.php?MaSP=... trong list.php
    #Bước 1. Kết nối CSDL
    include_once("../connect.php");
    try{
        # Lấy tên ảnh của sản phẩm trước khi xóa để còn xóa file ảnh
        $stmtAnh = $conn->prepare("SELECT HinhAnh FROM SanPham WHERE MaSP = :MaSP");
        $stmtAnh->bindParam(':MaSP', $maSP);
        $stmtAnh->execute();
        $hinhAnh = $stmtAnh->fetchColumn();

        #Bước 2. Viết câu lệnh truy vấn
        $sql = "DELETE FROM SanPham WHERE MaSP = :MaSP";
        #Bước 3. Chuẩn bị câu lệnh
        $stmt = $conn->prepare($sql);
        #Bước 4. Gán giá trị cho tham số
        $stmt->bindParam(':MaSP', $maSP);
        #Bước 5. Thực thi câu lệnh
        $stmt->execute();

        # Xóa dòng trong CSDL thành công thì xóa luôn file ảnh trong thư mục
        if (!empty($hinhAnh)) {
            $duongDanAnh = '../../public/image/' . basename($hinhAnh);
            if (file_exists($duongDanAnh)) {
                unlink($duongDanAnh);
            }
        }
        #echo "Xóa sản phẩm thành công!";
        header("Location: list.php?info=deletesuccess"); // Chuyển hướng về trang danh sách sản phẩm sau khi xóa thành công
        exit();
    }
    catch(PDOException $e){
        echo "Lỗi: " . $e->getMessage();
    }
    #Bước 6. Đóng kết nối
    $conn = null;
?>