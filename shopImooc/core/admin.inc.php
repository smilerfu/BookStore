<?php

require_once '../lib/mysql.func.php';
require_once '../lib/common.func.php';
startSessionIfSOff();

/**
 * 检查是否是管理员
 * @param string $sql
 * @return array:
 */
function checkAdmin($sql) {
	connect();
	return fetchOne($sql);
}

/**
 * 检查管理员是否已经登录
 */
function checkLogined() {
	//if((!isset($_SESSION['adminId']) || $_SESSION['adminId'] == "") && (!isset($_COOKIE['adminId']) || $_COOKIE['adminId'] == ""))
	if(
		(!isset($_SESSION['adminId']) || $_SESSION['adminId'] == "") && 
		(!isset($_COOKIE['adminId']) || $_COOKIE['adminId'] == "")
	)
	{
		alertMes("请先登录", "login.php");
	}
}

function addAdmin()
{
	connect();
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	if(insert("imooc_admin", $arr))
	{
		$mes = "添加成功！<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
	}
	else
	{
		$mes = "添加失败！<br/><a href='addAdmin.php'>重新添加</a>";
	}
	return $mes;
}

/**
 * 管理员退出
 */
function logout()
{
	$_SESSION = array();
	if(isset($_COOKIE[session_name()]))
	{
		setcookie(session_name(), "", time()-1); //设置cookie value为"",时间为当前时间-1秒，从而使cookie失效
	}
	if(isset($_COOKIE['adminId']))
	{
		setcookie("adminId", "", time()-1);
	}
	if(isset($_COOKIE['adminName']))
	{
		setcookie("adminName", "", time()-1);
	}
	session_destroy();
	header("location:login.php");
}