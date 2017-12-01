<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/15/2017
 * Time: 11:08 AM
 */
if (isset($_POST['channel_id'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $channel_id = $_POST['channel_id'];

    $table_options = [
        'table' => 'channels',
        'order' => 'DESC',
        'order_by' => 'id'
    ];

    $cols = [
        'id',
        'channel_name',
        'channel_email',
        'channel_phone',
        'channel_icon'
    ];
    $ikvp = [
        'id' => $channel_id
    ];

    $results = $opt->selectExactData($table_options, $cols, $ikvp);
    echo json_encode($results);
} else {
    die('');
}