<?php

$session = new Session();
$session->set_dao($dao);
$session->set_auth_user($_SERVER["PHP_AUTH_USER"]);
$user = $session->get_user();

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'save_worklog_entry')
{
    $week = intval($_POST["week"]);
    $year = intval($_POST["year"]);
    $work_type_id = intval($_POST["work_type_id"]);
    $work_description = str_replace("'", "", $_POST["work_description"]);
    $time_worked = str_replace(',', '.', $_POST["time_worked"]);

    $work_type = $dao->get_work_type($work_type_id);
    $project = $session->get_project();
    $dao->save_worklog_entry($project, $user, $work_type, $year, $week, $work_description, $time_worked);
    
    header("Location: index.php?page=worklog&week=$week&year=$year");
}

$cal = new Calendar();
$cur_year = $cal->get_year();
$cur_week = $cal->get_week();

if (isset($_GET["week"]) && isset($_GET["year"]))
{
    $cur_year = intval($_GET["year"]);
    $cur_week = intval($_GET["week"]);
}

$worklog_entries = $dao->get_worklog_entries($session->get_project(), $user, $cur_year, $cur_week);

$smarty->assign('user', $user);
$smarty->assign('cur_year', $cur_year);
$smarty->assign('cur_week', $cur_week);
$smarty->assign('types', $dao->get_work_types());
$smarty->assign('worklog_entries', $worklog_entries);

$smarty->display('worklog.tpl');

?>