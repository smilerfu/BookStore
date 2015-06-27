<?php
require_once '../core/admin.inc.php';
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