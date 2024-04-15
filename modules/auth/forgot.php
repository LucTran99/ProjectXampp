
<!-- 
// Tạo forgot token 
// Gửi email chứa link đến trang reset
// Xác thực token, hiện ra form resetMK
// Submit reset password -> xử lí update lại password
 -->

<?php


$data = [
    'pageTitle' => 'Quên mật khẩu'
];
// Cách 2
layouts('header-login', $data);


// Cách 1
// require_once (WEB_PATH_TEMPLATES . '/layout/header.php');


// $isget = filter();
// echo '<pre>';
// print_r($isget);
// echo '</pre>';




if(isLogin()){
    redirect('?module=home&action=dashboard');
}


if(isPost()){
  $filterAll = filter();
  if(!empty($filterAll['email'])){
    $email = $filterAll['email'];
    $sql = oneRaw("SELECT id FROM users WHERE email = '$email'");

    if(!empty($sql)){
        $userID = $sql['id'];

        // Tạo forgotToken
        $forgotToken = sha1(uniqid().time());
        $dataUpdate = [
            'forgotToken' => $forgotToken
        ];
       $updateStatus =  update('users', $dataUpdate, "id= $userID");
       if($updateStatus){

            // Tạo link gửi Email
            $linkReset = _WEB_HOST. '?module=auth&action=reset-MK&token='.$forgotToken;

            // Gửi mail cho người dùng
            $subject = 'Yêu cầu khôi phục mật khẩu';
            $content = 'Chào bạn .<br>';
            $content .= 'Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn. 
            Vui lòng click vào link sau để đổi lại mật khẩu: <br>';
            $content .= $linkReset . '<br>';
            $content .= 'Trân trọng cảm ơn';

           $sendMail =  senMail($email, $subject, $content);
        if($sendMail){
            setFlashdata('smg','Vui lòng kiểm tra email để đặt lại mật khẩu');
            setFlashdata('smg_type', 'success');
        }else{
            setFlashdata('smg','Gửi Mail thất bại, vui lòng thử lại sau');
            setFlashdata('smg_type', 'danger');
        }


       }
       else{
        setFlashdata('smg','Lỗi hệ thống vui lòng thử lại sau');
        setFlashdata('smg_type', 'danger');
       }

    }else{
        setFlashdata('smg','Địa chỉ Email không tồn tại trong hệ thống');
        setFlashdata('smg_type', 'danger');
    }

  }else{
    setFlashdata('smg','Vui lòng nhập địa chỉ Email');
    setFlashdata('smg_type', 'danger');
  }
  //redirect('?module=auth&action=forgot');

}

$smg = getFlashdata('smg');
$smg_type = getFlashdata('smg_type');














?>




<!-- XÂY DỰNG GIAO DIỆN LOGIN -->

<div class="row">
    <div class="col-5" style="margin: 50px auto;">
      <h2 class="text-center text-uppercase login-user">Quên mật khẩu</h2>
      <?php 
        echo getSmg($smg, $smg_type);
      
      ?>
        <form action="" method="post">

            <div class="form-group mg-form">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" id="" placeholder="Địa chỉ Email">
            </div>


            <button type="submit" class="mg-btn btn btn-primary btn-block">Gửi</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Đăng kí</a></p>
        </form>
    </div>
</div>









<?php
// Cách 2
  layouts('footer-login');


// Cách 1
// require_once (WEB_PATH_TEMPLATES . '/layout/footer.php');
?>