<?php
/**
 * Created by PhpStorm.
 * User: Mr Flash
 * Date: 6/12/2017
 * Time: 2:45 PM
 */
if (isset($_POST['table_name']) && isset($_POST['channel_id']) && isset($_POST['item_id']) && isset($_POST['comment']) && isset($_POST['user_name']) && isset($_POST['user_id'])) {
    require_once('hawk/Optimizer.php');
    require_once('hawk/zi_extraz.php');

    $opt = new Optimizer();
    $channel_id = $_POST['channel_id'];
    $item_id = $_POST['item_id'];
    $table_name = $_POST['table_name'];
    $user_id = $_POST['user_id'];
    $comment = zi_extraz::descriptionText($_POST['comment']);
    $user_name = zi_extraz::titleText($_POST['user_name']);

    $insertData = [
        'id' => '',
        'channel_id' => $channel_id,
        'sermon_id' => $item_id,
        'commenter_name' => $user_name,
        'commenter_id' => $user_id,
        'comment_time' => date('D d M Y H:i:s'),
        'comment' => $comment
    ];

    $inserted = $opt->insertExactData($table_name, $insertData);
    if ($inserted) {
        $response['success'] = 1;
        $response['message'] = "Your comment has been posted successfully, thank you !!!";
    } else {
        $response['success'] = 0;
        $response['message'] = "Failed to send you comment, ooopsy";
    }
    echo json_encode($response);
} else {
    echo 'done';
}