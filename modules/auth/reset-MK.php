<h1>Reset</h1>


<?php

layouts('header');

$token = filter()['token'];

if(!empty($token)){
    $sql = oneRaw("SELECT id, fullname, email FROM users WHERE forgotToken = '$token'");

    if(!empty($sql)){
        $userId = $sql['id'];
        if(isPost()){
            $filterAll = filter();
            $errors = [];
            if(empty($filterAll['password'])){
                $errors["password"]['required'] = 'Mật khẩu bắt buộc phải nhập';
            }
            else{
                if(strlen($filterAll['password']) < 8 ){
                    $errors['password']['min'] = 'Mật khẩu phải lớn hơn 8 kí tự';
                }
            }
        
            if(empty($filterAll['password_confirm'])){
                $errors['password_confirm']['required'] = 'Mật khẩu nhập lại không được trống';
            }
            else{
                if($filterAll['password'] != $filterAll['password_confirm']){
                    $errors['password_confirm']['password-again'] = 'Mật khẩu nhập lại không đúng';
                }
            }
            if(empty($errors)){


                $password_hash = password_hash($filterAll['password'], PASSWORD_DEFAULT);
                $usdatePassword = [
                    'password' => $password_hash,
                    'forgotToken' => null,
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $updateStatus = update('users', $usdatePassword, "id = $userId");
                if($updateStatus){
                    setFlashdata('smg', 'Thay đổi mật khẩu thành công');
                    setFlashdata('smg_type', 'success');
                   //$smg = "Vui lòng kiểm tra dữ liệu";
                 
             
            
                   redirect('?module=auth&action=login');
                }else{
                    setFlashdata('smg', 'Lỗi hệ thống, vui lòng thử lại sau');
                    setFlashdata('smg_type', 'danger');
                }

            }
            else{
                setFlashdata('smg', 'Vui lòng kiểm tra dữ liệu');
                setFlashdata('smg_type', 'danger');
               //$smg = "Vui lòng kiểm tra dữ liệu";
               setFlashdata('errors', $errors);
         
        
               redirect('?module=auth&action=reset-MK&token='.$token);
            }
        
           

        }


        $smg = getFlashdata('smg');
        $smg_type = getFlashdata('smg_type');
      
        $errorsFlashdata = getFlashdata('errors');
    
      


        ?>
            <!-- Form đặt lại mật khẩu -->
                    
         <div class="row">
            <div class="col-5" style="margin: 50px auto;">
                <h2 class="text-center text-uppercase">Đặt lại mật khẩu</h2>

                <?php


                    if(!empty($smg)){
                        getSmg($smg, $smg_type);
                    }
                    
                
                
                ?>


                <form action="" method="post">
                

                    <div class="form-group mg-form">
                        <label for="">Mật khẩu</label>
                        <input type="text" class="form-control" name="password" id="" placeholder="Mật khẩu">
                        <?php 
                    
                        echo formErrors('password','<span class="error">','</span>', $errorsFlashdata);

                        ?>
                    </div>

                    <div class="form-group mg-form">
                        <label for="">Nhập lại mật khẩu</label>
                        <input type="text" class="form-control" name="password_confirm" id="" placeholder="Nhập lại mật khẩu">
                        <?php 
                    
                        echo formErrors('password_confirm','<span class="error">','</span>', $errorsFlashdata);

                        ?>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button type="submit" class="mg-btn btn btn-primary btn-block">Gửi</button>
                    <hr>
                    <p class="text-center"><a  href="?module=auth&action=login">Đăng nhập</a></p>


                </form>



            </div>
        </div>


        
        <?php

    }else{
        getSmg('Liên kết không tồn tại hoặc đã hết hạn');
    }




}else{
    getSmg('Liên kết không tồn tại hoặc đã hết hạn');
}


?>



<?php

layouts('footer');

?>