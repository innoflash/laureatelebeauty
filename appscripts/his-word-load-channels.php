<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/15/2017
 * Time: 9:29 AM
 */
if (isset($_POST['limit'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $limit = $_POST['limit'];

    $table_options = [
        'table' => 'channels',
        'order' => 'DESC',
        'order_by' => 'id',
        'limit' => $limit
    ];

    $cols = [
        'id',
        'channel_name',
        'channel_email',
        'channel_phone',
        'channel_icon'
    ];
    $ikvp = [];

    $results = $opt->selectExactData($table_options, $cols, $ikvp);
    echo json_encode($results);
} else {
    die('');
}