<?php
/**
 * Created by PhpStorm.
 * User: flash
 * Date: 9/20/2015
 * Time: 7:53 PM
 */
require('DBHelper.php');
require('hawk_sessions.php');

class AJAX_DBHelper extends DBHelper
{
    /**<p>This function reads the number of rows inside a table in a database</p>
     *<br>
     * @param $table - The name of the table to find the number of rows in it
     * @return echos the num found
     */
    function getAJAXNum($table)
    {
        $sql = "SELECT * FROM $table";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $num = mysqli_num_rows($qry);
        echo $num;
    }

    /** This function insert data into the database .
     * At index 0 of the array put the table name and then you can insert you values at other indexes in the order of your table structure.
     * @param array $data - The array of data to be inserted in the database tables .
     * @return echos 'success' on success and 'failure' on failure
     */
    function insertDataAJAX($data = array())
    {
        $response = array();
        $table_data = "";
        for ($x = 1; $x < sizeof($data); $x++) {
            $table_data = $table_data . "'$data[$x]',";
        }
        $len = strlen($table_data);
        $table_data = substr($table_data, 0, $len - 1);

        $sql = "INSERT INTO $data[0] VALUES ($table_data)";
        $inserted = mysqli_query($this->connectToServer(), $sql);

        if ($inserted) {
            $success = 'success';
        } else {
            $success = 'failure';
        }
        echo $success;
    }

    /** This method updates the data in the database.
     * @param $table_name - The name of the table to update.
     * @param $set_column - The name of the column to update.
     * @param $set_value - The new value to replace the old value.
     * @param $where_column -  The column name whose WHERE clause has to find.
     * @param $where_value - The value of the column above mention to used in the WHERE clause.
     * @return echos 'success' on success and 'failure' on failure
     */
    function updateDataAJAX($table_name, $set_column, $set_value, $where_column, $where_value)
    {
        $response = array();
        $sql = "UPDATE $table_name SET $set_column = '$set_value' WHERE $where_column ='$where_value'";
        $updated = mysqli_query($this->connectToServer(), $sql);
        if ($updated) {
            $success = 'success';
        } else {
            $success = 'failure';
        }
        echo $success;
    }

    /**
     * @param $table_name - The name of the table to delete from.
     * @param $where_column - The column name whose WHERE clause has to find.
     * @param $where_value - The value of the column above mention to used in the WHERE clause.
     * @return echos 'success' on success and 'failure' on failure
     */
    public
    function deleteDataAJAX($table_name, $where_column, $where_value)
    {
        $sql = "DELETE FROM $table_name WHERE $where_column = $where_value";
        $deleted = mysqli_query($this->connectToServer(), $sql);
        if ($deleted) {
            $success = 'success';
        } else {
            $success = 'failure';
        }
        echo $success;

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
            echo 'failure';
        }
    }

    private function usersCount($table, $first_field, $first_value, $second_field, $second_value, $connection)
    {
        $sql = "SELECT * FROM $table WHERE $first_field = '$first_value' && $second_field = '$second_value'";
        $qry = mysqli_query($connection, $sql);
        return mysqli_num_rows($qry);
    }
}