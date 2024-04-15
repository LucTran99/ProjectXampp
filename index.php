

<?php

// Trước khi chạy project phải khởi tạo session
session_start();  // Hàm khởi tạo session 




require_once('config.php');
// require_once('header.php');
require_once('./includes/connect.php');



// Thư viện phpMailer (Phải để trước file function.php)
require_once('./includes/phpmailer/Exception.php');
require_once('./includes/phpmailer/PHPMailer.php');
require_once('./includes/phpmailer/SMTP.php');



require_once('./includes/function.php');
// echo _WEB_HOST;
require_once('./includes/database.php');
require_once('./includes/sessison.php');








// Gán hai hằng số đó vào 2 biến
$module = _MODULE;
$action = _ACTION;

// ví dụ:
// $seeeion = setSession('BoyKa', 'Giá trị của Session 2');
// var_dump( $seeeion);

//  echo removeSession('BoyKa');
//  echo getSession('BoyKa');
// Nó sẽ in ra là: string(30) "Giá trị của Session"


echo getFlashdata('Boyka');

// Kiểm tra xem module trên thanh địa chỉ có tồn tại ko

if(!empty($_GET['module'])){
 

    if(is_string($_GET['module'])){  // Nếu là dạng chuỗi 
        $module = trim($_GET['module']);


    }
}


// Kiểm tra xem action trên thanh địa chỉ có tồn tại ko

if(!empty($_GET['action'])){
 

    if(is_string($_GET['action'])){  // Nếu là dạng chuỗi 
        $action = trim($_GET['action']);


    }
}




// Ghép lại với nhau thành một cái path
// Để điều hướng vào path đó


// path này sẽ là đường dẫn điều hướng đến file mà ta muốn đến
   $path = 'modules/'.$module. '/'. $action .'.php'; 

if(file_exists($path)){   // Nếu tồn tại file giống trong cây thư mục
    require_once($path);
}
else{
    require_once('modules/errors/404.php');
}

