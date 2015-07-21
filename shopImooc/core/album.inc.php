<?php
require_once(dirname(__FILE__).'/../lib/mysql.func.php');

function addAlbum($array) {
	connect();
	insert("imooc_album", $array);
}

