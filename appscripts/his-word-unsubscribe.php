<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/18/2017
 * Time: 3:50 PM
 */
if (isset($_POST['profile_id']) && isset($_POST['table_name'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $profile_id = $_POST['profile_id'];
    $table_name = $_POST['table_name'];

    $deleted = $opt->deleteExactData($table_name, ['follower_imei' => $profile_id]);
    if ($deleted) {
        $response['success'] = 1;
        $response['message'] = "You just have unsubscribed to this channel, it was nice having you around !!!";
    } else {
        $response['success'] = 0;
        $response['message'] = "Fail to unsuscribe you !!!!";
    }
    echo json_encode($response);
} else {
    die('');
}