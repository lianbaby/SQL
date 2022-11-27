<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/class_student_dao.php";

    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/student.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/class_student.php";

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
    try {
        $studentDao->beginTransaction();
        $classStudentDao->beginTransaction();

        $is_success = $studentDao->create($student) && $classStudentDao->create($classStudent);
    } catch (Exception $e) {
        throw $e;
    } finally {
        if ($is_success) {
            $studentDao->commit();
            $classStudentDao->commit();
        } else {
            $studentDao->rollback();
            $classStudentDao->rollback();
        }
    }

    // 新增成功後返回首頁
    $status= $is_success ? 'add_success' : 'add_fail';

    header("location:../admin_center.php?status=$status")

?>