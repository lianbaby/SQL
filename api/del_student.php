<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/class_student_dao.php";
    $id = $_GET['id'];

    $studentDao = new \db\StudentDao();
    $classStudentDao = new \db\ClassStudentDao();

    $student = $studentDao->findOne($id);
    $msg = "已成功刪除學生{$student->name}的所有資料!!";
    $msg_type = "success";
    try {
        $classStudentDao->beginTransaction();
        $studentDao->beginTransaction();

        $classStudentDao->delete([ "school_num" => $student->school_num ]);
        $studentDao->delete($id);

        $classStudentDao->commit();
        $studentDao->commit();
    } catch (Exception $e) {
        $classStudentDao->rollback();
        $studentDao->rollback();
        $msg = "刪除學生失敗";
        $msg_type = "error";
    }

    $msg = urlencode($msg);

    header("location:../admin_center.php?msg=$msg&msg_type=$msg_type");
?>