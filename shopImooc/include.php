<?php
session_start();
define("ROOT", dirname(__FILE__));

// set_include_path(
// implode(PATH_SEPARATOR, array(
// ".",
// ROOT."/lib",
// ROOT."/core",
// ROOT."/configs",
// get_include_path(),
// )));
// echo get_include_path();

set_include_path("." . PATH_SEPARATOR . ROOT . "/lib" . PATH_SEPARATOR . ROOT . "/core" . PATH_SEPARATOR. ROOT . "/configs" .PATH_SEPARATOR . get_include_path());
echo get_include_path();


//lib
require_once 'common.func.php';
require_once 'image.func.php';
require_once 'mysql.func.php';
require_once 'page.func.php';
require_once 'string.func.php';
require_once 'upload.func.php';

//core
require_once 'admin.inc.php';
require_once 'album.inc.php';
require_once 'cate.inc.php';
require_once 'pro.inc.php';

//configs
require_once 'configs.php';


