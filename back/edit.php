 
<h1>編輯學生資料</h1>
<?php 
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/class_student_dao.php";

    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/dept_select.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/graduate_school_select.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/status_select.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/class_select.php";

    $id = $_GET['id'] ?? null;

    if (!$id) {
        return header("location:index.php?status=edit_error");
    }

    $studentDao = new \db\StudentDao();
    $classStudentDao = new \db\ClassStudentDao();

    $student = $studentDao->findOne($id);
    $classStudent = $classStudentDao->findOneBySchoolNum($student->school_num);
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
                <?php DeptSelect::render($student->dept, [ "name" => "dept" ]) ?>
            </td>
        </tr>
        <tr>
            <td>畢業國中</td>
            <td>
                <?php GraduateSchoolSelect::render($student->graduate_at, [ "name" => "graduate_at" ]) ?>
            </td>
        </tr>
        <tr>
            <td>畢業狀況</td>
            <td>
                <?php StatusSelect::render($student->status_code, [ "name" => "status_code" ]) ?>
            </td>
        </tr>
        <tr>
            <td>班級</td>
            <td>
                <?php ClassSelect::render($classStudent->class_code, [ "name" => "class_code" ]) ?>             
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