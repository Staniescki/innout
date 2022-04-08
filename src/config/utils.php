<?php
/**
 * File ${NAME}
 *
 * @author Diego Staniescki
 * @link https://github.com/diegostaniescki
 * @date 2022-04-07 07:31:46
 */

function addSuccessMsg($msg){
    $_SESSION['message'] = [
        'type'    =>  'success',
        'message'    => $msg
    ];
}

function addErrorMsg($msg){
    $_SESSION['message'] = [
        'type'    =>  'error',
        'message'    => $msg
    ];
}