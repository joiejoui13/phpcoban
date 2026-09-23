# PHPCoban

> Dự án PHP cơ bản phục vụ mục đích học tập, thực hành và xây dựng portfolio cá nhân.

PHPCoban là một project nhỏ giúp người mới làm quen với PHP hiểu được cách tổ chức một ứng dụng web đơn giản, cách tách giao diện thành các thành phần dùng lại nhiều lần và cách kết nối PHP với cơ sở dữ liệu MySQL.

Repository phù hợp để thực hành các kiến thức nền tảng trước khi chuyển sang các framework như Laravel hoặc Symfony.

## Mục tiêu học tập

Sau khi tìm hiểu project, bạn có thể làm quen với:

- Cú pháp PHP cơ bản.
- Cách tạo một trang PHP và chạy trên máy local.
- Cách dùng `include_once` để tái sử dụng các phần giao diện.
- Cách tổ chức code theo thư mục.
- Cách kết nối PHP với MySQL bằng PDO.
- Cách xử lý lỗi kết nối database.
- Nền tảng để phát triển các chức năng CRUD.
- Cách xây dựng một project nhỏ để đưa vào portfolio.

## Tổng quan hoạt động

Luồng hoạt động cơ bản của project:

1. Người dùng truy cập vào một file PHP, chẳng hạn `home.php`.
2. `home.php` nạp phần giao diện chung từ `layout/header.php`.
3. Nội dung riêng của trang được hiển thị.
4. `layout/footer.php` được nạp để hoàn thành giao diện.
5. Khi cần làm việc với dữ liệu, các file trong `database/` sẽ đảm nhiệm việc kết nối và xử lý database.

```text
home.php
   │
   ├── include layout/header.php
   ├── hiển thị nội dung trang
   └── include layout/footer.php

database/connect.php
   └── kết nối PHP với MySQL bằng PDO
```

## Cấu trúc project

```text
phpcoban/
├── database/
│   ├── connect.php       # Cấu hình và tạo kết nối MySQL
│   └── products/         # Khu vực phát triển chức năng sản phẩm
├── layout/
│   ├── header.php        # Thành phần giao diện phía trên/trình đơn
│   └── footer.php        # Phần cuối trang
├── public/
│   └── image/            # Hình ảnh và tài nguyên công khai
├── home.php              # Trang chủ
├── test.php              # File kiểm tra PHP có hoạt động hay không
└── README.md             # Tài liệu hướng dẫn project
```

## Các file quan trọng

### `home.php`

Đây là trang chủ đơn giản của project. File sử dụng `include_once` để nạp phần header và footer thay vì viết lại toàn bộ HTML ở từng trang.

### `layout/header.php`

Chứa các liên kết điều hướng dùng chung, ví dụ như đăng nhập, đăng ký, sản phẩm và liên hệ.

### `layout/footer.php`

Chứa phần footer của trang. Năm hiện tại được lấy tự động bằng PHP:

```php
<?= date('Y') ?>
```

### `database/connect.php`

Tạo kết nối đến MySQL bằng PDO và bật chế độ báo lỗi bằng exception. Mặc định project sử dụng database có tên `quanlybanhang`.

> Không nên đưa mật khẩu database thật hoặc thông tin nhạy cảm lên GitHub. Khi triển khai thực tế, nên sử dụng biến môi trường hoặc file cấu hình riêng.

### `test.php`

File kiểm tra tối giản để xác nhận PHP đang được chạy đúng trên môi trường local.

## Yêu cầu môi trường

- PHP 7.4 trở lên.
- MySQL hoặc MariaDB.
- Apache, Nginx hoặc PHP Built-in Web Server.
- Git, nếu muốn clone project.
- Trình duyệt web.

## Cài đặt và chạy project

### Cách 1: Clone bằng Git

```bash
git clone https://github.com/joiejoui13/phpcoban.git
cd phpcoban
```

### Cách 2: Tải source code

Bạn có thể chọn **Code → Download ZIP** trên GitHub, sau đó giải nén project vào thư mục web server, chẳng hạn:

- XAMPP: `htdocs/phpcoban`
- Laragon: `www/phpcoban`

### Tạo database

Mở MySQL hoặc phpMyAdmin và tạo database:

```sql
CREATE DATABASE quanlybanhang
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

### Cấu hình kết nối

Mở file `database/connect.php` và kiểm tra các thông tin sau:

```php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'quanlybanhang';
```

Hãy thay đổi `$user`, `$password` và `$dbname` nếu môi trường MySQL của bạn sử dụng thông tin khác.

### Chạy bằng PHP Built-in Web Server

Từ thư mục gốc của project, chạy:

```bash
php -S localhost:8000
```

Mở các địa chỉ sau trên trình duyệt:

```text
http://localhost:8000/home.php
http://localhost:8000/test.php
```

Nếu dùng XAMPP hoặc Laragon, hãy khởi động Apache và truy cập URL tương ứng, ví dụ:

```text
http://localhost/phpcoban/home.php
```

## Dành cho người mới học

Bạn có thể học project theo thứ tự sau:

1. Chạy `test.php` để kiểm tra PHP.
2. Mở `home.php` và xem cách sử dụng `include_once`.
3. Đọc `layout/header.php` và `layout/footer.php` để hiểu layout dùng chung.
4. Đọc `database/connect.php` để hiểu kết nối PDO.
5. Tạo một trang mới, ví dụ `about.php`, rồi tái sử dụng header và footer.
6. Thử tạo chức năng thêm, sửa, xóa và xem danh sách sản phẩm.
7. Bổ sung kiểm tra dữ liệu đầu vào và thông báo lỗi thân thiện.

Ví dụ tạo một trang mới:

```php
<?php include_once 'layout/header.php'; ?>

<h1>Giới thiệu project</h1>
<p>Đây là trang được tạo để thực hành PHP.</p>

<?php include_once 'layout/footer.php'; ?>
```

## Hướng phát triển bài tập

Project có thể được mở rộng thành một ứng dụng quản lý bán hàng nhỏ với các chức năng:

- Hiển thị danh sách sản phẩm.
- Thêm, sửa và xóa sản phẩm.
- Tìm kiếm sản phẩm.
- Phân loại sản phẩm.
- Đăng ký và đăng nhập người dùng.
- Quản lý khách hàng.
- Quản lý đơn hàng.
- Phân quyền người dùng.
- Validate dữ liệu bằng PHP và JavaScript.
- Bổ sung CSS responsive.

## Gợi ý cải thiện khi dùng làm portfolio

Nếu sử dụng project này trong portfolio, bạn có thể bổ sung:

- Ảnh chụp màn hình giao diện.
- Sơ đồ database.
- Danh sách chức năng đã hoàn thành.
- Demo trực tuyến hoặc video giới thiệu.
- Thông tin công nghệ sử dụng.
- Các vấn đề đã gặp và cách giải quyết.
- Hướng dẫn cài đặt đầy đủ hơn.
- File `.env.example` và cơ chế bảo vệ thông tin cấu hình.

## Công nghệ sử dụng

- **PHP**: xử lý logic phía server.
- **MySQL/MariaDB**: lưu trữ dữ liệu.
- **PDO**: kết nối và làm việc với database.
- **HTML/CSS**: xây dựng giao diện.
- **JavaScript**: có thể sử dụng để kiểm tra dữ liệu và tạo tương tác.

## Lưu ý bảo mật

Project được xây dựng cho mục đích học tập. Khi phát triển thành ứng dụng thực tế, cần cải thiện thêm:

- Không hard-code thông tin database trong source code.
- Sử dụng prepared statements cho các câu truy vấn có dữ liệu người dùng.
- Validate và escape dữ liệu đầu vào.
- Không hiển thị thông báo lỗi database trực tiếp cho người dùng.
- Hash mật khẩu bằng `password_hash()`.
- Bổ sung cơ chế chống CSRF cho form.
- Không commit file chứa mật khẩu hoặc khóa bí mật.

## Trạng thái project

Project đang ở giai đoạn học tập và có thể tiếp tục mở rộng. Một số module hoặc đường dẫn trong source code có thể đang được phát triển theo từng bài thực hành.

## License

Repository hiện chưa khai báo license cụ thể. Nếu chia sẻ hoặc sử dụng project cho mục đích khác, hãy bổ sung file `LICENSE` với loại giấy phép phù hợp.
