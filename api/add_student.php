<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/autoload.php";

    $studentDao = new \db\StudentDao();
    $classStudentDao = new \db\ClassStudentDao();

    $student = new \entity\Student();
    $classStudent = new \entity\ClassStudent();
    
    $student->school_num = $_POST['school_num'];
    $student->name = $_POST['name'];
    $student->birthday = $_POST['birthday'];
    $student->uni_id = $_POST['uni_id'];
    $student->addr = $_POST['addr'];
    $student->parents = $_POST['parents'];
    $student->tel = $_POST['tel'];
    $student->dept = $_POST['dept'];
    $student->graduate_at = $_POST['graduate_at'];
    $student->status_code = $_POST['status_code'];

    $classStudent->class_code = $_POST['class_code'];
    $classStudent->year = 2000;
    $classStudent->seat_num = $classStudentDao->getMaxSeatNumByClassCode($classStudent->class_code) + 1;
    $classStudent->school_num = $student->school_num;

    $is_success = false;
    $msg = "新增學生成功。";
    $msg_type = "success";
    try {
        $studentDao->beginTransaction();
        $classStudentDao->beginTransaction();

        $is_success = $studentDao->create($student) && $classStudentDao->create($classStudent);
    } catch (Exception $e) {
    }

    if ($is_success) {
        $studentDao->commit();
        $classStudentDao->commit();
    } else {
        $msg = "新增學生有誤";
        $msg_type = "error";
        $studentDao->rollback();
        $classStudentDao->rollback();
    }

    $msg = urlencode($msg);

    header("location:../admin_center.php?msg=$msg&msg_type=$msg_type&code={$classStudent->class_code}")
?>