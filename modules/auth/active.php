<?php

// // Truy cập ko hợp lệ
// if(!defined('_CODE')){
//     die('Access denied...');  
// }

// require_once('templates/layout/header.php')

// Nhúng Header và Footer
// layouts('header', $data);

layouts('header-login');


$activeToken = filter()['token'];

if(!empty($activeToken)){

    // Kiểm tra token với database
    $tokenQuery = oneRaw("SELECT id FROM users WHERE activeToken = '$activeToken'");

    if(!empty($tokenQuery)){

        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];
            $updaStatus  = update('users', $dataUpdate, "id=$userId");
            if($updaStatus){
                setFlashdata('smg', 'Kích hoạt tái khoản thành công, bạn có thể đăng nhập ngay bây giờ');
                setFlashdata('smg_type', 'success');
            }else{
                setFlashdata('smg', 'Kích hoạt tái khoản không thành công, vui lòng liên hệ quản trị viên');
                setFlashdata('smg_type', 'danger');
            }
            redirect("?module=auth&action=login");

    }else{
        getSmg('Liên kết không tồn tại', 'danger');
    }
    


}










?>

<h1>Acctive</h1>


<?php

layouts('footer-login');



?>