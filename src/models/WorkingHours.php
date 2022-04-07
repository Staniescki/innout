<?php
/**
 * File ${NAME}
 *
 * @author Diego Staniescki
 * @link https://github.com/diegostaniescki
 * @date 2022-04-06 20:54:25
 */

class WorkingHours extends Model{
    protected static $tableName = 'working_hours';
    protected static $colums =
        [
            'id',
            'user_id',
            'work_date',
            'time1',
            'time2',
            'time3',
            'time4',
            'worked_time'
        ];
}
