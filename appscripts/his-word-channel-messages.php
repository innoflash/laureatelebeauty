<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/18/2017
 * Time: 2:04 PM
 */
if (isset($_POST['table_name']) && isset($_POST['limit'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $table_name = $_POST['table_name'];
    $limit = $_POST['limit'];

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