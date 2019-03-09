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
    <link href="css/slider.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="background">
        <div id="page">
            <div id="header"> <a href="main.php" id="logo"><img src="images/gameworld.png" width="295" height="55"></a>
                <ul class="navigation">
                    <li>
                        <a class="active" href="main.php">Home</a>
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
                             echo'<a href="self.php">'.$_SESSION['name'].'</a>';
                         }
                        ?>
                    </li>
                </ul>
            </div>
            <!-- start of body-->
            <div id="body">
                <div class="slider_container">
                    <div>
                        <img src="images/kirbylogo.jpg" width="900" height="360" alt="pure css3 slider" />
                        <span class="info">Kirby Star 卡比之星</span>
                    </div>
                    <div>
                        <img src="images/breakoutlogo.jpg" width="900" height="360" alt="pure css3 slider" />
                        <span class="info">Breakout 打磚塊</span>
                    </div>
                    <div>
                        <img src="images/tetrislogo.jpg" width="900" height="360" alt="pure css3 slider" />
                        <span class="info">Tetris 俄羅斯方塊</span>
                    </div>
                </div>
                <div id="section">
                    <div class="footer">
                        <div class="body">
                            <ul class="article">
                                <li class="first">
                                    <a href="kirby.php"><img  src="images/kirbylogo.jpg" width="256" height="166" alt="kirby"class="img1"></a>
                                    <h2><a href="kirby.php">Kirby Star 卡比之星</a></h2>
                                    <p>
                                        遊戲說明與玩法:<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 卡比最近吃得太胖了，所以無法飛起來，因此無法靠自己打敗敵人，請幫幫卡比突破3道關卡，順利離開這邊!<br>
                                        空白鍵=跳躍、CTRL=攻擊，吸怪、SHIFT=變回原來卡比、左右=左右、上=進去門裡。
                                        

                                    </p>
                                    <a href="kirby.php" class="readmore">Play Game</a>
                                </li>
                                <li>
                                    <a href="breakout.php"><img src="images/breakoutlogo.jpg" width="256" height="166" alt="breakout" class="img2"></a>
                                    <h2><a href="breakout.php">Breakout 打磚塊</a></h2>
                                    <p>
                                        遊戲說明與玩法:<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 將磚塊全部用球消除，即可獲勝!球會隨著分數逐漸變快，請接好球!
                                        可以使用滑鼠或是鍵盤的左右來移動反彈板。
                                        <br>
                                        <br>
                                        <br>
                                    </p>
                                    <a href="breakout.php" class="readmore">Play Game</a>
                                </li>
                                <li class="last">
                                    <a href="tetris.php"><img src="images/tetrislogo.jpg" width="256" height="166"alt="tetris"class="img3"></a>
                                    <h2><a href="tetris.php">Tetris 俄羅斯方塊</a></h2>
                                    <p>
                                        遊戲說明與玩法:<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 將方塊一層一層的消除，獲得最高分數，一次消除越多條線，分數會得到越高，快來挑戰!
                                        使用上下左右可以更換方塊的方向!
                                        <br>
                                        <br>
                                        <br>
                                    </p>
                                    <a href="tetris.php" class="readmore">Play Game</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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
                                <a href="rankings.html">Rankings</a>
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

                        </ul>
                    </div>
                </div>
                <div id="footnote"> &copy; Copyright &copy; 2018 甘哲宇 all rights reserved </div>
            </div>
        </div>
    </div>

</body>

</html>
