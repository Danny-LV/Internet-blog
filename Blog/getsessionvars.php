<?php
    session_start();
    echo json_encode($_SESSION); // Пароли и служебная информация передаваться не должны
/*    $sessInfo = [];
    $sessInfo['user']=$_SESSION['user'];
    ....
    echo json_encode($sessInfo); */
?>