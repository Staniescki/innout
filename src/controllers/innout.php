<?php
/**
 * File ${NAME}
 *
 * @author Diego Staniescki
 * @link https://github.com/diegostaniescki
 * @date 2022-04-07 07:20:14
 */
session_start();
requireValidSession();

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

try {
    $currentTime = strftime('%H:%M:%S', time());
    if ($_POST['forcedTime']){
        $currentTime = $_POST['forcedTime'];
    }
    $records->innout($currentTime);
    addSuccessMsg('Ponto inserido com sucesso');
}catch (AppException $e){
    addErrorMsg($e->getMessage());
}
header("Location: day_records.php");
