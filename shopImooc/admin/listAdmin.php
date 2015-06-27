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
                            <tr>
                                <!--这里的id和for里面的c1 需要循环出来-->
                                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label">001</label></td>
                                <td>xxx</td>
                                <td>yyy</td>
                                <td align="center"><input type="button" value="修改" class="btn"><input type="button" value="删除" class="btn"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        <!--左侧列表-->
<!--         <div class="menu"> -->
<!--             <div class="cont"> -->
<!--                 <div class="title">管理员</div> -->
<!--                 <ul class="mList"> -->
<!--                     <li> -->
<!--                         <h3><span>-</span>商品管理</h3> -->
<!--                         <dl> -->
<!--                             <dd><a href="#">商品修改</a></dd> -->
<!--                             <dd><a href="#">商品分类</a></dd> -->
<!--                         </dl> -->
<!--                     </li> -->
<!--                     <li> -->
<!--                         <h3><span>+</span>订单管理</h3> -->
<!--                         <dl> -->
<!--                             <dd><a href="#">订单修改</a></dd> -->
<!--                             <dd><a href="#">订单又修改</a></dd> -->
<!--                             <dd><a href="#">订单总是修改</a></dd> -->
<!--                             <dd><a href="#">测试内容你看着改</a></dd> -->
<!--                         </dl> -->
<!--                     </li> -->
<!--                 </ul> -->
<!--             </div> -->
<!--         </div> -->
</body>
</html>