<?php

/**
 * Created by PhpStorm.
 * User: flash
 * Date: 9/17/2015
 * Time: 12:01 AM
 */
class zi_extraz
{
    function stringFormat($src)
    {
        $name = strtolower($src);
        $name = str_replace(" ", "_", $name);
        $name = str_replace(")", "_", $name);
        $name = str_replace("(", "_", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("/", "_", $name);
        $name = str_replace("&", "and", $name);
        $name = strip_tags($name);
        $name = stripcslashes($name);
        $name = trim($name);
        return $name;
    }

    function removeDash($src)
    {
        return str_replace("_", " ", $src);
    }

    function formatEmail($string)
    {
        $finds = [
            "'",
            "@",
            ".",
            "-"
        ];

        $fix = [
            "_",
            "_",
            "_",
            "_"
        ];

        return str_replace($finds, $fix, $string);
    }

    public static function descriptionText($string)
    {
        $finds = [
            "'",
            "-"
        ];

        $fix = [
            "`",
            "_"
        ];

        return str_replace($finds, $fix, ucfirst($string));
    }

    public static function titleText($string)
    {
        $finds = [
            "'",
            "-"
        ];

        $fix = [
            "`",
            "_"
        ];

        return str_replace($finds, $fix, ucwords($string));
    }

}