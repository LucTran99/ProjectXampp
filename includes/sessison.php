

<!-- Hàm liên quan đến session hay cookies -->


<?php

// Hàm gán session

function setSession ($key, $value){
  return $_SESSION[$key] = $value;

}

// ví dụ:
// $seeeion = setSession('BoyKa', 'Giá trị của Session');
// var_dump($seeeion);
// Nó sẽ in ra là: string(30) "Giá trị của Session"





// khi ta chạy nó đã có một cái session. Giờ ta đọc nó


// Hàm đọc session

function getSession($key = ''){
    if(empty($key)){
        return $_SESSION;
    }
    else{
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }
}

// Ví dụ:
// echo getSession('Boyka');










// Hàm xóa session

function removeSession($key = ''){
   if(empty($key)){
    session_destroy();
    return true;
   }
   else{
    if(isset($_SESSION[$key])){
        unset($_SESSION[$key]);
        return true;
    }
   }
}




// Hàm gán flash data

  function setFlashdata($key, $value){
    $key = 'flash_'.$key;
    return setSession($key, $value);
  }

// Ví dụ:

// setFlashdata('Boyka', 'Giá trị setFlashdata trong session');

// Khi trình duyệt chạy setFlashdata sẽ hoạt động và sẽ tạo ra một session







// Hàm đọc flash data

function getFlashdata($key){
    $key = 'flash_'.$key;
    $data = getSession($key);
    removeSession($key);
    return $data;
}


// Và khi đã có session có key là Boyka. Ta sẽ in nó ra

// echo getFlashdata('Boyka');

// khi ta load lại lần 2 session này sẽ mất











?>