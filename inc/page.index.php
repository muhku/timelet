<?php

// personal working hours
$t = $dao->get_personal_report();
$hours_used = $t->data[$t->get_height() - 1][$t->get_width() - 1];
$smarty->assign('personal_hours', $t->data);

// project working hours
$t = $dao->get_project_report();
$smarty->assign('project_hours', $t->data);
$smarty->assign('types', $dao->get_work_types());

$smarty->display('index.tpl');

?>