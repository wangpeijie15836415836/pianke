<?php 
	include_once "fun.php";
	$w_id = $_POST["w_id"];
	$user_id = $_POST["user_id"];
	$pdo = mysqlInit("mysql", "localhost", "pk", "root", "");
	if($w_id){
		qita($pdo, $w_id, "zan");
		$result = $pdo->exec("insert into qita (zan, user_id, works_id) values (1, {$user_id}, {$w_id})");
	}
	echo $result;
 ?>