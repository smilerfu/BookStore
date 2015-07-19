<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<form action="doAction.php" method="post" enctype="multipart/form-data">
<!-- 	设置表单上传文件的大小 	-->
<!-- 	<input type="hidden" name="MAX_FILE_SIZE" value="51200" /> -->
	请选择上传文件:<input type="file" name="myFile1" /></br>
	请选择上传文件:<input type="file" name="myFile2[]" /></br>
	请选择上传文件:<input type="file" name="myFile3[]" /></br>
	请选择上传文件:<input type="file" name="myFile4[]" /></br>
	<input type="submit" value="上传" />
</form>
</body>
</html>