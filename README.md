# PHPCoban

Dự án PHP cơ bản nhằm minh họa cách xây dựng trang web bán hàng/quản lý dữ liệu bằng PHP và MySQL.

## Mô tả

Project này là một ứng dụng PHP đơn giản, sử dụng:
- PHP thuần
- MySQL với PDO
- Layout/header/footer để tái sử dụng giao diện
- Cấu trúc thư mục theo module cơ bản

Dự án hiện tại mới bao gồm các thành phần cơ bản như:
- Trang chủ
- Kết nối database MySQL
- Khung layout chung cho giao diện
- Cấu trúc cho module sản phẩm và quản lý dữ liệu

## Cấu trúc thư mục

```text
phpcoban/
├── database/
│   ├── connect.php
│   └── products/
├── layout/
│   ├── header.php
│   └── footer.php
├── public/
│   └── image/
├── home.php
├── test.php
└── README.md
```

## Tính năng

- Kết nối tới MySQL bằng PDO
- Giao diện đa trang với layout tái sử dụng
- Cấu trúc module quản lý sản phẩm
- Dễ mở rộng cho các chức năng CRUD
- Có thể chạy trên môi trường PHP + Apache/Nginx

## Yêu cầu hệ thống

- PHP 7.4+ hoặc phiên bản mới hơn
- MySQL / MariaDB
- Web server: Apache hoặc Nginx
- Trình duyệt hiện đại

## Cài đặt và chạy

1. Clone repository:

```bash
git clone https://github.com/joiejoui13/phpcoban.git
cd phpcoban
```

2. Cấu hình database:

Mở file `database/connect.php` và chỉnh sửa thông tin kết nối:

```php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'quanlybanhang';
```

3. Tạo database MySQL nếu cần:

```sql
CREATE DATABASE quanlybanhang;
```

4. Chạy project:

Nếu bạn dùng PHP built-in server:

```bash
php -S localhost:8000
```

Sau đó truy cập:

```text
http://localhost:8000/home.php
```

## Lưu ý

- Project này là một phiên bản demo / học tập, phù hợp để nghiên cứu cách kết nối PHP với MySQL và xây dựng layout cơ bản.
- Một số file liên quan đến chức năng sản phẩm có thể đang ở trong các thư mục con hoặc đang được phát triển thêm.
- Bạn nên kiểm tra lại đường dẫn file trong `layout/header.php` nếu deploy lên môi trường khác.

## Ghi chú phát triển

Dự án hiện tại đang có cấu trúc đơn giản, dễ mở rộng sang các chức năng như:
- CRUD sản phẩm
- Quản lý khách hàng
- Quản lý đơn hàng
- Đăng nhập / đăng ký người dùng

## License

Dự án này hiện chưa khai báo license rõ ràng. Nếu bạn muốn, bạn có thể thêm `LICENSE` sau khi xác định giấy phép sử dụng phù hợp.
