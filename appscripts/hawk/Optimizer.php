<?php
/**
 * Created by PhpStorm.
 * User: SAYWHAT
 * Date: 5/12/2016
 * Time: 3:56 PM
 */
require('DBHelper.php');

class Optimizer extends DBHelper
{
    /** This selects selected (exact) fields from a table
     * @param array $table_options The basic table details for a query, <br/>
     * eg. <ul>
     * <li>'table'=>'my_table',</li>
     * <li>'order'=>'DESC/ASC',</li>
     * <li>'order'_by=>'date',</li>
     * <li>'limit'=>400</li>
     * </ul>
     * @param array $columns The columns to return e.g <br>
     * $columns = [
     * <ul>
     * <li>'column_one'</li>
     * <li>'column_two'</li>
     * <li>'column_three'</li>
     * </ul>
     * ]
     * @param $key_value_pairs The fields for WHERE clause (use an associative array) e.g
     * $kvp = [<br/>
     * 'col_one' => 'col_value',<br/>
     * 'col_two' => 'col_value2',<br/>
     * 'col_three' => 'col_value3',<br/>
     * 'col_four' => 'col_value4',<br/>
     * ]
     * @return array Returns an array of your query
     */
    function selectExactData($table_options = array(), $columns = array(), $key_value_pairs)
    {
        $result = array();
        $table_name = $table_options['table'];
        $order = $table_options['order'];
        $order_by = $table_options['order_by'];

        if (isset($table_options['limit'])) {
            $limit = $table_options['limit'];
        } else {
            $limit = 1000000;
        }

        $columns = $this->generateColumns($columns);

        $kvp = $this->generateKeyValuePairs($key_value_pairs);

        if (sizeof($key_value_pairs) == 0) {
            $sql = "SELECT $columns FROM $table_name ORDER BY $order_by $order  LIMIT 0, $limit";
        } else {
            $sql = "SELECT $columns FROM $table_name WHERE $kvp ORDER BY $order_by $order  LIMIT 0, $limit";
        }
        $qry = mysqli_query($this->connectToServer(), $sql);

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
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
    function deleteExactData($table_name, $delete_key_value_pairs = array())
    {
        $kvp = $this->generateKeyValuePairs($delete_key_value_pairs);

        $sql = "DELETE FROM $table_name WHERE $kvp";
        $deleted = mysqli_query($this->connectToServer(), $sql);
        return $deleted;
    }

    /**
     * @param $table_name This is the table you wish to update in
     * @param array $identify_key_value_pairs This will be the column-value associative array for the WHERE clause
     * @param array $set_key_value_pairs This will be the column-value associative array for the SET clause
     * @return bool|mysqli_result Returns true when updated and false if not updated
     */
    function updateExactData($table_name, $identify_key_value_pairs = array(), $set_key_value_pairs = array())
    {
        $where_cols = $this->generateKeyValuePairs($identify_key_value_pairs);
        $set_cols = $this->generateSetValues($set_key_value_pairs);

        $sql = "UPDATE $table_name SET $set_cols WHERE $where_cols";
        $updated = mysqli_query($this->connectToServer(), $sql);
        return $updated;
    }

    /** This joins two tables and map them together to give only one result set to work with
     * @param array $table_columns An associative array of the two tables containing an array of columns to be found for that table
     * eg. <ul>
     * <li>'ufic_members' => [
     * <ul>
     * 'first_name',
     * 'zone'
     * </ul>
     * ],</li>
     * <li>'statistics' => [
     * <ul>
     * 'member_id',
     * 'member_name'
     * </ul>
     * ]</li>
     * </ul>
     * @param array $from_join_tables An associative array of values that you want to match from both tables when joined
     * eg. <ul>
     * <li>'first_table'=>'my_column1',</li>
     * <li>'second_table'=>'my_column2',</li>
     * </ul>
     * @param array $whereValue An associative array with three items
     * eg. <ul>
     * <li>'table'=>'my_table',</li>
     * <li>'column'=>'my_column',</li>
     * <li>'value'_by=>1, //preferably an integer</li>
     * </ul>
     * @return array An array of results found for both tables
     */
    function selectJoinedData($table_columns = array(), $from_join_tables = array(), $whereValue = array())
    {
        $result = array();
        $sql = '';
        if (sizeof($whereValue) == 0) {
            $sql = "SELECT " . $this->generateJointColumns($table_columns) . " FROM " . $this->generateJointJoin($table_columns)[0] . " JOIN " . $this->generateJointJoin($table_columns)[1] . " ON " . $this->generateJointOn($from_join_tables) . "";
        } else {
            $sql = "SELECT " . $this->generateJointColumns($table_columns) . " FROM " . $this->generateJointJoin($table_columns)[0] . " JOIN " . $this->generateJointJoin($table_columns)[1] . " ON " . $this->generateJointOn($from_join_tables) . " WHERE " . $this->generateJointWhere($whereValue) . "";
        }
        // $sql = "SELECT * FROM statistics";
        $qry = mysqli_query($this->connectToServer(), $sql);
        if (!$qry) {
            die('Could not get data: ' . mysqli_error($this->connectToServer()));
        } else {
            while ($row = mysqli_fetch_assoc($qry)) {
                $result[] = array_map('utf8_encode', $row);
            }
        }

        return $result;

    }

    function insertExactData($table_name, $insertData = array())
    {
        $insertColumns = $this->generateInsertColumns($insertData);
        $insertValues = $this->generateInsertValues($insertData);

        $sql = 'INSERT INTO ' . $table_name . ' (' . $insertColumns . ')' . ' VALUES (' . $insertValues . ')';
        $inserted = mysqli_query($this->connectToServer(), $sql);
        return $inserted;
    }

    function selectLikeDataExact($table_options = array(), $columns = array(), $key_value_pairs = array())
    {
        $result = array();
        $table_name = $table_options['table'];
        $order = $table_options['order'];
        $order_by = $table_options['order_by'];

        if (isset($table_options['limit'])) {
            $limit = $table_options['limit'];
        } else {
            $limit = 10000;
        }

        $columns = $this->generateColumns($columns);
        $kvp = $this->generateLikePairs($key_value_pairs);

        if (sizeof($key_value_pairs) == 0) {
            $sql = "SELECT $columns FROM $table_name ORDER BY $order_by $order  LIMIT 0, $limit";
        } else {
            $sql = "SELECT $columns FROM $table_name WHERE $kvp ORDER BY $order_by $order  LIMIT 0, $limit";
        }
        $qry = mysqli_query($this->connectToServer(), $sql);

        while ($row = mysqli_fetch_assoc($qry)) {
            $result[] = array_map('utf8_encode', $row);
        }
        return $result;
    }

    private function generateSetValues($set_key_value_pairs)
    {
        $newString = '';
        while ($myKey = current($set_key_value_pairs)) {
            $key = key($set_key_value_pairs);
            $value = $set_key_value_pairs[$key];
            if (sizeof($set_key_value_pairs) == 1) {
                $newString = "$key" . ' = ' . "'$value'";
            } else {
                foreach ($set_key_value_pairs as $KEY => $kvp) {
                    $newString = $newString . "$KEY" . ' = ' . "'$kvp'" . ', ';
                }
            }
            $len = strlen($newString);
            $last_chars = substr($newString, $len - 2);
            if (strcmp($last_chars, ', ') == 0) {
                $newString = substr($newString, 0, $len - 2);
            } else {

            }
            next($set_key_value_pairs);
        }
        return $newString;
    }

    private function generateJointColumns($tableColumns = array())
    {
        $finalCOLS = '';
        foreach ($tableColumns as $key => $data) {
            $table = $key;
            $returnText = '';
            if (sizeof($data) == 0) {
                $returnText = '`' . $table . '`.*, ';
            } else if (sizeof($data) == 1) {
                $returnText = '`' . $table . '`.' . '`' . $data[0] . '`, ';
            } else {
                foreach ($data as $single_item) {
                    $returnText = $returnText . '`' . $table . '`.' . '`' . $single_item . '`, ';
                }
            }
            $finalCOLS = $finalCOLS . $returnText;
        }
        $len = strlen($finalCOLS);
        $last_chars = substr($finalCOLS, $len - 2);
        if (strcmp($last_chars, ', ') == 0) {
            $finalCOLS = substr($finalCOLS, 0, $len - 2);
        }

        return $finalCOLS;
    }

    private function generateJointJoin($tableColumns = array())
    {
        $tables = array();
        foreach ($tableColumns as $key => $table) {
            array_push($tables, '`' . $key . '`');
        }
        return $tables;
    }

    private function generateJointOn($onData = array())
    {
        $returnText = '';
        $index = 0;

        foreach ($onData as $key => $data) {
            if ($index == 0) {
                $returnText = '`' . $key . '`.' . '`' . $data . '`=';
            } else {
                $returnText = $returnText . '`' . $key . '`.' . '`' . $data . '`';
            }
            $index++;
        }
        return $returnText;
    }

    private function generateJointWhere($whereValues = array())
    {
        $returnText = '`' . $whereValues['table'] . '`.' . '`' . $whereValues['column'] . '`=' . $whereValues['value'];

        return $returnText;
    }

    private function generateColumns($columns = array())
    {
        $newString = '';
        if (sizeof($columns) == 0) {
            return '*';
        } else {
            if (sizeof($columns) == 1) {
                return $columns[0];
            } else {
                foreach ($columns as $key => $column) {
                    if ($key == sizeof($columns) - 1) {
                        $newString = $newString . $column;
                    } else {
                        $newString = $newString . $column . ', ';
                    }

                }
                return $newString;
            }
        }
    }

    private function generateKeyValuePairs($key_value_pairs)
    {
        $newString = '';
        while ($myKey = current($key_value_pairs)) {
            $key = key($key_value_pairs);
            $value = $key_value_pairs[$key];
            if (sizeof($key_value_pairs) == 1) {
                $newString = "$key" . ' = ' . "'$value'";
            } else {
                foreach ($key_value_pairs as $KEY => $kvp) {
                    $newString = $newString . "$KEY" . ' = ' . "'$kvp'" . ' && ';
                }
            }
            $len = strlen($newString);
            $last_chars = substr($newString, $len - 4);
            if (strcmp($last_chars, ' && ') == 0) {
                $newString = substr($newString, 0, $len - 4);
            } else {

            }
            next($key_value_pairs);
        }
        return $newString;
    }

    private function generateLikePairs($key_value_pairs)
    {
        $newString = '';
        while ($myKey = current($key_value_pairs)) {
            $key = key($key_value_pairs);
            $value = $key_value_pairs[$key];
            if (sizeof($key_value_pairs) == 1) {
                $newString = "$key" . ' LIKE ' . "'%$value%'";
            } else {
                foreach ($key_value_pairs as $KEY => $kvp) {
                    $newString = $newString . "$KEY" . ' LIKE ' . "'%$kvp%'" . ' && ';
                }
            }
            $len = strlen($newString);
            $last_chars = substr($newString, $len - 4);
            if (strcmp($last_chars, ' && ') == 0) {
                $newString = substr($newString, 0, $len - 4);
            } else {

            }
            next($key_value_pairs);
        }
        return $newString;
    }

    private function generateInsertColumns($key_value_pairs = array())
    {
        $newString = '';
        if (sizeof($key_value_pairs) == 0) {
            return '*';
        } else {
            if (sizeof($key_value_pairs) == 1) {
                return $key_value_pairs[0];
            } else {
                foreach ($key_value_pairs as $key => $column) {
                    /*   $position = array_search($column, array_values($key_value_pairs));
                       if ($position == 0) {
                       }*/
                    if ($key == sizeof($key_value_pairs) - 1) {
                        $newString = $newString . $key;
                    } else {
                        $newString = $newString . $key . ', ';
                    }

                }
                return substr($newString, 0, strlen($newString) - 2);
            }
        }
    }

    private function generateInsertValues($insertData)
    {
        $newString = '';
        if (sizeof($insertData) == 0) {
            return '*';
        } else {
            if (sizeof($insertData) == 1) {
                return $insertData[0];
            } else {
                foreach ($insertData as $key => $column) {
                       $position = array_search($column, array_values($insertData));
                       if ($position == 0) {
                           $newString = 'NULL,';
                       } else {
                           if ($key == sizeof($insertData) - 1) {
                               $newString = $newString . $column;
                           } else {
                               $newString = $newString . "'" . $column . "', ";
                           }
                       }


                }
                return substr($newString, 0, strlen($newString) - 2);
            }
        }
    }
}