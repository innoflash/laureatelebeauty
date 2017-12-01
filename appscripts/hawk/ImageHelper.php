<?php
/**
 * Created by PhpStorm.
 * User: Bill Richies
 * Date: 8/31/2015
 * Time: 4:51 PM
 */
require('FileHelper.php');
require('ImageProcessor.php');

class ImageHelper extends FileHelper
{

    private $image_processor;

    /** This
     * @param $src
     * @param $dest_file
     * @param $quality
     * @return mixed
     */
    function compress_image($src, $dest_file, $quality)
    {
        $info = getimagesize($src);
        $extension = $this->getExtension($src);

        if ($extension == "jpg" || $extension == "jpeg") {
            global $img;
            $img = imagecreatefromjpeg($src);
        } else if ($extension == "png") {
            global $img;
            $img = imagecreatefrompng($src);
        } else {
            global $img;
            $img = imagecreatefromgif(src);
        }
        imagejpeg($img, $dest_file, $quality);
        return $dest_file;
    }

    /**
     * This method crops a square image of the the copy provided
     * @param array $crop_details The associative array of four important keys i.e
     * <ul>
     * <li>file_path</li>
     * <li>dimension</li>
     * <li>store_directory</li>
     * <li>new_filename</li>
     * </ul>
     */
    function squareThumb($crop_details = array())
    {
        $this->image_processor = new ImageProcessor();
        $this->image_processor->loadImage($crop_details['file_path']);
        $this->image_processor->resizeImage($crop_details['dimension'], $crop_details['dimension'], 'crop');
        $this->image_processor->saveImage($crop_details['store_directory'] . $crop_details['new_filename']);
    }

    /**
     * This method crops a square image of the the copy provided
     * @param array $thumb_details The associative array of four important keys i.e
     * <ul>
     * <li>file_path</li>
     * <li>dimension</li>
     * <li>store_directory</li>
     * <li>new_filename</li>
     * </ul>
     */
    function createThumb($thumb_details = array())
    {
        $this->image_processor = new ImageProcessor();
        $this->image_processor->loadImage($thumb_details['file_path']);
        $this->image_processor->resizeImage($thumb_details['dimension'], $thumb_details['dimension'], 'auto');
        $this->image_processor->saveImage($thumb_details['store_directory'] . $thumb_details['new_filename']);
    }

    /** This moves a pic from a tmp folder and create a thumbnail of the same pic
     * @param $dest_dir The directory to place the image in
     * @param $thumb_dir The directory to place the thumbnail
     * @param $src_dir The original folder where the picture will be coming from
     * @param $file_name The name the picture has to be using throughout
     */
    function processImage($dest_dir, $thumb_dir, $src_dir, $file_name)
    {
        $copied = copy($src_dir . $file_name, $dest_dir . $file_name);
        if ($copied) {
            $deleted = unlink($src_dir . $file_name);
            if ($deleted) {
                $crop_data = array(
                    'file_path' => $dest_dir . $file_name,
                    'dimension' => 100,
                    'store_directory' => $thumb_dir,
                    'new_filename' => $file_name
                );

                try {
                    $thumb_type = 'square';
                    switch ($thumb_type) {
                        case 'square':
                            $this->squareThumb($crop_data);
                            break;
                        case 'original':
                            $this->createThumb($crop_data);
                            break;
                    }
                } catch (Exception $e) {
                    $this->squareThumb($crop_data);
                }
            }
            return true;
        } else {
            return false;
        }
    }
}