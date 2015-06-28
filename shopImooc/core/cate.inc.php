<?php
require_once '../lib/mysql.func.php';

function addCate()
{
	$arr=$_POST;
	if(insert("imooc_cate", $arr))
	{
		$mes = "分类添加成功!<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类</a>";
	}
	else
	{
		$mes = "分类添加失败!<br/><a href='addCate.php'>重新添加</a>|<a href='listCate.php'>查看分类</a>";
	}
	return $mes;
}

function getTotalCatePage($pageSize)
{
	$sql = "select * from imooc_cate";
	$totalRows = getResultNum($sql);
	$totalPage = ceil($totalRows/$pageSize);
	return $totalPage;
}

function getAllCateByPage($page, $totalPage, $pageSize)
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
	
	$sql="select id,cName from imooc_cate order by id asc limit {$offset},{$pageSize}";
	$rows = fetchAll($sql);
	return $rows;
}

function editCate($id)
{
	$arr=$_POST;
	if(update("imooc_cate", $arr, "id={$id}"))
	{
		$mes="编辑成功！<br/><a href='listCate.php'>查看分类列表</a>";
	}
	else
	{
		$mes="编辑失败！<br/><a href='listCate.php'>请重新修改</a>";
	}
	return $mes;
}

function delCate($id)
{
	if(delete("imooc_cate", "id={$id}"))
	{
		$mes="删除成功！<br/><a href='listCate.php'>查看分类列表</a>";
	}
	else
	{
		$mes="删除失败！<br/><a href='listCate.php'>查看分类列表</a>";
	}
	return $mes;
}

