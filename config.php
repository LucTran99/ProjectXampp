
<!-- Config -->
<?php   

// Các hằng số


const _MODULE = 'home';  // Gán mặc định là home
const _ACTION  = 'dashboard'; // Gán mặc định là dashboard


// Chặn người dùng truy cập một cách ko hợp lệ
const _CODE = true;
// Truy cập hợp lệ: http://localhost:90/Hoc-PHP/QuanLiNguoiDung/modules/auth/forgot.php

// Truy cập ko hợp lệ: http://localhost:90/Hoc-PHP/QuanLiNguoiDung/?module=users&action=list-Users





// Thiết lập host

                                                     // Tên project: Hoc-PHP,  tên thư mục: QuanLiNguoiDung
define('_WEB_HOST', 'http://'. $_SERVER['HTTP_HOST']. '/Hoc-PHP/QuanLiNguoiDung');
define('_WEB_HOST_TEMPLATES', _WEB_HOST . '/templates');





// Thiết lập Path
define('WEB_PATH', __DIR__);  // Đây là WEB_Path: C:\xampp\htdocs\Hoc-PHP\manager_users

define('WEB_PATH_TEMPLATES', WEB_PATH .'/templates');  


// Đây là: WEB_PATH_TEMPLATES
// xampp\htdocs\Hoc-PHP\QuanLiNguoiDung/templates/layout/header.php






// Thông tin kết nối csdl

const _HOST = '127.0.0.1:3366';
const _DB = 'sanpham123';
const _USER = 'root';
const _PASS = '';



?>
