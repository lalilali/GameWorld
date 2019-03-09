<?php
	//假設的有效會員帳號
	require_once 'db.php';
$score=$_POST['score'];

$id=$_SESSION['Userid'];
$previous_score=$_SESSION['tetris'];
if($previous_score > $score){
    $score=$previous_score;
}
$sql="UPDATE `member` SET `tetris`='{$score}' WHERE `id`='{$id}'";
$_SESSION['tetris']=$score;
$result=mysqli_query($_SESSION['link'], $sql);

if($result)
	{
		if(mysqli_affected_rows($_SESSION['link']) == 1)
        {
            echo "總分";
            echo($score);
        }
	}
	else 
	{
		echo 'no';
	}
?>  