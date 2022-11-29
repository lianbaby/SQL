<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/autoload.php";

    $userDao = new \db\UserDao();
    $user = new \entity\User();

    $user->acc = trim(strip_tags($_POST['acc']));
    $user->pw = trim($_POST['pw']);
    $user->name = trim($_POST['name']);
    $user->email = trim($_POST['email']);
    $user->last_login = null;
    
    $userDao->create($user);

    header("location:../index.php?do=login");
?>