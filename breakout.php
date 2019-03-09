<!DOCTYPE html>
<?php 
//載入資料庫與處理的方法
require_once 'db.php';

@session_start();
if(!isset($_SESSION['is_login']) || !($_SESSION['is_login'])){
   echo "<script type='text/javascript'>";
          echo "window.alert('請先登入才能進行遊戲!');";
          echo "window.location.href='member.html'";
          echo "</script>";
}

?>
<html>
<head>
	<title>Game World 遊戲世界</title>
	<meta charset="utf-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
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

<canvas id="myCanvas" width="960" height="640" style="border:3px solid #000000;"></canvas>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
	// JavaScript code goes here
    var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
var ballRadius = 10;
var x = canvas.width/2;
var y = canvas.height-30;
var dx = 2;
var dy = -2;
var paddleHeight = 10;
var paddleWidth = 75;
var paddleX = (canvas.width-paddleWidth)/2;
var rightPressed = false;
var leftPressed = false;
var brickRowCount = 10;
var brickColumnCount = 6;
var brickWidth = 75;
var brickHeight = 20;
var brickPadding = 10;
var brickOffsetTop = 30;
var brickOffsetLeft = 30;
var score = 0;
var lives = 3;

var bricks = [];
for(c=0; c<brickColumnCount; c++) {
    bricks[c] = [];
    for(r=0; r<brickRowCount; r++) {
        bricks[c][r] = { x: 0, y: 0, status: 1 };
    }
}

document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);
document.addEventListener("mousemove", mouseMoveHandler, false);

function keyDownHandler(e) {
    if(e.keyCode == 39) {
        rightPressed = true;
    }
    else if(e.keyCode == 37) {
        leftPressed = true;
    }
}
function keyUpHandler(e) {
    if(e.keyCode == 39) {
        rightPressed = false;
    }
    else if(e.keyCode == 37) {
        leftPressed = false;
    }
}
function mouseMoveHandler(e) {
    var relativeX = e.clientX - canvas.offsetLeft;
    if(relativeX > 0 && relativeX < canvas.width) {
        paddleX = relativeX - paddleWidth/2;
    }
}
function collisionDetection() {
    for(c=0; c<brickColumnCount; c++) {
        for(r=0; r<brickRowCount; r++) {
            var b = bricks[c][r];
            if(b.status == 1) {
                if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight) {
                    dy = -dy;
                    b.status = 0;
                    score++;
                    if(score == brickRowCount*brickColumnCount) {
                        alert("YOU WIN, CONGRATS!");
                        newpoints();
                    }
                }
            }
        }
    }
}

function drawBall() {
    ctx.beginPath();
    ctx.arc(x, y, ballRadius, 0, Math.PI*2);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
function drawBricks() {
    for(c=0; c<brickColumnCount; c++) {
        for(r=0; r<brickRowCount; r++) {
            if(bricks[c][r].status == 1) {
                var brickX = (r*(brickWidth+brickPadding))+brickOffsetLeft;
                var brickY = (c*(brickHeight+brickPadding))+brickOffsetTop;
                bricks[c][r].x = brickX;
                bricks[c][r].y = brickY;
                ctx.beginPath();
                ctx.rect(brickX, brickY, brickWidth, brickHeight);
                ctx.fillStyle = "#0095DD";
                ctx.fill();
                ctx.closePath();
            }
        }
    }
}
function drawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score: "+score, 8, 20);
}
function drawLives() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Lives: "+lives, canvas.width-65, 20);
}
var once=true;
var once3=true;
function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBricks();
    drawBall();
    drawPaddle();
    drawScore();
    drawLives();
    collisionDetection();
    
    if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
        dx = -dx;
    }
    if(y + dy < ballRadius) {
        dy = -dy;
    }
    else if(y + dy > canvas.height-ballRadius) {
        if(x > paddleX && x < paddleX + paddleWidth) {
            dy = -dy;
        }
        else {
            lives--;
            once=true;
            once3=true;
            if(!lives) {
                window.alert("Gameover!將更新最高分");
                newpoints();
            }
            else {
                x = canvas.width/2;
                y = canvas.height-30;
                dx = 3;
                dy = -3;
                paddleX = (canvas.width-paddleWidth)/2;
            }
        }
    }
    
    if(rightPressed && paddleX < canvas.width-paddleWidth) {
        paddleX += 7;
    }
    else if(leftPressed && paddleX > 0) {
        paddleX -= 7;
    }
    if(score>=10 && once==true){dx*=2;dy*=2;once=false;}
    else if(score>=30 && once3==true){dx*=2;dy*=2;once3=false;}
    x += dx;
    y += dy;
    requestAnimationFrame(draw);
}

draw();
function newpoints() {
			//使用 ajax 送出
			$.ajax({
				type: "POST",
				url: "breakoutpoints.php",
				data: {
					score: score //
				},
				dataType: 'html' //設定該網頁回應的會是 html 格式
			}).done(function(data) {
                
                   window.alert("將回你的排行榜");
                   window.location.href='self.php';
                    
			}).fail(function(jqXHR, textStatus, errorThrown) {
				//失敗的時候
				alert("有錯誤產生，請看 console log");
				console.log(jqXHR.responseText);
			});
    }
</script>

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