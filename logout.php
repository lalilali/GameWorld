<?php
@session_start();
	//假設的有效會員帳號
	require_once 'db.php';
$_SESSION['login_user']="log_out";
$_SESSION['is_login']=null;

//echo $_SESSION['login_user'];
echo "<script type='text/javascript'>";
        echo "window.alert('已登出，將跳轉回主頁');";
        echo "window.location.href='main.php'";
        echo "</script>"; 
?>
