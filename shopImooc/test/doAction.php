<?php

require_once '../lib/upload.func.php';
$mes = uploadFiles($_FILES);
var_dump($mes);
