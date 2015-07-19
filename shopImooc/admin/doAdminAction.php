<?php

require_once '../core/admin.inc.php';
require_once '../core/cate.inc.php';
require_once '../core/pro.inc.php';

$act=$_REQUEST['act'];

if($act == "logout")
{
	logout();
}
elseif($act == "addAdmin")
{
	$mes = addAdmin();
}

elseif ($act == "editAdmin")
{
	$id = $_REQUEST['id'];
	$mes = editAdmin($id);
}

elseif ($act == "delAdmin")
{
	$id = $_REQUEST['id'];
	$mes = delAdmin($id);
}

elseif($act == "addCate")
{
	$mes = addCate();
}

elseif($act == "editCate")
{
	$id = $_REQUEST['id'];
	$mes = editCate($id);
}

elseif($act == "delCate")
{
	$id = $_REQUEST['id'];
	$mes = delCate($id);
}

elseif ($act == "addPro")
{
	$mes = addPro();
}
elseif ($act == "editPro")
{
	$id = $_REQUEST['id'];
	$mes = editPro($id);
}
elseif ($act == "delPro")
{
	$id = $_REQUEST['id'];
	$mes = delPro($id);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php 
if($mes)
{
	echo $mes;
}
?>
</body>
</html>