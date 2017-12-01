<?php

/**
 * Created by PhpStorm.
 * User: professor
 * Date: 8/30/2015
 * Time: 9:32 PM
 */
require('DBHelper.php');

class db_connector extends theBomb
{
    public static function getConnection()
    {
        return self::connectToServer();
    }
}