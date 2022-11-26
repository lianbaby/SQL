
<h1>教師註冊</h1>
<form action="./api/reg_user.php" method="post">
    <span>
        <div>
            <label for="acc">帳號：</label>
            <input type="text" name="acc" id="acc">
        </div>
        <div>
            <label for="pw">密碼：</label>
            <input type="password" name="pw" id="pw"></div>
        <div>
            <label for="email">信箱：</label>
            <input type="text" name="email" id="email"></div>
        <div>
            <label for="name">姓名：</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <input type="submit" value="註冊">
            <input type="reset" value="重置">
        </div>
    </span>
</form>
