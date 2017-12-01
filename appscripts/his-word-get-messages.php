<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 6/13/2017
 * Time: 11:12 AM
 */
if (isset($_REQUEST['table_name']) && isset($_REQUEST['limit'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $table_name = $_REQUEST['table_name'];
    $limit = $_REQUEST['limit'];

    $table_options = [
        'table' => $table_name,
        'order' => 'DESC',
        'order_by' => 'id',
        'limit' => $limit
    ];
    $cols = [];
    $ikvp = [];

    $results = $opt->selectExactData($table_options, $cols, $ikvp);
    echo json_encode($results);
} else {
    die('sveee');
}