<?php
	//假設的有效會員帳號
	require_once 'db.php';
$score=$_POST['score'];

$id=$_SESSION['Userid'];
$previous_score=$_SESSION['kirby'];
if($previous_score > $score){
    $score=$previous_score;
}
$_SESSION['kirby']=$score;
$sql="UPDATE `member` SET `kirby`='{$score}' WHERE `id`='{$id}'";

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