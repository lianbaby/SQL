
<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";
    
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/dept_select.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/graduate_school_select.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/status_select.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/class_select.php";

    $studentDao = new \db\StudentDao();

    //從資料庫中找到最大的學號
    $max_school_num = $studentDao->getMaxSchoolNum();
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
                <?php DeptSelect::render(null, [ "name" => "dept"]) ?>
            </td>
        </tr>
        <tr>
            <td>畢業國中</td>
            <td>
                <?php GraduateSchoolSelect::render(null, [ "name" => "graduate_at" ]) ?>
            </td>
        </tr>
        <tr>
            <td>畢業狀態</td>
            <td>
                <?php StatusSelect::render(null, [ "name" => "status_code" ]) ?>
            </td>
        </tr>
        <tr>
            <td>班級</td>
            <td>
                <?php ClassSelect::render(null, [ "name" => "class_code" ]) ?>              
            </td>
        </tr>
    </table>
    <input type="submit" value="確認新增" style="  font-size: 20px;
    margin-top: 25px;">
    <input type="reset" value="重置" style="  font-size: 20px;
    margin-top: 25px;">
</form>
</form>
