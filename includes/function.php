<?php

// // Truy cập ko hợp lệ
// if(!defined('_CODE')){
//     die('Access denied...');  
// }





// Hàm kiểm tra xem có file layout có tên $layoutName.php tồn tại trong đường dẫn WEB_PATH_TEMPLATES.'/layout/' hay không
// bằng cách sử dụng hàm file_exists.

// Nếu file layout tồn tại, hàm sẽ sử dụng require_once để tải file layout đó.

function layouts ($layoutName = 'header', $data =  []){
    if(file_exists(WEB_PATH_TEMPLATES . '/layout/'.$layoutName.'.php')){  // Nếu tồn tại
        require_once WEB_PATH_TEMPLATES . '/layout/'.$layoutName.'.php';

    }
}



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



// Hàm gửi Mail
function senMail($to, $subject, $content){

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        // Đây là phần cấu hình của SMTP  
    
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'luc823591@gmail.com';                     //SMTP username
        $mail->Password   = 'qqvx ohvb bpgk hbha';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
    
    
        //Recipients: Người nhận
      
        $mail->setFrom('luc19102004@gmail.com', 'Luc Tran');
        $mail->addAddress($to);     // Địa chỉ Email nhận
    
    
    
    
        //Content: Nội dung
        $mail -> CharSet = 'UTF-8';
      
        $mail->isHTML(true);                                  //Set email format to HTML
    
        $mail->Subject = $subject;  // Chủ đề
        $mail->Body    = $content;
    
    
       $sendMail =    $mail->send();
       if($sendMail){
        return $sendMail;
       }
        //echo 'Gửi thành công'; // Gửi thành công
    
    } catch (Exception $e) {
        echo "Gửi mail thất bại. Mailer Error: {$mail->ErrorInfo}";
    }
 }
 




 // Hàm Filter: Lọc dữ liệu
 // Vì khi đăng nhập có những form điền thông tin, nên dữ liệu lấy được từ form login sẽ ảnh hưởng trực tiếp đến csdl
 // Và khi nó lấy từ form qua csdl nó sẽ phát sinh những vấn đề bảo mật

 // Nên khi ta lấy dữ liệu đầu vào từ form thì ta sẽ phải lọc dữ liệu



 // trước khi viết hàm filter ta kiểm tra, lấy dữ liệu từ phương thức get hay là post




 // Kiểm tra phương thức get (Trên thanh địa chỉ)

 function isGet(){
    // Biến  $_SERVER['REQUEST_METHOD']: Giúp chúng ta lấy ra được cái method mà chương trình đang chạy là get hay là post

   if( $_SERVER['REQUEST_METHOD'] == 'GET'){  // Nếu là GET (trên thanh địa chỉ)
         return true;
   }
   return false;
 }
 


  // Kiểm tra phương thức Post (Form đăng nhập, đăng kí, quên mật khẩu)

  function isPost(){
    // Biến  $_SERVER['REQUEST_METHOD']: Giúp chúng ta lấy ra được cái method mà chương trình đang chạy là get hay là post

   if( $_SERVER['REQUEST_METHOD'] == 'POST'){  // Nếu là POST (ở form)
         return true;
   }
   return false;
 }




 // Hàm filter lọc dữ liệu

// Hàm filter này giúp đảm bảo rằng dữ liệu được truyền qua phương thức GET đã được lọc để ngăn chặn các cuộc tấn công XSS
// (Cross-Site Scripting) bằng cách loại bỏ hoặc mã hóa các ký tự đặc biệt nguy hiểm.


function filter(){

    $filterArr = [];  // lưu trữ các giá trị đã lọc.

    if(isGet()){

        // Xử lí cái dữ liệu trước khi gọi ra
        // return $_GET;

        if(!empty($_GET)){  // Nếu request là GET và không rỗng

            foreach($_GET as $key => $value){

                $key = strip_tags($key);

                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);  
                }else{
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);  
                }

                // để lấy giá trị của mỗi tham số GET, lọc nó với các bộ lọc FILTER_SANITIZE_SPECIAL_CHARS

            }
        }
    }

    // Như phương thức Get
    if(isPost()){

    

        if(!empty($_POST)){  // Nếu request là GET và không rỗng

            foreach($_POST as $key => $value){

              
                $key = strip_tags($key);
                
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);  
                }else{
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);  
                }

                // để lấy giá trị của mỗi tham số GET, lọc nó với các bộ lọc FILTER_SANITIZE_SPECIAL_CHARS

            }
        }
    }




    return $filterArr;
}






// Viết hàm validate

// Kiểm tra email

function isEmail ($email){
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);  // Kiểm tra định dạng
    return $checkEmail;
}



// Kiểm tra kiểu int

function isNumber ($number){
    $checkInt = filter_var($number, FILTER_VALIDATE_INT);
       return $checkInt;
}




// Kiểm tra kiểu int

function isFloat ($float){
    $checkFloat = filter_var($float, FILTER_VALIDATE_FLOAT);
       return $checkFloat;
}



// Kiểm tra số điện thoại

function isPhone($phone){
    // Điều kiện 1
    $checkZero = false;
    if($phone[0] == '0'){
        $checkZero = true;

        $phone = substr($phone, 1);  // Xóa số 0 đầu tiên đi
    }

    // Điều kiện 2
    $checkLenght = false;
    if(isNumber($phone) && strlen($phone) == 9){
         $checkLenght = true;
 
    }

    if($checkZero && $checkLenght){
        return true;
    }
    return false;

}




// Thông báo lỗi

function getSmg($smg, $type = 'success'){
        echo '<div class="alert alert-'.$type.' ">';
        echo $smg;
       echo '</div>';
}






// Hàm chuyển hướng

function redirect($path ='index.php'){
    header("Location: $path");
    exit;
}



// Hàm hiển thị thông báo lỗi ở dưới input

function formErrors($fileName, $beforeHTML = '', $afterHTML = '', $errorsFlashdata){
    return (!empty($errorsFlashdata[$fileName]) ? '<span class="error">' .reset($errorsFlashdata[$fileName]). '</span>': null);
}


// Hàm lưu giá trị cũ của form
function oldValues($fileName_Old, $old_data, $default = null ){
   
 
    return (!empty($old_data[$fileName_Old]) ? $old_data[$fileName_Old] : $default);
    
}




// Hàm kiểm tra trạng thái đăng nhập

function isLogin(){
    $checkLogin = false;
    if(getSession('logintoken')){
        $tokenLogin = getSession('logintoken');
        $sql = oneRaw("SELECT user_id FROM logintoken WHERE token = '$tokenLogin'");
        if(!empty($sql)){
            $checkLogin = true;

        }else{
            removeSession('logintoken');
        }
    }

    return $checkLogin;
}