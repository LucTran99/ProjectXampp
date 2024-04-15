

<?php

$dataLayout = [
    'pageTitle' => 'Danh sách  người dùng'
];


layouts('header', $dataLayout);

if(!isLogin()){
    redirect('?module=auth&action=login');
}

// Truy vấn vào bảng Users

$liatUsers = getRaw("SELECT * FROM users ORDER BY update_at");


// echo '<pre>';
// print_r($liatUsers);
// echo '</pre>';

$smg = getFlashdata('smg');
$smg_type = getFlashdata('smg_type');


$errorsFlashdata = getFlashdata('errors');
$oldData = getFlashdata('old_data');




?>



<div class="container">
    <hr>
    <h2>Quản lí người dùng</h2>
    
        <?php


        if(!empty($smg)){
            getSmg($smg, $smg_type);
        }



    ?>

    <p>
        <a href="?module=users&action=add-user" class="btn btn-success btn-sm">Thêm người dùng <i class="fa-solid fa-plus"></i></a>
    </p>
    <table class="table table-bordered">
        <thead>
           <th>STT</th>
           <th>Họ Tên</th>
           <th>Email</th>
           <th>Số điện thoại</th>
           <th>Trạng thái</th>
           <th width= "5%">Sửa</th>
           <th width= "5%">Xóa</th>
        </thead>
        <tbody>
            <?php
                if(!empty($liatUsers)):
                    $count = 0; // STT
                    foreach($liatUsers as $item):
                        $count ++;

            ?>
            <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $item['fullname'];  ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['phone']; ?></td>
            <td><?php echo $item['status'] == 1 ? '<button class="btn btn-success btn-sm"> Đã kích hoạt </button>' :'<button class="btn btn-danger btn-sm"> Chưa kích hoạt </button>' ; ?></td>
            <td><a href="<?php echo _WEB_HOST;?>?module=users&action=edit-user&id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
            <td><a href="<?php echo _WEB_HOST;?>?module=users&action=delete-user&id=<?php echo $item['id']; ?>" onclick=" return confirm('Bạn có chắc chắn muốn xóa')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
            <tr>


            <?php
                    endforeach;
                else: 
            ?>
            <tr>
                <td colspan="7">

                    <div class="alert alert-danger text-center">Không có người dùng nào</div>

                </td>
            </tr>
            <?php
                endif;
            ?>

        </tbody>

    </table>

</div>







<?php
layouts('footer');

?>