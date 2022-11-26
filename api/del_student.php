<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/class_student_dao.php";
    $id = $_GET['id'];

    $studentDao = new \db\StudentDao();
    $classStudentDao = new \db\ClassStudentDao();

    $student = $studentDao->findOne($id);

    $classStudentDao->delete([ "school_num" => $student->school_num ]);
    $studentDao->delete($id);

    header("location:../admin_center.php?del=已成功刪除學生{$student->name}的所有資料!!");
?>