<?php  
  // Hàm dùng chung liên quan đến csdl: insert, delete, update, select


// tham số sql là : $sql = 'SELECT * FROM sinhvien';

// tham số data là: 

// $data = [

//     'fullname' => $fullname,
//     'age' => $age,
//     'id_subject' =>  $subject
 
//  ];



  function query($sql, $data = [], $check = false){
    global $connect;
    $kq = false;
     try{


       
        $statement = $connect -> prepare($sql);

        if(!empty($data)){
            $kq =  $statement -> execute($data);
        }
        else{
            $kq = $statement -> execute();
        }

     }catch(Exception $ex){
        echo  $ex -> getMessage() .'<br>';
        echo 'File'. $ex -> getFile().'<br>';
        echo 'Line'. $ex -> getLine();
        die();
     }
     if($check){
      return $statement;
     }
     return $kq;
  }





  // Hàm Insert

  function insert($table, $data){

    // key là các trường mà ta muốn insert (fullname, email, phone, ...)
    $key = array_keys($data);
    // Nối key thành một chuỗi
    $truong  = implode(',', $key);


    // ds values
    $values = ':'. implode(',:', $key);
    

    // Inser into vào bảng nào, trường nào
    $sql = 'INSERT INTO '. $table . '('.$truong.')'.'VALUES('.$values.')';

  $kq =  query($sql, $data);
   return $kq;

  }
   


   
  // Hàm Update

  // $sql = 'UPDATE sinhvien SET fullname = :fullname, age = :age WHERE id = :id';

  function update($table, $data, $conditin= ''){
     $update = '';
      foreach($data as $key => $value){
        $update .=  $key . '= :'.$key. ',';
      }
      $update= trim($update, ',');
      if(!empty($conditin)){
        $sql = ' UPDATE '. $table .' SET '. $update .' WHERE '. $conditin;
      }else{
        $sql = 'UPDATE '. $table .' SET '. $update;
      }
     $kq =  query($sql, $data);
      return  $kq; 
  }





  // Hàm delete
  function delete($table, $condition = ''){
    if(empty($condition)){
      $sql = 'DELETE FROM '. $table;
    }else{
      $sql = 'DELETE FROM '. $table . ' WHERE '. $condition;
    }
   $kq =  query($sql);
    return $kq;
  }




  // SELECT
  // Lấy nhiều dòng dữ liệu
  function getRaw($sql){
      $kq = query($sql, '', true);
        if(is_object($kq)){
        $dataFetchAll =   $kq -> fetchAll(PDO::FETCH_ASSOC);
        }
        return $dataFetchAll;
        
    }

  
  

  // Lấy 1 dòng dữ liệu
  function oneRaw($sql){
    $kq = query($sql, '', true);
      if(is_object($kq)){
      $dataFetchAll  =   $kq -> fetch(PDO::FETCH_ASSOC);
      }
      return $dataFetchAll;
      
  }



  // Đếm số dòng dữ liệu
  function getRows($sql){
    $kq = query($sql, '', true);
      if(!empty($kq)){
       return $kq -> rowCount();
      }
   
      
  }
  
?>