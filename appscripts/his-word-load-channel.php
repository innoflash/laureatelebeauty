<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/11/2017
 * Time: 9:32 AM
 */
if (isset($_POST['channel_id'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $channel_id = $_POST['channel_id'];

    $results = $opt->getDetails('channels', 'id', $channel_id);
    echo json_encode($results);
} else {
    die('');
}