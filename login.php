<?php
@session_start();
require_once 'db.php';

$id=$_POST["id"];
 $pwd=$_POST["password"];

$_SESSION['Userid']=$id;
//echo $_SESSION['Userid'];


//Select Data
$sql = "Select * FROM member WHERE id='".$id."' and pwd='".$pwd."'";
//echo "<p>".$sql."</p>";

if ($result=mysqli_query($_SESSION['link'] , $sql)) {
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_array($result);
         $_SESSION['name']=$row['name'];
         $_SESSION['kirby']=$row['kirby'];
         $_SESSION['breakout']=$row['breakout'];
         $_SESSION['tetris']=$row['tetris'];
         //取得使用者資料
         $user = mysqli_fetch_assoc($result);

          //在session李設定 is_login 並給 true 值，代表已經登入
          $_SESSION['is_login'] = TRUE;
          //紀錄登入者的id，之後若要隨時取得使用者資料時，可以透過 $_SESSION['login_user_id'] 取用
          $_SESSION['login_user'] = $user;
          //回傳的 $result 就給 true 代表驗證成功
          echo "<script type='text/javascript'>";
          echo "window.alert('登入成功!即將跳回主頁!');";
          echo "window.location.href='main.php'";
          echo "</script>"; 
     }
     else{
         echo "<script type='text/javascript'>";
         echo "window.alert('輸入錯誤的帳號或密碼!');";
         echo "window.alert('請重新輸入一次!');";
         echo "window.location.href='member.html'";
         echo "</script>"; 

    }
} 
else {
      echo "Error: " . $sql . "<br>" . mysqli_error($_SESSION['link']);
}
?>
