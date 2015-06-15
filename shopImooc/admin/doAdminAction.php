<?php

require_once '../core/admin.inc.php';
$act=$_REQUEST['act'];
if($act == "logout")
{
	logout();
}