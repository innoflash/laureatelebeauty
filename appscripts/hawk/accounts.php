<?php
/**
 * Created by PhpStorm.
 * User: professor
 * Date: 8/30/2015
 * Time: 7:50 PM
 */

require('hawk_sessions.php');
require_once('hawk_error.php');

class Accounts
{
    /**This function does the logging in business and takes an associative array of 7 items
     * @param array $login_data - This is an the associative array of the following indexes
     * <ul>
     * <li><b>table</b> The table name to test against</li>
     * <li><b>first_db_field</b> The column name in the table to test data in e.g <i>username</i></li>
     * <li><b>second_db_field</b> The column name in the table to test data in e.g <i>password</i></li>
     * <li><b>first_input_value</b> The first input value from the form e.g <i>username</i></li>
     * <li><b>second_input_value</b> The second input value from the form e.g <i>password</i></li>
     * <li><b>goto_link</b> The link to go to when successfully logged in e.g <i>users.php</i></li>
     * <li><b>db_connection</b> The mysqli object of the database connection e.g <i>$connection</i></li>
     * </ul>
     * <p>Returns nothing but on failure it displays an error message
     */
    public function logIn($login_data = array())
    {
        $table = $login_data['table'];
        $first_field = $login_data['first_db_field'];
        $second_field = $login_data['second_db_field'];
        $first_value = $login_data['first_input_value'];
        $second_value = $login_data['second_input_value'];
        $goto_link = $login_data['goto_link'];
        $connection = $login_data['db_connection'];

        $users_found = $this->usersCount($table, $first_field, $first_value, $second_field, $second_value, $connection);
        if ($users_found == 1) {
            //will go to link and start sessions
            hawk_sessions::startSessions($first_field, $second_field, $first_value, $second_value);
            header("Location: $goto_link");
        } else {
            //will remain on the same page
            hawk_error::showError('Invalid user credentials');
        }
    }

    private function usersCount($table, $first_field, $first_value, $second_field, $second_value, $connection)
    {
        $sql = "SELECT * FROM $table WHERE $first_field = '$first_value' && $second_field = '$second_value'";
        $qry = mysqli_query($connection, $sql);
        return mysqli_num_rows($qry);
    }

    /**This function does the logging in business and takes an associative array of 7 items
     * @param array $login_data - This is an the associative array of the following indexes
     * <ul>
     * <li><b>table</b> The table name to test against</li>
     * <li><b>first_db_field</b> The column name in the table to test data in e.g <i>username</i></li>
     * <li><b>second_db_field</b> The column name in the table to test data in e.g <i>password</i></li>
     * <li><b>first_input_value</b> The first input value from the form e.g <i>username</i></li>
     * <li><b>second_input_value</b> The second input value from the form e.g <i>password</i></li>
     * <li><b>db_connection</b> The mysqli object of the database connection e.g <i>$connection</i></li>
     * </ul>
     * <p>Returns a string 'success' on success and 'failure' on failure
     */
    public function ajaxLogIn($login_data = array())
    {
        $table = $login_data['table'];
        $first_field = $login_data['first_db_field'];
        $second_field = $login_data['second_db_field'];
        $first_value = $login_data['first_input_value'];
        $second_value = $login_data['second_input_value'];
        $connection = $login_data['db_connection'];

        $users_found = $this->usersCount($table, $first_field, $first_value, $second_field, $second_value, $connection);
        if ($users_found == 1) {
            //will go to link and start sessions
            hawk_sessions::startSessions($first_field, $second_field, $first_value, $second_value);
            echo 'success';
        } else {
            //will remain on the same page
            hawk_error::showError('failure');
        }
    }

    /** This function logs out by killing all active sessions
     * @param $goto_link - The link to go to when successfully logged out
     * @return bool Returns TRUE on success and FALSE on failure
     */
    public function logOut($goto_link)
    {
        $logged_out = hawk_sessions::stopSessions();
        header("Location: $goto_link");
        return $logged_out;
    }

}