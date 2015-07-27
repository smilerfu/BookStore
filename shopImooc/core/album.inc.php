<?php
require_once(dirname(__FILE__).'/../lib/mysql.func.php');

function addAlbum($array) {
	connect();
	insert("imooc_album", $array);
}

function getProImgById($pId) {
	$sql = "select albumPath from imooc_album where pid = {$pId}";
	$row = fetchOne($sql);
	return $row;
}

