


<?php






if(!defined('_CODE')){
    die('Access denied...');
}

require_once (WEB_PATH_TEMPLATES.'/layout/header.php');

if(!isLogin()){
    redirect('?module=auth&action=login');
}



?>
<h1>DashBoard</h1>




<?php

require_once (WEB_PATH_TEMPLATES.'/layout/footer.php');


?>
