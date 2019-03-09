<?php
	//假設的有效會員帳號
	require_once 'db.php';
$score=$_POST['score'];

$id=$_SESSION['Userid'];
$previous_score=$_SESSION['breakout'];
if($previous_score > $score){
    $score=$previous_score;
}
$_SESSION['breakout']=$score;
$sql="UPDATE `member` SET `breakout`='{$score}' WHERE `id`='{$id}'";

$result=mysqli_query($_SESSION['link'], $sql);

if($result)
	{
		if(mysqli_affected_rows($_SESSION['link']) == 1)
        {

        }
	}
	else 
	{
		echo 'no';
	}

?>  