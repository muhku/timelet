<?php

require_once('config.inc.php');
require_once('inc/prepend.php');

$dao_provider = new DAOProvider();
$dao = $dao_provider->get_dao();

// determine current page
$pages = array('index', 'worklog');
$page = @$_REQUEST['page'];
$page = in_array($page, $pages) ? $page : $pages[0];

require_once("inc/page.{$page}.php");

?>
