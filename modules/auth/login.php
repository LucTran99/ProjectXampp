<?php


$data = [
    'pageTitle' => 'Đăng nhập tài khoản'
];
// Cách 2
layouts('header-login', $data);


// Cách 1
// require_once (WEB_PATH_TEMPLATES . '/layout/header.php');


// $isget = filter();
// echo '<pre>';
// print_r($isget);
// echo '</pre>';



$passwordMd5 = '123';

// Hai hàm mã hóa này khi load lại nó vẫn giữ nguyên. Nên trong trường hợp sẽ bị lộ mật khẩu
echo md5($passwordMd5);  
echo '<br>';
echo sha1($passwordMd5);

echo '<br>';

// Nó sẽ dổi lại chuỗi mã hóa khác khi load lại web
$password_hash = password_hash($passwordMd5, PASSWORD_DEFAULT);

echo $password_hash;


echo '<br>';


$password_verify = password_verify('123', $password_hash);

echo  $password_verify;


if(isLogin()){
    redirect('?module=home&action=dashboard');
}


if(isPost()){
  
    $fillterAll = filter();
    if(!empty(trim($fillterAll['email'])) && !empty(trim($fillterAll['password']))){
        $email = $fillterAll['email'];
        $password = $fillterAll['password'];

        $sql = oneRaw("SELECT password, id FROM users WHERE email = '$email'");
        
        if(!empty($sql)){
            $password_hash = $sql['password'];
            $userId = $sql['id'];
            if(password_verify($password, $password_hash)){
            
                // Tạo Token Login. Kiểm tra xem người dùng có hoạt động không
                $tokenLogin = sha1(uniqid().time());

                    // Insert vào Bảng loginToken
                    $dataInsertToken = [
                        'user_id' => $userId,
                        'token' => $tokenLogin,
                        'create_at' => date('Y-m-d H:i:s')
                    ];
                     
                    $sqlInsert = insert('logintoken', $dataInsertToken);
                  


                    if($sqlInsert){

                            // Lưu cái tokenlogin vào session
                            setSession('logintoken', $tokenLogin);

                        
                        redirect('?module=home&action=dashboard');
                    }else{
                        setFlashdata('smg', 'Không thể đăng nhập, vui lòng thử lại sao');
                        setFlashdata('smg_type', 'danger');
                    }



            }else{
                setFlashdata('smg', 'Mật khẩu không chính xác');
                setFlashdata('smg_type', 'danger');
             
            }
        }else{
            setFlashdata('smg', 'Email không tồn tại');
            setFlashdata('smg_type', 'danger'); 
        }


    }else{
        setFlashdata('smg', 'Vui lòng nhập email và mật khẩu');
        setFlashdata('smg_type', 'danger');
 
    }

    redirect('?module=auth&action=login');

  
}

$smg = getFlashdata('smg');
$smg_type = getFlashdata('smg_type');














?>




<!-- XÂY DỰNG GIAO DIỆN LOGIN -->

<div class="row">
    <div class="col-5" style="margin: 50px auto;">
      <h2 class="text-center text-uppercase login-user">Đăng nhập quản lí người dùng</h2>
      <?php 
        echo getSmg($smg, $smg_type);
      
      ?>
        <form action="" method="post">

            <div class="form-group mg-form">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" id="" placeholder="Địa chỉ Email">
            </div>

            <div class="form-group mg-form">
               <label for="">Password</label>
                <input type="password" class="form-control" name="password" id="" placeholder="Mật khẩu">
            </div>

            <button type="submit" class="mg-btn btn btn-primary btn-block">Đăng nhập</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=forgot">Quên mật khẩu</a></p>
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