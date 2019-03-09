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
<canvas id="myCanvas" width="960" height="480" style="border:3px solid #000000;">
<img id="kirby" src="images/fly.png" width="80" height="80">
    
<img id="fire" src="images/fire.png" width="80" height="80">
<img id="fireleft" src="images/fireleft.png" width="80" height="80">
<img id="sword" src="images/sword.png" width="80" height="80">
<img id="swordleft" src="images/swordleft.png" width="80" height="80">

<img id="floor" src="images/floor.png" width="80" height="80">
<img id="air" src="images/air.png" width="80" height="80">
<img id="door" src="images/door.png" width="80" height="80">

<img id="magma" src="images/lava.gif" width="80" height="80">
<img id="firemonster" src="images/firemonster.png" width="80" height="80">
<img id="swordmonster" src="images/swordmonster.png" width="80" height="80">
<img id="start" src="images/start.jpg" width="960" height="480">
    
<img id="fireEffect" src="images/fireEffect.png" width="80" height="80">
<img id="fireEffectleft" src="images/fireEffectleft.png" width="80" height="80">
<img id="SwordEffect" src="images/SwordEffect.png" width="80" height="80">
<img id="SwordEffectleft" src="images/SwordEffectleft.png" width="80" height="80">
<img id="stage1" src="images/stage1.png" width="960" height="480">
<img id="stage2" src="images/stage2.png" width="960" height="480">
<img id="stage3" src="images/stage3.png" width="960" height="480">
<img id="win" src="images/win.jpg" width="960" height="480">
<img id="gameover" src="images/gameover.png" width="960" height="480">
</canvas>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
var kirby_image=document.getElementById("kirby");
var rightPressed = false;
var leftPressed = false;
var upPressed = false;
var isright = true;
var isleft = false;
var attackPressed = false;
var kirby_x=0;
var kirby_y=240;
var kirby_hp=3;
var JumpingUp = false;
var JumpingDown = false;
var jumpheight=100;
var map1=[0,0,0,0,0,0,0,0,0,0,0,0,
         0,0,0,0,0,0,1,1,0,0,0,0,
         0,0,0,0,1,1,2,2,1,0,0,0,
         1,1,1,1,2,2,2,2,2,1,1,4,
         2,2,2,2,2,2,2,2,2,2,2,2,
         3,3,3,3,3,3,3,3,3,3,3,3];
var map2=[0,0,0,0,0,0,0,0,0,0,0,0,
         0,0,0,0,0,0,1,1,1,2,0,0,
         0,0,1,1,0,1,2,2,2,2,0,0,
         1,1,2,2,1,1,2,2,2,2,1,4,
         2,2,2,2,2,2,2,2,2,2,1,1,
         3,3,3,3,3,3,3,3,3,3,3,3];
var map3=[0,0,0,0,0,0,0,0,0,0,0,0,
         0,0,0,1,0,1,1,1,0,0,1,0,
         0,1,1,2,2,2,2,2,0,1,0,0,
         1,2,2,2,2,2,2,2,2,2,0,4,
         2,2,2,2,2,2,2,2,2,2,1,1,
         3,3,3,3,3,3,3,3,3,3,3,3];
var gravity=true;
var isGround=true;
var isJumpingUp=false;
var isJumpingDown=false;
var godown=false;
var stage=1;
var playing=false;
var go=false;
var score=0;
//怪物
var fire_m1={
    hp: 5,
    x: 0,
    y: 0,
};
var fire_m2={
    hp: 5,
    x: 0,
    y: 0,
};
var sword_m1={
    hp: 5,
    x: 0,
    y: 0,
};
var sword_m2={
    hp: 5,
    x: 0,
    y: 0,
};

    

var kirby_state="origin";
    
document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);   


function keyDownHandler(e) {
    if(playing){
        if(e.keyCode == 39) {
        switch(kirby_state)
        {
            case "origin":
                kirby_image.src="images/fly.png";
                break;
            case "fire":
                kirby_image.src="images/fire.png";
                break;
            case "sword":
                kirby_image.src="images/sword.png";
                break;
        }
        rightPressed = true;
        isright=true;
        isleft=false;       
        }
        else if(e.keyCode == 37) {
        switch(kirby_state)
        {
            case "origin":
                kirby_image.src="images/flyleft.png";
                break;
            case "fire":
                kirby_image.src="images/fireleft.png";
                break;
            case "sword":
                kirby_image.src="images/swordleft.png";
                break;
        }
        leftPressed = true;
        isright=false;
        isleft=true;
        }
        else if(e.keyCode == 32 && !gravity && !isJumpingDown) {
        upPressed = true;
        isJumpingUp = true;
        }
        else if(e.keyCode == 17) {
        attackPressed = true;
        }
        else if(e.keyCode == 16){
        kirby_state ='origin';
        }
        else if(e.keyCode == 38){
            if(kirby_x>=880 && kirby_y<=920  &&  kirby_y>=240 && kirby_y<=300){
                stage+=1;
                kirby_x=0;
                kirby_y=240;
                fire_m1.hp=5;
                fire_m2.hp=5;
                sword_m1.hp=5;
                sword_m2.hp=5;
                go=false;
                score+=100;
            }
        }
    }
    else{
            if(e.keyCode == 32){
            playing=true;
            }
    } 
}
function keyUpHandler(e) {
    if(e.keyCode == 39) {
        rightPressed = false;
    }
    else if(e.keyCode == 37) {
        leftPressed = false;
    }
    else if(e.keyCode == 17) {
        switch(kirby_state)
        {
            case "origin":
                if(isright)
                    {
                        kirby_image.src="images/fly.png";
                    }
                else
                    {
                        kirby_image.src="images/flyleft.png";
                    }
                break;
        }
        attackPressed = false;
    }
}
function Attack(m){
    var yes;
    var distance=1000;
    if(kirby_x > m.x && isleft)
    {
        yes=1;
        distance = kirby_x - m.x;
    }
    else if(kirby_x <= m.x && isright)
    {
        distance = m.x - kirby_x;
        yes=0;
    }
    if(distance<=100 && kirby_y >= m.y-50 && kirby_y <= m.y+50)
    {
        while(distance>0)
        {
            if(yes==1)
            {
                m.x += 1;
            }
            else
            {
                m.x -= 1;
            }
            distance -= 1;
        }
        m.hp = 0;
        score+=50;
        return true;
    }
    return false;
}
function isAttacking(){
    if(attackPressed){
        switch(kirby_state)
        {
            case "origin":
                if(isright)
                    {
                        kirby_image.src="images/eat.png";
                    }
                else
                    {
                        kirby_image.src="images/eatleft.png";
                    }
                if(Attack(fire_m1) || Attack(fire_m2))
                    {
                        kirby_state="fire";
                        
                    }
                else if(Attack(sword_m1) || Attack(sword_m2))
                    {
                        kirby_state="sword";
                        
                    }
                break;
            case "fire":
                if(isright)
                    {
                        ctx.drawImage(fireEffect,kirby_x+60,kirby_y);
                    }
                else
                    {
                        ctx.drawImage(fireEffectleft,kirby_x-60,kirby_y);
                    }
                Attack(fire_m1);
                Attack(fire_m2);
                Attack(sword_m1);
                Attack(sword_m2);
                break;
            case "sword":
                if(isright)
                    {
                        ctx.drawImage(SwordEffect,kirby_x+60,kirby_y);
                    }
                else
                    {
                        ctx.drawImage(SwordEffectleft,kirby_x-60,kirby_y);
                    }
                Attack(fire_m1);
                Attack(fire_m2);
                Attack(sword_m1);
                Attack(sword_m2);  
                break;
        }
    }
}
function drawKirby() {

    switch(kirby_state)
    {
        case "origin":
            ctx.drawImage(kirby,kirby_x,kirby_y);
            break;
        case "fire":
            if(isright){
                    ctx.drawImage(fire,kirby_x,kirby_y);
                }
                else{
                    ctx.drawImage(fireleft,kirby_x,kirby_y);
                }
            break;
        case "sword":
            if(isright){
                    ctx.drawImage(sword,kirby_x,kirby_y);
                }
                else{
                    ctx.drawImage(swordleft,kirby_x,kirby_y);
                }
            break;
    }
}
function drawMonster(){
    if(stage==1){
        if(fire_m1.hp>0){
            fire_m1.x=720;
            fire_m1.y=240;
            ctx.drawImage(firemonster,fire_m1.x,fire_m1.y);
        }
        else{
            fire_m1.x=0;
            fire_m1.y=0;
        }
        if(sword_m1.hp>0){
            sword_m1.x=320;
            sword_m1.y=160;
            ctx.drawImage(swordmonster,sword_m1.x,sword_m1.y);
        }
        else{
            sword_m1.x=0;
            sword_m1.y=0;
        }
    }
    else if(stage==2){
        if(fire_m1.hp>0){
            fire_m1.x=480;
            fire_m1.y=80;
            ctx.drawImage(firemonster,fire_m1.x,fire_m1.y);
        }
        else{
            fire_m1.x=0;
            fire_m1.y=0;
        }
        if(fire_m2.hp>0){
            fire_m2.x=160;
            fire_m2.y=160;
            ctx.drawImage(firemonster,fire_m2.x,fire_m2.y);
        }
        else{
            fire_m2.x=0;
            fire_m2.y=0;
        }
        if(sword_m1.hp>0){
            sword_m1.x=640;
            sword_m1.y=80;
            ctx.drawImage(swordmonster,sword_m1.x,sword_m1.y);
        }
        else{
            sword_m1.x=0;
            sword_m1.y=0;
        }
    }
    else if(stage==3){
        if(fire_m1.hp>0){
            fire_m1.x=400;
            fire_m1.y=80;
            ctx.drawImage(firemonster,fire_m1.x,fire_m1.y);
        }
        else{
            fire_m1.x=0;
            fire_m1.y=0;
        }
        if(fire_m2.hp>0){
            fire_m2.x=160;
            fire_m2.y=160;
            ctx.drawImage(firemonster,fire_m2.x,fire_m2.y);
        }
        else{
            fire_m2.x=0;
            fire_m2.y=0;
        }
        if(sword_m1.hp>0){
            sword_m1.x=560;
            sword_m1.y=80;
            ctx.drawImage(swordmonster,sword_m1.x,sword_m1.y);
        }
        else{
            sword_m1.x=0;
            sword_m1.y=0;
        }
        if(sword_m2.hp>0){
            sword_m2.x=720;
            sword_m2.y=160;
            ctx.drawImage(swordmonster,sword_m2.x,sword_m2.y);
        }
        else{
            sword_m2.x=0;
            sword_m2.y=0;
        }
    }
}
function drawfloor_air_door(){
    var index=0;
    var map;
    switch(stage)
        {
            case 1:
                map=map1;
                break;
            case 2:
                map=map2;
                break;
            case 3:
                map=map3;
                break;
            case 4:
                ctx.drawImage(win,0,0);
                score+=200;
                while(kirby_hp>0){
                    score+=10;
                    kirby_hp-=1;
                }
                window.alert("挑戰成功!將更新最高分");
                newpoints();
                break;
        }
    for (var i=0;i<480;i+=80)
        {
            for (var j=0;j<960;j+=80)
                {
                    if(map[index]==1){
                        ctx.drawImage(floor,j,i);
                    }
                    else if(map[index]==0){
                        ctx.drawImage(air,j,i);
                    }
                    else if(map[index]==2){
                        ctx.drawImage(air,j,i);
                    }
                    else if(map[index]==4){
                        ctx.drawImage(door,j,i);
                    }
                    else if(map[index]==3){
                        ctx.drawImage(magma,j,i);
                    }
                    index+=1;
                }
        }
}
function gravity_pull(kirby_x,kirby_y){
    var map;
    switch(stage)
        {
            case 1:
                map=map1;
                break;
            case 2:
                map=map2;
                break;
            case 3:
                map=map3;
                break;
        }
    var index=0;
    for (var i=0;i<480;i+=80)
        {
            for (var j=0;j<960;j+=80)
                {
                    if(kirby_x>=j && kirby_x<=j+40 && kirby_y>=i && kirby_y<=i+40)
                        {
                          if(map[index]==1){
                            gravity=false;
                            isGround=true;
                            }
                          else if(map[index]==0){
                            gravity=false;
                            isGround=false;
                              
                            }
                            else if(map[index]==2){
                            gravity=true;
                            isGround=false;
                            kirby_y+=1;
                            }
                          else if(map[index]==4){
                            gravity=false;
                            isGround=true;
                         }
                          else if(map[index]==3){
                            gravity=true;
                            isGround=false;
                            kirby_y+=1;
                            }   
                        }
                    index+=1;
                }
        }
}
var count=0;
function kirby_hurt(m){
    var distance;
    if(kirby_x > m.x)
    {
        distance = kirby_x - m.x;
    }
    else
    {
        distance = m.x - kirby_x;
    }
    if(count<=1000)
    {
        count+=1;
    }
    else
    {
        if( distance<=50 && kirby_y >= m.y-10 && kirby_y <= m.y+10)
        {
            if(m.hp>0)
            {
                kirby_hp-=1;
                count=0;
            }
        }
    }
}
function die(){
    if(kirby_y>=480){
        kirby_hp=0;
    }
}
function JumpUp(){
    kirby_y-=1;
}
function JumpDown(){
    if(gravity || isGround)
    {
        return false;
    }
    kirby_y+=1;
    return true;
}
function isfloor(){
    if(gravity_pull(kirby_x,kirby_y))
            {
                if(isGround)
                {
                    gravity=false;
                    godown=false;
                }
            }

            if(godown || gravity)
            {
                if(!isGround)
                {
                    kirby_y+=1;
                }
            }
}
function jump(){
    if(isJumpingUp)
            {
                JumpUp();
                jumpheight-=1;
                if(jumpheight<=0)
                {
                    isJumpingUp = false;
                    jumpheight=100;
                    isJumpingDown = true;
                }
            }
            if(isJumpingDown)
            {
                if(JumpDown())
                {
                    jumpheight-=1;
                }
                else if(jumpheight<=0)
                {
                    jumpheight=100;
                    isJumpingDown = false;
                }
                else
                {
                    isJumpingDown = false;
                    jumpheight=100;
                }

            }
}
function drawScore() {
    ctx.font = "20px Arial";
    ctx.fillStyle = "red";
    ctx.fillText("Score: "+score, 8, 20);
}
function drawLives() {
    ctx.font = "20px Arial";
    ctx.fillStyle = "red";
    ctx.fillText("Hp: "+kirby_hp, canvas.width-65, 20);
}
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
var delay;
function draw(){
    if(!playing)
    {
        ctx.drawImage(start,0,0);
        requestAnimationFrame(draw);
    }
    else if(stage==1 && !go){
        ctx.drawImage(stage1,0,0);
        go=true;
        requestAnimationFrame(draw);
        delay=true
    }
    else if(stage==2 && !go){
        ctx.drawImage(stage2,0,0);
        go=true;
        requestAnimationFrame(draw);
        delay=true
    }
    else if(stage==3 && !go){
        ctx.drawImage(stage3,0,0);
        go=true;
        requestAnimationFrame(draw);
        delay=true
    }
    else if(kirby_hp<=0){
        ctx.drawImage(gameover,0,0);
        window.alert("Gameover!將更新最高分");
        newpoints();
    }
    else{
        if(delay){
            sleep(3000);
            delay=false;
        }
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawfloor_air_door();
        drawScore();
        drawLives();
        drawMonster();
        drawKirby();
        die();
        
        kirby_hurt(sword_m1);
        kirby_hurt(sword_m2);
        kirby_hurt(fire_m1);
        kirby_hurt(fire_m2);
        if(rightPressed && kirby_x < canvas.width+80) {
            kirby_x += 1;
        }
        else if(leftPressed && kirby_x > 0) {
            kirby_x -= 1;
        }
    
        if(upPressed && kirby_y <= canvas.height){
            jump();
        }
        isfloor();
    
        isAttacking();

        requestAnimationFrame(draw);
    }
}
draw();
function newpoints() {
			//使用 ajax 送出
			$.ajax({
				type: "POST",
				url: "kirbypoints.php",
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