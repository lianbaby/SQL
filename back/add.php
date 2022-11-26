
<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/dept_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/graduate_school_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/status_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes_dao.php";

    $studentDao = new \db\StudentDao();
    $deptDao = new \db\DeptDao();
    $graduateSchoolDao = new \db\GraduateSchoolDao();
    $statusDao = new \db\StatusDao();
    $classesDao = new \db\ClassesDao;

    //從資料庫中找到最大的學號
    $max_school_num = $studentDao->getMaxSchoolNum();
    //從`dept`資料表中撈出所有的科系資料並在網頁上製作成下拉選單的項目
    $dept_options = "";
    $depts = $deptDao->findAll();
    foreach($depts as $dept){
        $dept_options .= "<option value='{$dept->id}'>{$dept->name}</option>";
    }
    //從`graduate_school`t資料表中撈出所有的畢業學生資料並在網頁上製作成下拉選單的項目
    $graduate_school_options = "";
    $graduateSchools = $graduateSchoolDao->findAll();
    foreach($graduateSchools as $graduateSchool){
        $graduate_school_options .= "<option value='{$graduateSchool->id}'>{$graduateSchool->county}{$graduateSchool->name}</option>";
    }

    //從`status`資料表中撈出所有的畢業狀態並在網頁上製作成下拉選單的項目
    $status_options = "";
    $statusList = $statusDao->findAll();
    foreach($statusList as $status){
        $status_options .= "<option value='{$status->code}'>{$status->status}</option>";
    }

    //從`classes`資料表中撈出所有的班級資料並在網頁上製作成下拉選單的項目
    $class_options = "";
    $classes = $classesDao->findAll();
    foreach($classes as $class){
        $class_options .= "<option value='{$class->code}'>{$class->name}</option>";
    }
?>
<h1>新增學生</h1>
<form action="api/add_student.php" method="post">
    <table>
        <tr>
            <td>學號</td>
            <!--將最大的學號+1後做為要新增的下一位學生的學號-->
            <td>
                <?= $max_school_num + 1 ?>
                <input type="hidden" name="school_num" value="<?= $max_school_num + 1 ?>">
            </td>
        </tr>
        <tr>
            <td>姓名</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>生日</td>
            <td><input type="date" name="birthday"></td>
        </tr>
        <tr>
            <td>生份證號碼</td>
            <td><input type="text" name="uni_id"></td>
        </tr>
        <tr>
            <td>地址</td>
            <td><input type="text" name="addr"></td>
        </tr>
        <tr>
            <td>父母</td>
            <td><input type="text" name="parents"></td>
        </tr>
        <tr>
            <td>電話</td>
            <td><input type="text" name="tel"></td>
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
            <td>畢業狀態</td>
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
                    <?= $class_options ?>
                </select>                
            </td>
        </tr>
    </table>
    <input type="submit" value="確認新增" style="  font-size: 20px;
    margin-top: 25px;">
    <input type="reset" value="重置" style="  font-size: 20px;
    margin-top: 25px;">
</form>
</form>
