<?php
//使用PDO方式建立資料庫連線物件
$dsn="mysql:host=localhost;charset=utf8;dbname=schools";
$pdo=new PDO($dsn,'root','');
?>