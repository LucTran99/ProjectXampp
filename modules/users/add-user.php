


<?php



// senMail('luctv24689@gmail.com', 'Tiêu đề', 'Nội dung');



$dataLayout = [
    'pageTitle' => 'Đăng kí tài khoản'
];


// $data = [
//     'fullname' => 'Thành Nam',
//     'email' => 'thanhnam@gmail.com',
//     'phone' => '0934424322'
// ];

// $insertt = getRaw('SELECT * FROM users');
// echo '<pre>';
// print_r($insertt);
// echo '</pre>';

if(isPost()){

  
    $filterAll = filter();
    $errors = [];

    // Bắt lỗi từng ô input
    if(empty($filterAll['fullname'])){
       $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
    }else{
        if(strlen($filterAll['fullname']) < 5){
            $errors['fullname']['minLen'] = 'Họ tên phải dài trên 5 kí tự';
        }
    }

    if(empty($filterAll['email'])){
        $errors['email']['required'] = 'Email bắt buộc phải nhập';
    }else{
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        if(getRows($sql) > 0){ // Lớn hơn 0 nghĩa là đã tồn tại email đó rồi
          $errors['email']['uique'] = 'Email đã tồn tại';
        }
    }

    if(empty($filterAll['phone'])){
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
    }else{
        if(!isPhone($filterAll['phone'])){
            $errors['phone']['isPhone'] = 'Đây không phải là số điện thoại';
        }
    }
    

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
        $active = sha1(uniqid().time());
        
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email'  => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'status' => $filterAll['status'],
            'create_at' => date('Y-m-d H:i:s')
        ];


        $insertData = insert('users', $dataInsert);

        if($insertData){
            
 
                setFlashdata('smg', 'Thêm người dùng thành công');
                setFlashdata('smg_type', 'success');
           
                redirect('?module=users&action=list-user');

        }else{
            setFlashdata('smg', 'Hệ thống đang lỗi, vui lòng thử ại sau');
            setFlashdata('smg_type', 'danger');
        }
        redirect('?module=users&action=add-user');


    }
    else{
        setFlashdata('smg', 'Vui lòng kiểm tra dữ liệu');
        setFlashdata('smg_type', 'danger');
       //$smg = "Vui lòng kiểm tra dữ liệu";
       setFlashdata('errors', $errors);

       // Lưu dữ liệu cũ. Khi người dùng load lại vẫn còn giữ dữ liệu cũ
       setFlashdata('old_data', $filterAll);

       redirect('?module=users&action=add-user');
    }

    // echo '<pre>';
    // print_r($errors);
    // echo '</pre>';


}

  $smg = getFlashdata('smg');
  $smg_type = getFlashdata('smg_type');


  $errorsFlashdata = getFlashdata('errors');
  $oldData = getFlashdata('old_data');


  
//     echo '<pre>';
//     print_r($errorsFlashdata);
//     echo '</pre>';

//    echo '<br>';

//     echo '<pre>';
//     print_r($oldData);
//     echo '</pre>';


layouts('header-login', $dataLayout);

?>

<div class="container">
    <div class="row" style="margin: 50px auto;">
           <h2 class="text-center text-uppercase">Thêm người dùng </h2>

           <?php


               if(!empty($smg)){
                   getSmg($smg, $smg_type);
               }
              
           
           
           ?>


        <form action="" method="post">
            <div class="row">
                <div class="col">
                <div class="form-group  mg-form">
                <label for="">Họ tên</label>
                <input type="fullname" class="form-control" name="fullname" id="" placeholder="Họ tên"
                
                 value="<?php

                   // Lưu giá trị cũ của from
                  //   echo (!empty($oldData['fullname']) ? $oldData['fullname'] : null);
                   echo oldValues('fullname', $oldData);
                
                ?>">

                <?php 

                  // echo (!empty($errorsFlashdata['fullname']) ? '<span class="error">' .reset($errorsFlashdata['fullname']). '</pan>': null);
                   echo formErrors('fullname','<span class="error">','</span>', $errorsFlashdata);

                ?>
            </div>


            <div class="form-group mg-form">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" id="" placeholder="Email"
                
                value="<?php 

                    // Lưu lại dữ liệu cũ
                    echo oldValues('email', $oldData);
                
                ?>">

                <?php 

                // Thông báo lỗi dưới form
                echo formErrors('email','<span class="error">','</span>', $errorsFlashdata);

                ?>
            </div>


            <div class="form-group mg-form">
                <label for="">Số điện thoại</label>
                <input type="number" class="form-control" name="phone" id="" placeholder="Số điện thoại"
                
                value="<?php

                   // Lưu lại dữ liệu cũ
                   echo oldValues('phone', $oldData);
                
                ?>">

                <?php

                   // Thông báo lỗi dưới form
                echo formErrors('phone','<span class="error">','</span>', $errorsFlashdata);

                ?>


            </div>

                </div>
                <div class="col">
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

            <div class="form-group">
                <label for="">Trạng thái</label>
                <select name="status" id="" class="form-control">
                    <option value="0">Chưa kích hoạt</option>
                    <option value="1">Đã kích hoạt</option>
                </select>


            </div>
                </div>
            </div>

        

         



            <button type="submit" class="mg-btn btn btn-primary btn-block">Thêm người dùng </button>
            <a href="?module=users&action=list-user" class="mg-btn btn btn-success btn-block">Quay lại</a>

            <hr>
          
        </form>



    </div>
</div>


<?php

layouts('footer-login');
?>