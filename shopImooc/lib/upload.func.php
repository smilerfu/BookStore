<?php

require_once(dirname(__FILE__).'/../lib/string.func.php');

function buildInfo($filesinfo)
{
	$files = array();
	$i = 0;
	foreach ($filesinfo as $v)
	{
		if(is_string($v['name']))
		{
			//单文件上传
			$files[$i] = $v;
			$i++;
		}
		else
		{
			//多文件上传，$v是一个数组
			foreach ($v['name'] as $key=>$val)
			{
				$files[$i] = array();
				$files[$i]['name'] = $val;
				$files[$i]['size'] = $v['size'][$key];
				$files[$i]['tmp_name'] = $v['tmp_name'][$key];
				$files[$i]['error'] = $v['error'][$key];
				$files[$i]['type'] = $v['type'][$key];
				$i++;
			}
		}
		
	}
	return $files;
}

function uploadFiles($filesArray, $dirname = "uploads", $allowExt = array('gif', 'jpeg', 'jpg', 'png', 'wbmp'), $maxSize = 1048576, $imgFlag = true)
{
	$files = buildInfo($filesArray);
	$mes = "";
	$successFiles = array();
	$i = 0;
	foreach ($files as $fileInfo)
	{
		$uploadResult = uploadFile($fileInfo, $dirname, $allowExt, $maxSize, $imgFlag);
		//$mes = $mes . $uploadResult['message'] . "</br>";
		$success = $uploadResult['success'];
		
		if($success)
		{
			$successFiles[$i] = $uploadResult['file'];
			$i++;
		}
	}
	return $successFiles;
}

/**
 * 
 * @param array $fileInfo  待上传的文件信息，keys => (name, type, tmp_name, error, size)
 * @param string $dirname  文件保存路径
 * @param array $allowExt  允许上传的文件类型 (默认:'gif', 'jpeg', 'jpg', 'png', 'wbmp')
 * @param int $maxSize     允许上传的文件大小 (默认:1M)
 * @param bool $imgFlag    判断是否是图片类型
 * @return array
 */
function uploadFile($fileInfo, $dirname, $allowExt, $maxSize, $imgFlag)
{
	$fileName = $fileInfo['name'];
	$type = $fileInfo['type'];
	$tmp_name = $fileInfo['tmp_name'];
	$error = $fileInfo['error'];
	$size = $fileInfo['size'];
	$file = array();
	$file['name'] = $fileName;
	$success = false;
	switch ($error) {
		case UPLOAD_ERR_OK:
			$ext = getExt($fileName); //获取文件扩展名
			//限制上传文件类型
			if(!in_array($ext, $allowExt))
			{
				$mes = "非法文件类型";
				break;
			}
			//限制上传文件大小
			if($size > $maxSize)
			{
				$mes="文件过大";
				break;
			}
			//如何验证图片是否是一个真正的图片类型
			if($imgFlag)
			{
				$info = getimagesize($tmp_name); //验证文件是否是图片类型-->是:返回的是一个数组， 否:返回一个false
				if(!$info)
				{
					$mes="不是真正的图片类型";
					break;
				}
			}
			//需要判断下文件是否是通过HTTP POST 方式上传来的
			if(!is_uploaded_file($tmp_name))
			{
				$mes = "文件不是通过HTTP POST 方式上传来的";
				break;
			}
			
			//判断文件路径是否存在，不存在则创建
			if(!file_exists($dirname))
			{
				if(!mkdir($dirname, 0777, true))
				{
					$mes = "创建文件存放目录失败";
					break;
				}
			}
			$fileUniName = getUniName() . "." . $ext;
			$destination = $dirname."/".$fileUniName;
			//移动文件
			if(move_uploaded_file($tmp_name, $destination))
			{
				$success = true;
				$mes = "文件上传成功";
				$file['name'] = $fileUniName;
				break;
			}
			else
			{
				$mes = "文件移动失败";
				break;
			}
			break;
		case UPLOAD_ERR_INI_SIZE:
			$mes = "超过了配置文件上传文件的大小";
			break;
		case UPLOAD_ERR_FORM_SIZE:
			$mes = "超过了表单设置上传文件的大小";
			break;
		case UPLOAD_ERR_PARTIAL:
			$mes = "文件部分被上传";
			break;
		case UPLOAD_ERR_NO_FILE:
			$mes = "没有文件被上传";
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			$mes = "没有找到临时目录";
			break;
		case UPLOAD_ERR_CANT_WRITE:
			$mes = "文件不可写";
			break;
		case UPLOAD_ERR_EXTENSION:
			$mes = "由于PHP的扩展程序中断了上传";
			break;
	
		default:
			$mes = "未知错误类型";
			break;
	}
	$uploadResult = array();
	$uploadResult['success'] = $success;
	$uploadResult['message'] = $mes;
	$uploadResult['file'] = $file;
	return $uploadResult;
}
