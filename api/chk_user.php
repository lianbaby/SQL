<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/autoload.php";

$userDao = new \db\UserDao();

session_start();

$acc = $_POST['acc'];
$pw = $_POST['pw'];

$chk= $userDao->count([ "acc" => $acc, "pw" => $pw ]);

if($chk === 1){
    $_SESSION['login']= serialize($userDao->findOne($acc, $pw));
    header("location:../admin_center.php");

    return;
}

if(isset($_SESSION['login_try'])){
    $_SESSION['login_try']++;
}else{
    $_SESSION['login_try']=1;
}

header("location:../login.php?error=login");
?>