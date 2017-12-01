<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/18/2017
 * Time: 12:21 PM
 */
if (isset($_POST['channel_id']) && isset($_POST['limit'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $channel_id = $_POST['channel_id'];
    $limit = $_POST['limit'];

    $table_options = [
        'table' => 'channel_word',
        'order' => 'DESC',
        'order_by' => 'id',
        'limit' => $limit
    ];
    $cols = [];
    $ikvp = [
        'channel_id' => $channel_id
    ];

    $results = $opt->selectExactData($table_options, $cols, $ikvp);
    echo json_encode($results);
} else {
    die('sveee');
}