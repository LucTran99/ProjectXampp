<?php


// Xử lí kết nối




try{


    if(class_exists('PDO')){
        
        $dsn = 'mysql:dbname='._DB. ';host='._HOST;
  
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', 
            PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Tạo thông báo ra ngoại lệ khi gặp lỗi
          ];
    
        // $connect = new PDO($dsn, _USER, _PASS, $options);
        $connect = new PDO($dsn,  _USER, _PASS, $options);
    }



}catch(Exception $ex){
   echo $ex -> getMessage(). '<br>';
   echo $ex -> getFile(). '<br>';
   echo $ex -> getLine();
}

?>