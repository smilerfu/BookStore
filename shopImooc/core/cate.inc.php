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

function getCateByID($id)
{
	$sql="select id,cName from imooc_cate where id = '{$id}'";
	return fetchOne($sql);
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
		$mes="修改分类成功！<br/><a href='listCate.php'>查看分类</a>";
	}
	else
	{
		$mes="修改分类失败！<br/><a href='listCate.php'>重新修改</a>";
	}
	return $mes;
}

function delCate($id)
{
	if(delete("imooc_cate", "id={$id}"))
	{
		$mes="分类删除成功！<br/><a href='listCate.php'>查看分类</a>";
	}
	else
	{
		$mes="分类删除失败！<br/><a href='listCate.php'>重新操作</a>";
	}
	return $mes;
}

/**
 * 得到所有分类
 * @return array
 */
function getAllCate()
{
	$sql = "select id,cName from imooc_cate";
	$rows = fetchAll($sql);
	return $rows;
}
