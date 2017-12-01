<?php
/**
 * Created by PhpStorm.
 * User: flash
 * Date: 9/20/2015
 * Time: 7:50 PM
 */
require('DBHelper.php');

class JSON_DBHelper extends DBHelper
{
    /**<p>This function reads the number of rows inside a table in a database</p>
     *<br>
     * @param $table - The name of the table to find the number of rows in it
     * @return int Returns a JSONObject with rows found e.f {'number':'12'}
     */
    function getJSONNum($table)
    {
        $response = array();
        $sql = "SELECT * FROM $table";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $num = mysqli_num_rows($qry);
        $response['number'] = $num;
        echo json_encode($response);
    }

    /**<p>This function returns a limited quantity of data out of a database table</p>
     * <br>
     * <p>Returns an array of data fetched from the table</p>
     * @param $table - The name of the table to get the results from
     * @param $order - The way you want the data to be ordered (usually DESC or ASC)
     * @param $limit - The size of the returned array i.e The amount of rows to return
     * @return echo a JSONArray with all the values returned from the database
     */
    function getJSONLimitedData($table, $order, $limit)
    {
        $sql = "SELECT * FROM $table ORDER BY id $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        echo json_encode($result);
    }

    /**<p>This function returns a limited quantity of data out of a database table but with a choice of picking what to order by</p>
     * <br>
     * <p>Returns an array of data fetched from the table</p>
     * @param $table - The name of the table to get the results from
     * @param $order - The way you want the data to be ordered (usually DESC or ASC)
     * @param $order_by - the database table column name you want the order to effect e.g id
     * @param $limit - The size of the returned array i.e The amount of rows to return
     * @return echo a JSONArray with results from the database
     */
    function getJSONLimitedOrderedData($table, $order, $order_by, $limit)
    {
        $sql = "SELECT * FROM $table ORDER BY $order_by $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        echo json_encode($result);
    }

    /** This function queries a table with specific values in a certain column and return an associative array of the results
     * @param $table - The table to find the results in
     * @param $whereColumn - The column name to test data in
     * @param $whereValue - The column value to find matches in the above mention column
     * @param $order - ASC or DESC
     * @param $limit - The maximum number of results to get get
     * @return echo a JSONArray with the values quiried from the database
     */
    function getJSONLimData($table, $whereColumn, $whereValue, $order, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $whereColumn = $whereValue ORDER BY id $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        echo json_encode($result);
    }

    function getJSONLimOrderedData($table, $whereColumn, $whereValue, $order, $order_by, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $whereColumn = '$whereValue' ORDER BY $order_by $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return json_encode($result);
    }

    /**This function gets all the data in a database table
     * @param $table - The table to query every data in it
     * @return echo a JSONArray with all the values from the database
     */
    function getAllJSONValues($table)
    {
        $sql = "SELECT * FROM $table";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        echo json_encode($result);
    }

    /**This function queries a certain row and gets all data on that table row
     *
     * @param $table - The table where the query is to be executed
     * @param $where_column - The column name whose WHERE clause has to find
     * @param $where_value - The value of the column above mention to used in the WHERE clause
     * @return echo a JSONArray of size one with all the details of the specified row
     */
    function  getJSONDetails($table, $where_column, $where_value)
    {
        $sql = "SELECT * FROM $table WHERE $where_column = '$where_value'";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        echo json_encode($result);
    }

    /**This function queries a certain row and gets all data on that table row
     *
     * @param $table - The table where the query is to be executed
     * @param $where_column - The column name whose WHERE clause has to find
     * @param $where_value - The value of the column above mention to used in the WHERE clause
     * @param $limit - Th numbr of rows to b rturnd
     * @return echo a JSONArray of size one with all the details of the specified row
     */
    function  getJSONDetails2($table, $where_column, $where_value, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $where_column = '$where_value' LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        echo json_encode($result);
    }

    /** This function insert data into the database .
     * At index 0 of the array put the table name and then you can insert you values at other indexes in the order of your table structure.
     * @param array $data - The array of data to be inserted in the database tables .
     * @return echo a JSONObject {'success':'1'} on success and {'success':'0'} on failure
     */
    function insertDataJSON($data = array())
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
            $response['success'] = 1;
        } else {
            $response['success'] = 0;
        }
        echo json_encode($response);
    }

    /** This method updates the data in the database.
     * @param $table_name - The name of the table to update.
     * @param $set_column - The name of the column to update.
     * @param $set_value - The new value to replace the old value.
     * @param $where_column -  The column name whose WHERE clause has to find.
     * @param $where_value - The value of the column above mention to used in the WHERE clause.
     * @return echo a JSONObject {'success':'1'} on success and {'success':'0'} on failure
     */
    function updateDataJSON($table_name, $set_column, $set_value, $where_column, $where_value)
    {
        $response = array();
        $sql = "UPDATE $table_name SET $set_column = '$set_value' WHERE $where_column ='$where_value'";
        $updated = mysqli_query($this->connectToServer(), $sql);
        if ($updated) {
            $response['success'] = 1;
        } else {
            $response['success'] = 0;
        }
        echo json_encode($response);
    }

    /**
     * @param $table_name - The name of the table to delete from.
     * @param $where_column - The column name whose WHERE clause has to find.
     * @param $where_value - The value of the column above mention to used in the WHERE clause.
     * @return echo a JSONObject {'success':'1'} on success and {'success':'0'} on failure
     */
    public
    function deleteDataJSON($table_name, $where_column, $where_value)
    {
        $sql = "DELETE FROM $table_name WHERE $where_column = $where_value";
        $deleted = mysqli_query($this->connectToServer(), $sql);
        if ($deleted) {
            $response['success'] = 1;
        } else {
            $response['success'] = 0;
        }
        echo json_encode($response);

    }
}