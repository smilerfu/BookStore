<?php

require_once(dirname(__FILE__).'/../lib/upload.func.php');
$mes = uploadFiles($_FILES);
var_dump($mes);
