<?php include "../layout/link_css.php";?>
<?php include "../layout/scripts.php";?>
<div class='col-md-6 mx-auto my-3 px-5 py-3 border shadow-sm'>
<h3 class="text-center">編輯學生資料</h3>
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
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">學號</label>
            <div class="form-control col-md-8 border-0"><?=$student->school_num?></div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">姓名</label>
            <input class="form-control col-md-8" type="text" name="name" value="<?=$student->name?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">生日</label>
            <input class="form-control col-md-8" type="date" name="birthday" value="<?=$student->birthday?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">身份證字號</label>
            <input class="form-control col-md-8" type="text" name="uni_id" value="<?=$student->uni_id?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">地址</label>
            <input class="form-control col-md-8" type="text" name="addr" value="<?=$student->addr?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">家長</label>
            <input class="form-control col-md-8" type="text" name="parents" value="<?=$student->parents?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">電話</label>
            <input class="form-control col-md-8" type="text" name="tel" value="<?=$student->tel?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">科系</label>
                
                    <?php DeptSelect::render($student->dept, [ "name" => "dept" ]) ?>
               
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">畢業學校</label>
                
                    <?php GraduateSchoolSelect::render($student->graduate_at, [ "name" => "graduate_at" ]) ?>
                
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">畢業狀態</label>
                
                    <?php StatusSelect::render($student->status_code, [ "name" => "status_code" ]) ?>
                
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">班級</label>
                
                    <?php ClassSelect::render($classStudent->class_code, [ "name" => "status_code","class"=>"..." ]) ?>             
                
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-4" style="text-align-last:justify">座號</label>
                <div class="form-control col-md-8 border-0"><?=$classStudent->seat_num?></div>
        </div>
    
        <div class="text-center">
            <input type="hidden" name="id" value="<?=$student->id?>">
            <input class="btn btn-primary" type="submit" value="確認修改">
        </div>
</form>