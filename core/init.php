<?php


defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT',DS.'xampp'.DS.'htdocs'.DS.'eCommerce');
defined('CORE_PATH') ? null : define('CORE_PATH',SITE_ROOT.DS.'core');
defined('INC_PATH') ? null : define('INC_PATH',SITE_ROOT.DS.'includes');

//load the config file
require_once(INC_PATH.DS.'config.php');

//load core classes
require_once(CORE_PATH.DS.'products.php');
require_once(CORE_PATH.DS.'categories.php');
require_once(CORE_PATH.DS.'users.php');
require_once(CORE_PATH.DS.'checkout.php');
require_once(CORE_PATH.DS.'cart.php');
require_once(CORE_PATH.DS.'session.php');
require_once(CORE_PATH.DS.'message.php');
?>
