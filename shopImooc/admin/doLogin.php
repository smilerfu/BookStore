<?php
require_once '../lib/mysql.func.php';
require_once '../core/admin.inc.php';
require_once '../lib/common.func.php';
startSessionIfSOff();
// foreach ($_POST as $key=>$val)
// {
// echo $key."=".$val."<br>";
// }

$username = $_POST['username'];
$password = md5($_POST['password']);
$verify = $_POST['verify'];
$verify_session = $_SESSION['verify'];

if(isset($_POST['autoFlag']))
{
	$autoFlag = $_POST['autoFlag'];
	echo "$autoFlag";
}
else
{
	$autoFlag = "";
}

if(true)//$verify == $verify_session)
{
	$sql = "SELECT * from imooc_admin where username = '{$username}' and password = '{$password}'";
	$row = checkAdmin($sql);
	//var_dump($row);
	if($row)
	{
		//如果选了一周自动登录
		if($autoFlag)
		{
			setcookie("adminId", $row['id'], time()+7*24*3600);
			setcookie("adminName", $row['username'], time()+7*24*3600);
		}
		echo "验证成功";
		$_SESSION['adminName'] = $row['username'];
		$_SESSION['adminId'] = $row['id'];
		alertMes("登录成功", "index.php");
	}
	else 
	{
		alertMes("用户名或者密码错误", "login.php");
	}
}
else
{
	alertMes("验证码错误", "login.php");
}