<?php
	include_once "fun.php";
	session_start();
	unset($_SESSION["pkUser"]);
	msg(1, "退出成功！", "index.php");
?>