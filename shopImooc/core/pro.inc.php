<?php
require_once '../lib/upload.func.php';
require_once '../lib/image.func.php';
require_once '../lib/mysql.func.php';
require_once 'album.inc.php';


function addPro() 
{
	$arr = $_POST;
	
	$arr['pubTime'] = time();
	$uploadDir = "../test/uploads/upload";
	$uploadPath = $uploadDir . "/";
	$thumbPath = "../test/uploads/";
	$uploadFilesInfo=uploadFiles($_FILES, $uploadDir);
	if(is_array($uploadFilesInfo) && $uploadFilesInfo)
	{
		foreach ($uploadFilesInfo as $key=>$singleFile)
		{
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_50/".$singleFile['name'], 50, 50);
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_220/".$singleFile['name'], 220, 220);
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_350/".$singleFile['name'], 350, 350);
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_800/".$singleFile['name'], 800, 800);
		}
	}
	$res = insert("imooc_pro", $arr);
	$pid = getInsertID();
	if($res && $pid)
	{
		foreach ($uploadFilesInfo as $singleFile)
		{
			$arrAlbum['pid'] = $pid;
			$arrAlbum['albumPath'] = $singleFile['name'];
			addAlbum($arrAlbum);
		}
		$mes = "<p>添加成功</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	else 
	{
		foreach ($uploadFilesInfo as $singleFile)
		{
			$delImagePath800 = $thumbPath."image_800/".$singleFile['name'];
			if (file_exists($delImagePath800))
			{
				unlink($delImagePath800);
			}
			
			$delImagePath50 = $thumbPath."image_50/".$singleFile['name'];
			if (file_exists($delImagePath50))
			{
				unlink($delImagePath50);
			}
			
			$delImagePath220 = $thumbPath."image_220/".$singleFile['name'];
			if (file_exists($delImagePath220))
			{
				unlink($delImagePath220);
			}
			
			$delImagePath350 = $thumbPath."image_350/".$singleFile['name'];
			if (file_exists($delImagePath350))
			{
				unlink($delImagePath350);
			}
			
		}
		$mes = "<p>添加失败</p><a href='addPro.php' target='mainFrame'>重新添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	return $mes;
}


function getTotalProPage($pageSize, $where=null, $orderBy=null)
{
	$sql = "select p.id, p.pName, p.pSn, p.pNum, p.mPrice, p.iPrice, p.pDesc, p.pubTime, p.isShow, p.isHot, c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id {$where} {$orderBy}";
	
	$totalRows = getResultNum($sql);
	$totalPage = ceil($totalRows/$pageSize);
	return $totalPage;
}

function getAllProByPage($page, $totalPage, $pageSize, $where=null, $orderBy=null)
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
	if($orderBy)
	{
		$orderBy = $orderBy.", p.id asc";
	}
	else 
	{
		$orderBy = "order by p.id asc";
	}
	$sql="select p.id, p.pName, p.pSn, p.pNum, p.mPrice, p.iPrice, p.pDesc, p.pubTime, p.isShow, p.isHot, c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id {$where} {$orderBy} limit {$offset},{$pageSize}";
	$rows = fetchAll($sql);
	return $rows;
}

function getAllProByAdmin() {
	$sql = "select p.id, p.pName, p.pSn, p.pNum, p.mPrice, p.iPrice, p.pDesc, p.pubTime, p.isShow, p.isHot, c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id";
	$rows = fetchAll($sql);
	return $rows;
}


function getAllImgByProId($pID) {
	$sql = "select a.albumPath from imooc_album a where pid = {$pID}";
	$rows = fetchAll($sql);
	return $rows;
}

function getProById($pID) {
	$sql = "select p.id, p.pName, p.pSn, p.pNum, p.mPrice, p.iPrice, p.pDesc, p.pubTime, p.isShow, p.isHot, c.cName, p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.id = {$pID}";
	$row = fetchOne($sql);
	return $row;
}


function editPro($id) {
	$arr = $_POST;
	$uploadDir = "../test/uploads/upload";
	$uploadPath = $uploadDir . "/";
	$thumbPath = "../test/uploads/";
	$uploadFilesInfo=uploadFiles($_FILES, $uploadDir);
	if(is_array($uploadFilesInfo) && $uploadFilesInfo)
	{
		foreach ($uploadFilesInfo as $key=>$singleFile)
		{
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_50/".$singleFile['name'], 50, 50);
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_220/".$singleFile['name'], 220, 220);
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_350/".$singleFile['name'], 350, 350);
			thumb($uploadPath.$singleFile['name'], $thumbPath."image_800/".$singleFile['name'], 800, 800);
		}
	}
	$where = "id={$id}";
	$res = update("imooc_pro", $arr, $where);
	$pid = $id;
	if($res && $pid)
	{
		foreach ($uploadFilesInfo as $singleFile)
		{
			$arrAlbum['pid'] = $pid;
			$arrAlbum['albumPath'] = $singleFile['name'];
			addAlbum($arrAlbum);
		}
		$mes = "<p>编辑成功</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	else
	{
		foreach ($uploadFilesInfo as $singleFile)
		{
			delImgFile($thumbPath."image_800/".$singleFile['name']);
			delImgFile($thumbPath."image_50/".$singleFile['name']);
			delImgFile($thumbPath."image_220/".$singleFile['name']);
			delImgFile($thumbPath."image_350/".$singleFile['name']);
		}
		$mes = "<p>编辑失败</p><a href='editPro.php' target='mainFrame'>重新编辑</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	return $mes;
}

function delImgFile($imgPath)
{
	if (file_exists($imgPath))
	{
		unlink($imgPath);
	}
}


function delPro($id)
{
	//删除数据库商品
	$wherePro = "id={$id}";
	$delPro = delete("imooc_pro", $wherePro);
	
	//删除图像文件
	$proImgs = getAllImgByProId($id);
	
	if($proImgs)
	{
		$uploadDir = "../test/uploads/upload";
		$uploadPath = $uploadDir . "/";
		$thumbPath = "../test/uploads/";
		foreach ($proImgs as $proImg)
		{
			delImgFile($uploadPath.$proImg['albumPath']);
			delImgFile($thumbPath."image_800/".$proImg['albumPath']);
			delImgFile($thumbPath."image_50/".$proImg['albumPath']);
			delImgFile($thumbPath."image_220/".$proImg['albumPath']);
			delImgFile($thumbPath."image_350/".$proImg['albumPath']);
		}
	}
	
	//删除数据库对应图片路径信息
	$whereAlbum = "pid={$id}";
	$delAlbum = delete("imooc_album", $whereAlbum);
	
	if($delPro && ($proImgs && $delAlbum || !$proImgs)) //成功删除商品 &&(有图，成功删除图  ||  没有图)
	{
		$mes="删除成功!<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	else 
	{
		$mes="删除失败!<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	return $mes;
}








