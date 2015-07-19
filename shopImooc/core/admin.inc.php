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

/**
 * 添加管理员
 * @return string
 */
function addAdmin()
{
	$arr=$_POST;
	$rows = fetchOne("select count(id) as countNum from imooc_admin");
	$arr['id'] = (int)$rows['countNum'] + 1;
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
 * 获取所有管理员
 * @return Array
 */
function getAllAdmin($where=null)
{
	$sql = "select id, username, email from imooc_admin";
	$rows=fetchAll($sql);
	//var_dump($rows);
	return $rows;
}

function getTotalPage($pageSize)
{
	$sql = "select * from imooc_admin";
	$totalRows = getResultNum($sql);
	$totalPage = ceil($totalRows/$pageSize);
	return $totalPage;
}

function getAdminByPage($page, $totalPage, $pageSize)
{
	if($page<1 || $page==null || !is_numeric($page))
	{
		$page = 1;
	}
	if($page > $totalPage)
	{
		$page = $totalPage;
	}
	
	$offset=($page-1)*$pageSize;
	
	$sql="select id,username,email from imooc_admin order by id limit {$offset},{$pageSize}";
	$rows = fetchAll($sql);
	return $rows;
}

/**
 * 编辑管理员
 * @param int $id
 * @return string
 */
function editAdmin($id)
{
	$arr=$_POST;
	$arr['password'] = md5($_POST['password']);
	if(update("imooc_admin", $arr, "id={$id}"))
	{
		$mes="编辑成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
	}
	else
	{
		$mes="编辑失败！<br/><a href='listAdmin.php'>请重新修改</a>";
	}
	return $mes;
}

/**
 * 删除管理员
 * @param int $id
 * @return string
 */
function delAdmin($id)
{
	if(delete("imooc_admin", "id={$id}"))
	{
		$mes="删除成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
	}
	else
	{
		$mes="删除失败！<br/><a href='listAdmin.php'>查看管理员列表</a>";
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