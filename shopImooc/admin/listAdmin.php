<?php 
require_once '../core/admin.inc.php';
require_once '../lib/common.func.php';
$rows=getAllAdmin();
if(!$rows)
{
	alertMes("sorry,没有管理员，请添加", "addAdmin.php");
	exit;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link rel="stylesheet" href="style/backstage.css">
</head>

<body>
            <!--右侧内容-->
                <div class="details">
                    <div class="details_operation clearfix">
                        <div class="bui_select">
                            <input type="button" value="添&nbsp;&nbsp;加" class="add" onclick="addAdmin()">
                        </div>
                    </div>
                    <!--表格-->
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th width="25%">管理员名称</th>
                                <th width="30%">管理员邮箱</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;foreach($rows as $row):?>
                            <tr>
                                <!--这里的id和for里面的c1 需要循环出来-->
                                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $i;?></label></td>
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td align="center"><input type="button" value="修改" class="btn" onclick="editAdmin(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"></td>
                            </tr>
                        <?php $i++; endforeach;?>
                        </tbody>
                    </table>
                </div>
</body>
<script type="text/javascript">
	function editAdmin(id)
	{
		window.location="editAdmin.php?id=" + id;
	}
		
</script>
</html>