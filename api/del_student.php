<?php
include "../db/base.php";

$student=$pdo->query("SELECT * FROM `students` WHERE `id` = '{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);
$sql_class="DELETE FROM `class_student` WHERE `school_num` = '{$student['school_num']}'";
$sql_student="DELETE FROM `students` WHERE `id`='{$_GET['id']}'";



$res_class=$pdo->exec($sql_class);
$res_student=$pdo->exec($sql_student);
header("location:../admin_center.php?del=已成功刪除學生{$student['name']}的所有資料!!");
?>