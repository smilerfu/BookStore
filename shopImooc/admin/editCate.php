<?php
require_once(dirname(__FILE__).'/../lib/mysql.func.php');
require_once(dirname(__FILE__).'/../core/cate.inc.php');

$id = $_REQUEST['id'];
$row = getCateByID($id);
//var_dump($row);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
	<h3>修改分类</h3>
	<form action="doAdminAction.php?act=editCate&id=<?php echo $id;?>" method="post">
		<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
			<tr>
				<td align="right">分类名称</td>
				<td><input type="text" name="cName" placeholder="<?php echo $row['cName'];?>"/></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="修改分类"/></td>
			</tr>
		</table>
	</form>
</body>
</html>