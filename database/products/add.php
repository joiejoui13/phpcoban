<?php
    # Lấy danh sách loại sản phẩm để đổ vào ô chọn
    include_once("../connect.php");
    $stmt = $conn->query("SELECT MaLoaiSP, TenLoaiSP FROM LoaiSP");
    $dsLoai = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
?>
<!DOCTYPE html>

<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Thêm sản phẩm</title>

</head>

<body>

<h2>THÊM SẢN PHẨM</h2>

<form
    action="save_add.php"
    method="POST"
    enctype="multipart/form-data"
    onsubmit="return kiemTraDuLieu();"
>

    <label>Tên sản phẩm:</label>
    <input type="text" id="tenSP" name="TenSP">
    <br><br>

    <label>Mô tả:</label>
    <input type="text" id="moTa" name="MoTa">
    <br><br>

    <label>Số lượng:</label>
    <input type="number" id="soLuong" name="SoLuong" value="0">
    <br><br>

    <label>Đơn giá:</label>
    <input type="number" step="0.01" id="donGia" name="DonGia">
    <br><br>

    <label>Loại sản phẩm:</label>
    <select id="maLoaiSP" name="MaLoaiSP">
        <option value="">-- Chọn loại sản phẩm --</option>
        <?php foreach ($dsLoai as $loai) { ?>
            <option value="<?= $loai['MaLoaiSP'] ?>">
                <?= htmlspecialchars($loai['TenLoaiSP']) ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    <label>Hình ảnh:</label>
    <input type="file" id="hinhAnh" name="HinhAnh" accept="image/*">
    <br><br>

    <label>Mô tả hình ảnh:</label>
    <input type="text" id="moTaHinhAnh" name="MoTaHinhAnh">
    <br><br>

    <button type="submit">
        Thêm
    </button>

    <a href="list.php">
        Quay lại
    </a>

</form>


<script>

// KIỂM TRA DỮ LIỆU TRƯỚC KHI THÊM

function kiemTraDuLieu() {

    let tenSP = document.getElementById("tenSP").value.trim();
    let moTa = document.getElementById("moTa").value.trim();
    let soLuong = document.getElementById("soLuong").value.trim();
    let donGia = document.getElementById("donGia").value.trim();
    let maLoaiSP = document.getElementById("maLoaiSP").value;
    let file = document.getElementById("hinhAnh").files[0];
    let moTaHinhAnh = document.getElementById("moTaHinhAnh").value.trim();


    if (tenSP == "") {

        alert("Vui lòng nhập tên sản phẩm!");

        document.getElementById("tenSP").focus();

        return false;
    }


    if (tenSP.length > 100) {

        alert("Tên sản phẩm không được vượt quá 100 ký tự!");

        document.getElementById("tenSP").focus();

        return false;
    }


    if (moTa.length > 500) {

        alert("Mô tả không được vượt quá 500 ký tự!");

        document.getElementById("moTa").focus();

        return false;
    }


    if (soLuong == "" || isNaN(soLuong) || Number(soLuong) < 0) {

        alert("Số lượng phải là số không âm!");

        document.getElementById("soLuong").focus();

        return false;
    }


    if (donGia == "" || isNaN(donGia) || Number(donGia) <= 0) {

        alert("Đơn giá phải là số lớn hơn 0!");

        document.getElementById("donGia").focus();

        return false;
    }


    if (maLoaiSP == "") {

        alert("Vui lòng chọn loại sản phẩm!");

        document.getElementById("maLoaiSP").focus();

        return false;
    }


    if (file && file.size > 2 * 1024 * 1024) {

        alert("Kích thước ảnh không được vượt quá 2MB!");

        return false;
    }


    if (moTaHinhAnh.length > 255) {

        alert("Mô tả hình ảnh không được vượt quá 255 ký tự!");

        document.getElementById("moTaHinhAnh").focus();

        return false;
    }


    return true;

}

</script>

</body>

</html>