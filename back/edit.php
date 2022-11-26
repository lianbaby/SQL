 
<h1>編輯學生資料</h1>
<?php 
    include_once "../db/base.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/dept_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/graduate_school_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/status_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/class_student_dao.php";

    $id = $_GET['id'] ?? null;

    if (!$id) {
        return header("location:index.php?status=edit_error");
    }

    $studentDao = new \db\StudentDao();
    $deptDao = new \db\DeptDao();
    $graduateSchoolDao = new \db\GraduateSchoolDao();
    $statusDao = new \db\StatusDao();
    $classesDao = new \db\ClassesDao();
    $classStudentDao = new \db\ClassStudentDao();

    $student = $studentDao->findOne($id);
    
    //從`dept`資料表中撈出所有的科系資料並在網頁上製作成下拉選單的項目
    $dept_options = "";
    $depts = $deptDao->findAll();
    foreach($depts as $dept){
        $selected = ($dept->id == $student->dept) ? 'selected': '';
        $dept_options .= "<option value='{$dept->id}' $selected>{$dept->name}</option>";
    }

    //從`graduate_school`t資料表中撈出所有的畢業學生資料並在網頁上製作成下拉選單的項目
    $graduate_school_options = "";
    $graduateSchools = $graduateSchoolDao->findAll();
    foreach($graduateSchools as $graduateSchool){
        $selected = ($graduateSchool->id == $student->graduate_at) ?'selected':'';
        $graduate_school_options .= "<option value='{$graduateSchool->id}' $selected>{$graduateSchool->county} - {$graduateSchool->name}</option>";
    }

    //從`status`資料表中撈出所有的畢業狀態並在網頁上製作成下拉選單的項目
    $status_options = "";
    $statusList = $statusDao->findAll();
    foreach($statusList as $status){
        $selected = ($status->code == $student->status_code) ?'selected':'';
        $status_options .= "<option value='{$status->code}' $selected>{$status->status}</option>";
    }

    //從`classes`資料表中撈出所有的班級資料並在網頁上製作成下拉選單的項目
    $class_code_options = "";
    $classStudent = $classStudentDao->findOneBySchoolNum($student->school_num);
    $classes = $classesDao->findAll();
    foreach($classes as $class){
        $selected = ($class->code == $classStudent->class_code) ? 'selected' : '';
        $class_code_options .= "<option value='{$class->code}' $selected>{$class->name}</option>";
    }
?>
<form action="../api/edit_student.php" method="post">
    <table>
        <tr>
            <td>學號</td>
            <td><?= $student->school_num ?></td>
        </tr>
        <tr>
            <td>姓名</td>
            <td><input type="text" name="name" value="<?= $student->name ?>"></td>
        </tr>
        <tr>
            <td>生日</td>
            <td><input type="date" name="birthday" value="<?= $student->birthday ?>"></td>
        </tr>
        <tr>
            <td>身分證號碼</td>
            <td><input type="text" name="uni_id" value="<?= $student->uni_id ?>"></td>
        </tr>
        <tr>
            <td>地址</td>
            <td><input type="text" name="addr" value="<?= $student->addr ?>"></td>
        </tr>
        <tr>
            <td>家長</td>
            <td><input type="text" name="parents" value="<?= $student->parents ?>"></td>
        </tr>
        <tr>
            <td>電話</td>
            <td><input type="text" name="tel" value="<?= $student->tel ?>"></td>
        </tr>
        <tr>
            <td>科別</td>
            <td>
                <select name="dept">
                    <?= $dept_options ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>畢業國中</td>
            <td>
                <select name="graduate_at" >
                    <?= $graduate_school_options ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>畢業狀況</td>
            <td>
                <select name="status_code" >
                   <?= $status_options ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>班級</td>
            <td>
                <select name="class_code">
                    <?= $class_code_options ?>
                </select>                
            </td>
        </tr>
        <tr>
            <td>座號</td>
            <td><?= $classStudent->seat_num ?></td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?= $student->id ?>">
    <input type="submit" value="確認修改">
</form>