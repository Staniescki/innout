<?php
/**
 *
 *
 * @author Diego Staniescki
 * @link https://github.com/diegostaniescki
 * @date 2022-04-08 06:31:52
 */

session_start();
requireValidSession(true);

$activeUsersCount = User::getActiveUsersCount();
$absentUsers = WorkingHours::getAbsentUsers();

$yearAndMonth = (new DateTime())->format('Y-m');
$seconds = WorkingHours::getWorkedTimeInMonth($yearAndMonth);
$hoursInMonth = explode(':', getTimeStringFromSeconds($seconds))[0];

LoadTemplateView('manager_report', [
    'activeUsersCount' => $activeUsersCount,
    'absentUsers' => $absentUsers,
    'hoursInMonth' => $hoursInMonth,
]);
