<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 5/17/2017
 * Time: 10:00 AM
 */
if (isset($_POST['profile_id']) && isset($_POST['table_name'])) {
    require_once('hawk/Optimizer.php');

    $opt = new Optimizer();
    $profile_id = $_POST['profile_id'];
    $table_name = $_POST['table_name'];

    echo $profile_id . ' : ' . $table_name;

/*    $insertData = [
        'id'=>'',
        'follower_imei'=>$profile_id,
        'following_date'=> date('D d M Y H:i:s')
    ];
    $insData = [
        $table_name,
        '',
        $profile_id,
        date('D d M Y H:i:s')
    ];
    $inserted = $opt->insertData($insData);
    //$inserted = $opt->insertExactData($table_name, $insertData);
    if ($inserted) {
        $response['success'] = 1;
        $response['message'] = "You just have been subscribed to this channel, enjoy !!!";
    } else {
        $response['success'] = 0;
        $response['message'] = "You already have been subscribed to this channel, enjoy !!!!";
    }
    echo json_encode($response);*/
} else {
    die('');
}