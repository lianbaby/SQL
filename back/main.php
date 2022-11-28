<?php 
    include_once "./layout/class_nav.php";
    include_once "./layout/paging.php";

    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/student_dao.php";

    $studentDao = new \db\StudentDao();

    if(isset($_GET['del'])){
        echo "<div class='del-msg'>";
        echo $_GET['del'];
        echo "</div>";
    }


    /**
     * 分頁參數處理中心
     */
    // 每頁顯示筆數
    $div = 10;
    // 學生總數量
    $total = 0;
    // 學生資料
    $students = null;
    // 獲取當前頁碼
    $now = $_GET['page'] ?? 1;
    // 計算資料從第幾比開始獲取 0 為第一筆
    $start = ($now - 1) * $div;
    // 顯示班級區塊及獲取預設班級編碼
    $code = $_GET['code'] ?? null;
    $code = ClassNav::renderAndGetDefaultCode($code);

    if ($code) {
        $students = $studentDao->findAllByClassCode($code, $start, $div);
        $total = $studentDao->countByClassCode($code);
    } else {
        $students = $studentDao->findAll($start, $div);
        $total = $studentDao->count();
    }

    $pages = ceil($total / $div);
    // 顯示分頁區塊
    Paging::render($now, $pages, 5, $code);
    if(isset($_GET['status'])){
        switch($_GET['status']){
            case 'add_success':
                echo "<span style='color:green;font-size: 24px;
                padding: 510px;'>新增學生成功</span>";
            break;
            case 'add_fail';
                echo "<span style='color:red'>新增學生有誤</span>";
            break;
            case 'edit_error':
                echo "<span style='color:red'>無法編輯，請洽管理員或正確操作</span>";
            break;
        }
    }

?>
<!--建立顯示學生列表的表格html語法-->
<table class='list-students'>
<tr>
    <th>學號</th>
    <th>姓名</th>
    <th>生日</th>
    <th>畢業國中</th>
    <th>年齡</th>
    <th>操作</th>
</tr>    
<?php
//使用迴圈來顯示每一位學生的資料
foreach($students as $student){ 
    $age= round((strtotime('now')-strtotime($student->birthday))/(60*60*24*365),1);
    echo "
        <tr>
            <td>{$student->school_num}</td>
            <td>{$student->name}</td>
            <td>{$student->birthday}</td>
            <td>{$student->graduate_at}</td>
            <td>{$age}</td>
            <td>
                <!-- 加上連結將頁面導向edit.php，同時以GET方式將學生資料的id傳遞到edit.php -->
                <a class='edit' href='./back/edit.php?id={$student->id}'>編輯</a>
                <!-- 加上連結將頁面導向del.php，同時以GET方式將學生資料的id傳遞到del.php -->
                <a class='del' href='./back/confirm_del.php?id={$student->id}'>刪除</a>
            </td>
        </tr>
    ";
}
?>
</table>