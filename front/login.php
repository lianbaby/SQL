<h1>教師登入</h1>
<div>
<?php
session_start();

if(isset($_GET['error'])){
    echo "帳號或密碼錯誤，";
    echo "登入嘗試".$_SESSION['login_try']."次";
}

?>
</div>

<form action="./api/chk_user.php" method="post">
    <div>
        <label for="acc">帳號:</label>
        <input type="text" name="acc" id="acc">
    </div>
    <div>
        <label for="pw">密碼:</label>
        <input type="password" name="pw" id="pw">
    </div>
    <div>
        <input type="submit" value="登入">
    </div>
</form>