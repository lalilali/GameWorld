<!DOCTYPE html>
<?php 
//載入資料庫與處理的方法
require_once 'db.php';

@session_start();


?>
<html>

<head>
    <title>Game World 遊戲世界</title>
    <meta charset="utf-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/rankings.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="background">
        <div id="page">
            <div id="header"> <a href="main.php" id="logo"><img src="images/gameworld.png" width="295" height="55"></a>
                <ul class="navigation">
                    <li>
                        <a href="main.php">Home</a>
                    </li>
                    <li>
                        <a href="rankings.php">Rankings</a>
                    </li>
                    <li>
                        <?php
                         if(!isset($_SESSION['is_login']) || !($_SESSION['is_login'])){
                             echo'<a href="member.html">Log In</a>';
                        }
                         else{
                             echo'<a href="logout.php">Log Out</a>';
                         }
                        ?>
                    </li>
                    <li>
                        <?php
                         if(!isset($_SESSION['is_login']) || !($_SESSION['is_login'])){
                             echo'<a href="signup.html">Sign up</a>';
                        }
                         else{
                             echo'<a class="active" href="self.php">'.$_SESSION['name'].'</a>';
                         }
                        ?>
                    </li>
                </ul>
            </div>
            <div align="center">
                <table id="t01" height="300" width="600">
                    <caption><h1>Rankings 排行榜</h1></caption>
                    <tr>
                        <th></th>
                        <th>Your rankings</th>
                    </tr>
                    <tr>
                        <td>Kirby Star<br>卡比之星</td>
                        <?php
                            @session_start();
                            $id=$_SESSION['Userid'];
                                
                            $sql= "Select `kirby` From `member` WHERE id='".$id."'";
                            $result = mysqli_query($_SESSION['link'], $sql);
                            
                             if($row=mysqli_fetch_array($result)){
                                $kirby=$row['kirby'];
                                echo "<td>$kirby</td>";
                            } 
                        
                        ?>

                    </tr>
                      <tr>
                        <td>Breakout<br>打磚塊</td>
                        <?php
                                
                            $sql= "Select `breakout` From `member` WHERE id='".$id."'";
                            $result = mysqli_query($_SESSION['link'], $sql);
                            
                             if($row=mysqli_fetch_array($result)){
                                $breakout=$row['breakout'];
                                echo "<td>$breakout</td>";
                            } 
                        
                        ?>
                    </tr>
                    <tr>
                        <td>Tetris<br>俄羅斯方塊</td>
                        <?php
                            
                            $sql= "Select `tetris` From `member` WHERE id='".$id."'";
                            $result = mysqli_query($_SESSION['link'], $sql);
                            
                             if($row=mysqli_fetch_array($result)){
                                $tetris=$row['tetris'];
                                echo "<td>$tetris</td>";
                            } 
                        
                        ?>
                    </tr>
                </table>

            </div>
            <!-- end of body-->
            <div id="footer">
                <div>
                    <div class="header"> <a href="main.php"><img class="logo" src="images/logo2.png" width="187" height="37" alt="logo"></a>
                        <ul class="connect">
                            <li>
                                <a href="https://www.facebook.com" class="facebook">&nbsp;</a>
                            </li>
                            <li>
                                <a href="https://twitter.com/" class="twitter">&nbsp;</a>
                            </li>
                            <li>
                                <a href="https://www.google.com.tw/" class="googleplus">&nbsp;</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <ul class="navigation">
                            <li>
                                <a href="main.php">Home</a>
                            </li>
                            <li>
                                <a href="rankings.php">Rankings</a>
                            </li>
                            <li>
                                <a href="memeber.html">Log In</a>
                            </li>
                            <li>
                                <a href="signup.html">Sign Up</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="footnote"> &copy; Copyright &copy; 2018 甘哲宇 all rights reserved </div>
            </div>
        </div>
    </div>
</body>

</html>
