<?php

/**
 * Created by PhpStorm.
 * User: professor
 * Date: 8/27/2015
 * Time: 12:12 PM
 */
class DBHelper
{
    const HOST = "localhost";
    const USER = "laureate_flash";
    const PASSWORD = "flash#17";
    const DB_NAME = "laureate_his_word";

    /**<p>This function reads the number of rows inside a table in a database</p>
     *<br>
     * @param $table - The name of the table to find the number of rows in it
     * @return int Returns the number of rows found in the table
     */
    public
    function getNum($table)
    {
        $sql = "SELECT id FROM $table";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $num = mysqli_num_rows($qry);
        return $num;
    }

    /**
     * This method connects to your database provided its propserly connected
     * The connection details must be set to fit your server connection
     *
     * @return mysqli Returns the connection object if successfully connected
     *
     */
    public function connectToServer()
    {

        //open mysql connection
        $mysqli = new mysqli(self::HOST, self::USER, self::PASSWORD, self::DB_NAME);

        //output error and exit if there's an error
        if ($mysqli->connect_error) {
            die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        return $mysqli;
    }

    /**<p>This function returns a limited quantity of data out of a database table</p>
     * <br>
     * <p>Returns an array of data fetched from the table</p>
     * @param $table - The name of the table to get the results from
     * @param $order - The way you want the data to be ordered (usually DESC or ASC)
     * @param $limit - The size of the returned array i.e The amount of rows to return
     * @return array returns an array of results from the database
     */
    public
    function getLimitedData($table, $order, $limit)
    {
        $sql = "SELECT * FROM $table ORDER BY id $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /**
     * This function gets a limited amount of data from a table
     * @param $table -The table to find results in
     * @param $whereColumn -The column to contain certain value
     * @param $whereValue -The value to find in columns to be found
     * @param $order -The order to perform the sorting
     * @param $limit -The number of rows to return
     * @return array The array with contents extracted
     */
    function getLimitedData2($table, $whereColumn, $whereValue, $order, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $whereColumn = '$whereValue' ORDER BY id $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /**<p>This function returns a limited quantity of data out of a database table but with a choice of picking what to order by</p>
     * <br>
     * <p>Returns an array of data fetched from the table</p>
     * @param $table - The name of the table to get the results from
     * @param $order - The way you want the data to be ordered (usually DESC or ASC)
     * @param $order_by - the database table column name you want the order to effect e.g id
     * @param $limit - The size of the returned array i.e The amount of rows to return
     * @return array returns an array of results from the database
     */
    function getLimitedOrderedData($table, $order, $order_by, $limit)
    {
        $sql = "SELECT * FROM $table ORDER BY $order_by $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /** This function queries a table with specific values in a certain column and return an associative array of the results
     * @param $table - The table to find the results in
     * @param $whereColumn - The column name to test data in
     * @param $whereValue - The column value to find matches in the above mention column
     * @param $order - ASC or DESC
     * @param $limit - The maximum number of results to get get
     * @return array Returns an array of results in the data table
     */
    function getLimData($table, $whereColumn, $whereValue, $order, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $whereColumn = $whereValue ORDER BY id $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    function getLimOrderedData($table, $whereColumn, $whereValue, $order, $order_by, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $whereColumn = '$whereValue' ORDER BY $order_by $order LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /**This function gets all the data in a database table
     * @param $table - The table to query every data in it
     * @return array Returns an array of data fetched from the table
     */
    public
    function getAllValues($table)
    {
        $sql = "SELECT * FROM $table";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /**This function gets all the data in a database table in a descending order
     * @param $table - The table to query every data in it
     * @return array Returns an array of data fetched from the table
     */
    function getDescendingValues($table)
    {
        $sql = "SELECT * FROM $table ORDER BY id DESC";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /**This function queries a certain row and gets all data on that table row
     *
     * @param $table - The table where the query is to be executed
     * @param $where_column - The column name whose WHERE clause has to find
     * @param $where_value - The value of the column above mention to used in the WHERE clause
     * @return array|null Returns an array of size 1 with all the row data or null if there is an error in querying
     */
    public
    function  getDetails($table, $where_column, $where_value)
    {
        $sql = "SELECT * FROM $table WHERE $where_column = '$where_value'";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /** This function queries a table with specific values in a certain column and return an associative array of the results
     * @param $table - The table to find the results in
     * @param $where_column - The column name to test data in
     * @param $where_value - The column value to find matches in the above mention column
     * @param $limit - The maximum number of results to get get
     * @return array Returns an array of results in the data table starting with the one at the bottom by id
     */
    function getDetailsReverseOrder($table, $where_column, $where_value, $limit)
    {
        $sql = "SELECT * FROM $table WHERE $where_column = '$where_value' ORDER BY id DESC  LIMIT 0, $limit";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    /** This function insert data into the database .
     * At index 0 of the array put the table name and then you can insert you values at other indexes in the order of your table structure.
     * @param array $data - The array of data to be inserted in the database tables .
     * @return bool|mysqli_result - returns TRUE if inserted and FALSE if not.
     */
    public
    function insertData($data = array())
    {
        $table_data = "";
        for ($x = 1; $x < sizeof($data); $x++) {
            $table_data = $table_data . "'$data[$x]',";
        }
        $len = strlen($table_data);
        $table_data = substr($table_data, 0, $len - 1);

        $sql = "INSERT INTO $data[0] VALUES ($table_data)";
        $inserted = mysqli_query($this->connectToServer(), $sql);

        return $inserted;
    }

    /** This method updates the data in the database.
     * @param $table_name - The name of the table to update.
     * @param $set_column - The name of the column to update.
     * @param $set_value - The new value to replace the old value.
     * @param $where_column -  The column name whose WHERE clause has to find.
     * @param $where_value - The value of the column above mention to used in the WHERE clause.
     * @return bool|mysqli_result - returns TRUE if updated and FALSE if not.
     */
    public
    function updateData($table_name, $set_column, $set_value, $where_column, $where_value)
    {
        $sql = "UPDATE $table_name SET $set_column = '$set_value' WHERE $where_column ='$where_value'";
        $updated = mysqli_query($this->connectToServer(), $sql);
        return $updated;
    }

    /**
     * @param $table_name - The name of the table to delete from.
     * @param $where_column - The column name whose WHERE clause has to find.
     * @param $where_value - The value of the column above mention to used in the WHERE clause.
     * @return bool|mysqli_result -  returns TRUE if deleted and FALSE if not.
     */
    public
    function deleteData($table_name, $where_column, $where_value)
    {
        $sql = "DELETE FROM $table_name WHERE $where_column = $where_value";
        $deleted = mysqli_query($this->connectToServer(), $sql);
        return $deleted;

    }

    /**
     * <p>This method queries the number of columns with the specified data</p>
     * @param $table_name - the table to perform a query at
     * @param $where_column1 - one of the columns to be tested
     * @param $where_column2 - the other column to be tested
     * @param $where_value1 - value for the first column
     * @param $where_value2 - value for the other comn
     * @return int Returns the number of rows found
     */
    function getSelectedCount($table_name, $where_column1, $where_column2, $where_value1, $where_value2)
    {
        $sql = "SELECT * FROM $table_name WHERE $where_column1 = '$where_value1' && $where_column2 = '$where_value2'";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return sizeof($result);
    }

    /**
     * <p>This method queries the number of columns with the specified data</p>
     * @param $table_name - the table to perform a query at
     * @param $where_column1 - one of the columns to be tested
     * @param $where_column2 - the other column to be tested
     * @param $where_value1 - value for the first column
     * @param $where_value2 - value for the other comn
     * @return array Returns the array of rows found
     */
    function getDetails2($table_name, $where_column1, $where_column2, $where_value1, $where_value2)
    {
        $sql = "SELECT * FROM $table_name WHERE $where_column1 = '$where_value1' && $where_column2 = '$where_value2'";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $result = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    function updateData2($table_name, $set_column, $set_value, $where_column1, $where_column2, $where_value1, $where_value2)
    {
        $sql = "UPDATE $table_name SET $set_column = '$set_value' WHERE $where_column1 ='$where_value1' && $where_column2 = '$where_value2'";
        $updated = mysqli_query($this->connectToServer(), $sql);
        return $updated;
    }

    /** This counts the number of entries in a specific table
     * @param $table_name -The name of the table to count in
     * @return mixed size of the table
     */
    function getTableSize($table_name)
    {
        $sql = "SELECT COUNT(id) AS num_rows FROM $table_name";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $row = mysqli_fetch_object($qry);
        return $row->num_rows;
    }

    /** This method gets the size of the table
     * @param $table_name -The name of the table to count in
     * @param $column -The column where to index
     * @return mixed size of the table
     */
    function getTableSize2($table_name, $column)
    {
        $sql = "SELECT COUNT($column) AS num_rows FROM $table_name";
        $qry = mysqli_query($this->connectToServer(), $sql);
        $row = mysqli_fetch_object($qry);
        return $row->num_rows;
    }

    /** This method deletes a table from a database
     * @param $table_name The name of the table to be deleted
     * @return bool|mysqli_result Returns true on table deleted or false otherwise
     */
    function deleteTable($table_name)
    {
        $sql = "DROP TABLE " . $table_name;
        $qry = mysqli_query($this->connectToServer(), $sql);
        return $qry;
    }
}