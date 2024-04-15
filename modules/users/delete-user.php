<?php

$filterAll = filter();

if(!empty($filterAll['id'])){

    $userId = $filterAll['id'];
    $sql = getRows("SELECT * FROM users WHERE id = $userId");
    if($sql > 0){
        // Thực hiện xóa

        $deleteToken = delete('logintoken', "user_id = $userId");
        if($deleteToken){
            // Xóa User
            $deleteUSer = delete('users', "id = $userId");


            if($deleteUSer){

                setFlashdata('smg', 'Xóa người dùng thành công');
                setFlashdata('smg_type', 'success');


            }else{

                setFlashdata('smg', 'Lỗi hệ thống');
                setFlashdata('smg_type', 'danger');
            }

        }else{
            setFlashdata('smg', 'Liên kết không tồn tại');
            setFlashdata('smg_type', 'danger');
        }

    }else{
        setFlashdata('smg', 'Người dùng không tồn tại');
        setFlashdata('smg_type', 'danger');
    }

    


}else{
    setFlashdata('smg', 'Liên kết không tồn tại');
    setFlashdata('smg_type', 'danger');
}

redirect('?module=users&action=list-user');