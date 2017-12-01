<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/15/2017
 * Time: 11:01 AM
 */
if (isset($_POST['limit']) && isset($_POST['search_name'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $limit = $_POST['limit'];
    $search_name = $_POST['search_name'];

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
    $ikvp = [
        'channel_name' => $search_name
    ];

    $results = $opt->selectLikeDataExact($table_options, $cols, $ikvp);
    echo json_encode($results);
} else {
    die('');
}