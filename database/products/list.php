<?php
    #hiển thị toàn bộ sản phẩm có trong bảng SanPham
    #Bước 1. Kết nối CSDL
    include_once("../connect.php");
    #Thông tin phân trang
    $limit = 2; // Số lượng sản phẩm hiển thị trên mỗi trang
    $numberOfPages = 0; // Tổng số trang
    $sql_count = "SELECT COUNT(MaSP) AS total FROM SanPham";
    $stmt_count = $conn->query($sql_count);
    $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $row_count['total']; // Tổng số sản phẩm
    $numberOfPages = ceil($totalRecords / $limit); // Tính tổng số trang
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại, mặc định là 1
    if ($currentPage < 1) $currentPage = 1;
    $offset = ($currentPage - 1) * $limit; // Vị trí bắt đầu
    #Bước 2. Viết câu lệnh truy vấn
    $sql = "SELECT * FROM SanPham LIMIT :limit OFFSET :offset";
    #Bước 3. Thực thi câu lệnh truy vấn với PDO
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $dsSanPham = $stmt->fetchAll(PDO::FETCH_ASSOC);
    #Bước 5. Hiển thị dữ liệu ra màn hình
    if (isset($_GET['info'])) {
        if ($_GET['info'] == 'addsuccess') {
            echo "<p style='color: green;'>Thêm sản phẩm thành công!</p>";
        } elseif ($_GET['info'] == 'updatesuccess') {
            echo "<p style='color: green;'>Sửa sản phẩm thành công!</p>";
        } elseif ($_GET['info'] == 'deletesuccess') {
            echo "<p style='color: green;'>Xóa sản phẩm thành công!</p>";
        }
    }
    echo "<h1>Danh sách sản phẩm</h1>";
    echo "<a href='add.php'>Thêm sản phẩm</a><br><br>";
    #hiển thị danh sách sản phẩm dạng bảng HTML
    echo "<table border='1'>";
    echo "<tr><th>Mã SP</th><th>Tên SP</th><th>Mô tả</th><th>Số lượng</th><th>Đơn giá</th><th>Mã loại</th><th>Hình ảnh</th><th>Thao tác</th></tr>";
    foreach ($dsSanPham as $sp) {
        echo "<tr>";
        echo "<td>" . $sp['MaSP'] . "</td>";
        echo "<td>" . htmlspecialchars($sp['TenSP']) . "</td>";
        echo "<td>" . htmlspecialchars($sp['MoTa']) . "</td>";
        echo "<td>" . $sp['SoLuong'] . "</td>";
        echo "<td>" . $sp['DonGia'] . "</td>";
        echo "<td>" . $sp['MaLoaiSP'] . "</td>";
        echo "<td>";
        if (!empty($sp['HinhAnh'])) {
            echo "<img src='../../public/image/" . htmlspecialchars($sp['HinhAnh']) . "' width='80' alt='" . htmlspecialchars($sp['MoTaHinhAnh']) . "'>";
        }
        echo "</td>";
        echo "<td>
                <a href='edit.php?MaSP=" . $sp['MaSP'] . "'>Sửa</a> | 
                <a href='del.php?MaSP=" . $sp['MaSP'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');\">Xóa</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
    #hiển thị phân trang
    echo "<div>";
    for ($page = 1; $page <= $numberOfPages; $page++) {
        echo "<a href='list.php?page=" . $page . "'>" . $page . "</a> ";
    }
    echo "</div>";
    #Bước 6. Đóng kết nối
    $conn = null;
?>