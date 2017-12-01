<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 6/12/2017
 * Time: 9:53 AM
 */
if (isset($_POST['table_name']) && isset($_POST['channel_id']) && isset($_POST['item_id']) && isset($_POST['limit'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $limit = $_POST['limit'];
    $channel_id = $_POST['channel_id'];
    $item_id = $_POST['item_id'];
    $table_name = $_POST['table_name'];

    $tableOptions = [
        'table' => $table_name,
        'order_by' => 'id',
        'order' => 'DESC',
        'limit' => $limit
    ];

    $cols = [];
    $ikvp = [
        'channel_id' => $channel_id,
        'sermon_id' => $item_id
    ];

    $results = $opt->selectExactData($tableOptions, $cols, $ikvp);
    echo json_encode($results);

} else {
    echo 'sveeee';
}