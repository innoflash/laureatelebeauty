<?php
/**
 * Created by PhpStorm.
 * User: SAYWHAT
 * Date: 5/13/2016
 * Time: 9:46 AM
 */
require_once('Optimizer.php');

class AJAX_Optimizer extends Optimizer {

    /**
     * @param $table_name This is the table you wish to update in
     * @param array $identify_key_value_pairs This will be the column-value associative array for the WHERE clause
     * @param array $set_key_value_pairs This will be the column-value asociative array for the SET clause
     * @return string echos success on updated and failure on failure
     */
    function updateExactDataAJAX($table_name, $identify_key_value_pairs = array(), $set_key_value_pairs )
    {
        $updated = $this->updateExactData($table_name, $identify_key_value_pairs, $set_key_value_pairs);
        if ($updated) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }


    /** This deletes a target that requires a lot of data specification
     * @param $table_name This is the name of the table you want to delete from
     * @return bool|mysqli_result Returns true if deleted or false when not deleted
     * @param array $delete_key_value_pairs This is the an associative array of columns and values to find and match
     * e.g <br/>
     * $kvp = [<br/>
     * 'table'=>'my_table',<br/>
     * 'col_one' => 'col_value',<br/>
     * 'col_two' => 'col_value2',<br/>
     * 'col_three' => 'col_value3',<br/>
     * 'col_four' => 'col_value4',<br/>
     * ]
     */
    function deleteExactDataAJAX($table_name, $delete_key_value_pairs = array())
    {
        $deleted = $this->deleteExactData($table_name, $delete_key_value_pairs);
        if ($deleted) {
            echo 'success';
        } else {
            echo 'failure';
        }
    }

    function insertDataAjax($table_name, $insertData)
    {
        $inserted = $this->insertExactData($table_name, $insertData);
        if ($inserted) {
            echo 'success';
        } else {
            echo 'failed to insert';
        }
    }

    function updateDataAjax($table_name, $set_column, $set_value, $where_column, $where_value)
    {
        $updated = $this->updateData($table_name, $set_column, $set_value, $where_column, $where_value);
        if ($updated) {
            echo 'success';
        } else {
            echo 'failed to update data';
        }
    }
}