<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
</head>
<body>
    <?php
    #truy cập CSDL lấy thông tin sản phẩm cần sửa dựa vào mã sản phẩm được truyền từ list.php
    #Bước 0. Lấy mã sản phẩm từ URL
    $maSP = $_GET['MaSP'];
    #Bước 1. Kết nối CSDL
    include_once("../connect.php");
    try{
        #Bước 2. Viết câu lệnh truy vấn
        $sql = "SELECT * FROM SanPham WHERE MaSP = :MaSP";
        #Bước 3. Chuẩn bị câu lệnh
        $stmt = $conn->prepare($sql);
        #Bước 4. Gán giá trị cho tham số
        $stmt->bindParam(':MaSP', $maSP);
        #Bước 5. Thực thi câu lệnh
        $stmt->execute();
        #Bước 6. Lấy kết quả truy vấn
        $sanPham = $stmt->fetch(PDO::FETCH_ASSOC);

        # Lấy danh sách loại sản phẩm để đổ vào ô chọn
        $dsLoai = $conn->query("SELECT MaLoaiSP, TenLoaiSP FROM LoaiSP")->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo "Lỗi: " . $e->getMessage();
    }

    # Không tìm thấy sản phẩm thì dừng lại
    if (!$sanPham) {
        die("Không tìm thấy sản phẩm. <a href='list.php'>Quay lại</a>");
    }
    ?>
    <h1>Sửa sản phẩm</h1>
    <form action="save_edit.php" method="post" enctype="multipart/form-data">
        <label for="tenSP">Tên sản phẩm:</label>
        <input type="text" id="tenSP" name="TenSP" required maxlength="100"
        value="<?php echo htmlspecialchars($sanPham['TenSP']); ?>"><br><br>

        <label for="moTa">Mô tả:</label>
        <textarea id="moTa" name="MoTa" maxlength="500"><?php echo htmlspecialchars($sanPham['MoTa']); ?></textarea><br><br>

        <label for="soLuong">Số lượng:</label>
        <input type="number" id="soLuong" name="SoLuong" required min="0"
        value="<?php echo $sanPham['SoLuong']; ?>"><br><br>

        <label for="donGia">Đơn giá:</label>
        <input type="number" step="0.01" id="donGia" name="DonGia" required min="0"
        value="<?php echo $sanPham['DonGia']; ?>"><br><br>

        <label for="maLoaiSP">Loại sản phẩm:</label>
        <select id="maLoaiSP" name="MaLoaiSP" required>
            <option value="">-- Chọn loại sản phẩm --</option>
            <?php foreach ($dsLoai as $loai) { ?>
                <option value="<?php echo $loai['MaLoaiSP']; ?>"
                    <?php if ($loai['MaLoaiSP'] == $sanPham['MaLoaiSP']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($loai['TenLoaiSP']); ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label>Hình ảnh hiện tại:</label><br>
        <?php if (!empty($sanPham['HinhAnh'])) { ?>
            <img src="../../public/image/<?php echo htmlspecialchars($sanPham['HinhAnh']); ?>" width="120"
            alt="<?php echo htmlspecialchars($sanPham['MoTaHinhAnh']); ?>">
        <?php } else { ?>
            (Chưa có ảnh)
        <?php } ?>
        <br><br>

        <label for="hinhAnh">Chọn ảnh mới (bỏ trống nếu giữ ảnh cũ):</label>
        <input type="file" id="hinhAnh" name="HinhAnh" accept="image/*"><br><br>

        <label for="moTaHinhAnh">Mô tả hình ảnh:</label>
        <input type="text" id="moTaHinhAnh" name="MoTaHinhAnh" maxlength="255"
        value="<?php echo htmlspecialchars($sanPham['MoTaHinhAnh']); ?>"><br><br>

        <!--Lưu ý truyền mã sản phẩm và tên ảnh cũ qua input ẩn để khi submit form, save_edit.php biết sửa sản phẩm nào và giữ ảnh cũ nếu không chọn ảnh mới-->
        <input type="hidden" name="MaSP" value="<?php echo $sanPham['MaSP']; ?>">
        <input type="hidden" name="HinhAnhCu" value="<?php echo htmlspecialchars($sanPham['HinhAnh']); ?>">
        <input type="submit" value="Sửa sản phẩm">
        <a href="list.php">Quay lại</a>
    </form>
</body>
</html>