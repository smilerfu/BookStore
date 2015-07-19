<?php
require_once '../lib/mysql.func.php';

function addAlbum($array) {
	connect();
	insert("imooc_album", $array);
}

