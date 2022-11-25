<header>
    <div class="nav">
        <?php
        if (isset($_SESSION['login']))
            echo "歡迎".$_SESSION['login']['name']."老師";
        else
        echo "= 教師 註冊/登入 =";
        
        ?>
    </div>
    <nav>
        <a href=''>教師註冊</a>
        <a href=''>教師登入</a>
    </nav>
         
</header>