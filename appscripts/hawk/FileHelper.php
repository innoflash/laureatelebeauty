<?php

/**
 * Created by PhpStorm.
 * User: flash
 * Date: 7/22/2015
 * Time: 7:54 AM
 */
class FileHelper
{

    /**
     * @param $folder the folder where the image resides
     * @param $oldname the original file name
     * @param $newname the new name the image must have
     * @return string full image path
     */
    function renameFiles($folder, $oldname, $newname)
    {
        // $newname = $newname . '.' . $this->getExtension($oldname);
        rename($folder . $oldname, $folder . $newname);
        return $folder . $newname;
    }

    function stringFormat($src)
    {
        $name = strtolower($src);
        $name = str_replace(" ", "_", $name);
        $name = str_replace(")", "_", $name);
        $name = str_replace("(", "_", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("/", "_", $name);
        $name = strip_tags($name);
        $name = stripcslashes($name);
        return $name;
    }

    function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

}