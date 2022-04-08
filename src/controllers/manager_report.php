<?php
/**
 *
 *
 * @author Diego Staniescki
 * @link https://github.com/diegostaniescki
 * @date 2022-04-08 06:31:52
 */

session_start();
requireValidSession();

LoadTemplateView('manager_report', []);
