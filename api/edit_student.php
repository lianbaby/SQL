<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/class_student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/student.php";

    $studentDao = new \db\StudentDao();
    $classStudentDao = new \db\ClassStudentDao();
    
    $student = new \entity\Student();

    $student->id = $_POST['id'];
    $student->name=$_POST['name'];
    $student->birthday=$_POST['birthday'];
    $student->uni_id=$_POST['uni_id'];
    $student->addr=$_POST['addr'];
    $student->parents=$_POST['parents'];
    $student->tel=$_POST['tel'];
    $student->dept=$_POST['dept'];
    $student->graduate_at=$_POST['graduate_at'];
    $student->status_code=$_POST['status_code'];

    $class_code = $_POST['class_code'];
    $msg = "編輯學生成功。";
    $msg_type = "success";
    try {
        $studentDao->beginTransaction();
        $classStudentDao->beginTransaction();

        $studentDao->modify($student);
    
        $student = $studentDao->findOne($student->id);
        $class = $classStudentDao->findOneBySchoolNum($student->school_num);
        
        //學員所屬班級在另一張資料class_student
        $class->class_code = $class_code;
    
        $classStudentDao->modify($class);
        $studentDao->commit();
        $classStudentDao->commit();
    } catch (Exception $e) {
        $studentDao->rollback();
        $classStudentDao->rollback();
        $msg = "無法編輯，請洽管理員或正確操作";
        $msg_type = "error";
    }

    $msg = urlencode($msg);

    header("location:../admin_center.php?code=$class_code&msg=$msg&msg_type=$msg_type", false);
?>