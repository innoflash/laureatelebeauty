<?php
/**
 * Created by PhpStorm.
 * User: professor
 * Date: 8/30/2015
 * Time: 8:58 PM
 */
require('hawk_error.php');

final class hawk_sessions
{

    public static function startSessions($first_db_field, $second_db_field, $first_value, $second_value)
    {
        $session_state = session_status();
        if ($session_state == PHP_SESSION_NONE) {
            session_start();
            $_SESSION[$first_db_field] = $first_value;
            $_SESSION[$second_db_field] = $second_value;
        } else if ($session_state == PHP_SESSION_DISABLED) {

        }
    }

    public static function stopSessions()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (session_destroy()) {
                return true;
            } else {
                hawk_error::showError('Error in logging out');
                return false;
            }
        }
    }
}