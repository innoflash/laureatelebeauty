<?php
/**
 * Created by PhpStorm.
 * User: flash
 * Date: 11/17/2015
 * Time: 11:45 AM
 */
$img_file = $_FILES['file']['name'];
$destination_folder = $_POST['store_directory'];
$uploaded = move_uploaded_file($_FILES['file']['tmp_name'], $destination_folder . $img_file);

try {
    $thumb_dir = $_POST['thumb_directory'];

    ///compress images
    if ($uploaded) {
        require('../zi_scriptz/zi_extraz.php');
        require_once('../hawk/ImageHelper.php');

        $extraz = new zi_extraz();
        $img_helper = new ImageHelper();


        $new_name = $extraz->stringFormat($img_file);
        $renamed = $img_helper->renameFiles($destination_folder, $img_file, $new_name);
        $thumbs_dir = '../hpm_ziana_thumbs/';

        $crop_data = array(
            'file_path' => $renamed,
            'dimension' => 140,
            'store_directory' => $thumbs_dir,
            'new_filename' => $new_name
        );

        try {
            $thumb_type = $_POST['thumb_type'];
            switch ($thumb_type) {
                case 'square':
                    $img_helper->squareThumb($crop_data);
                    break;
                case 'original':
                    $img_helper->createThumb($crop_data);
                    break;
            }
        } catch (Exception $e) {
            $img_helper->squareThumb($crop_data);
        }
    }

} catch (Exception $e) {
}

