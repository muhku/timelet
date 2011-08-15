<?php

$config['basedir'] = dirname(__FILE__);
$config['baseurl'] = '/timelet';

require_once('lib/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir   = $config['basedir'] . '/templates/';
$smarty->compile_dir    = $config['basedir'] . '/tmp/templates_c/';
$smarty->cache_dir      = $config['basedir'] . '/tmp/cache/';
$smarty->config_dir     = $config['basedir'] . '/libs/smarty/configs/';

$smarty->assign('config', $config);

ini_set('display_errors', 1);
error_reporting(E_ALL);

?>