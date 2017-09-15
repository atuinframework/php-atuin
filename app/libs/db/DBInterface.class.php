<?php

require_once('libs/utility/service.php');

class DBInterface
{
    private $DBConnection;
    private $lastQuery;
    private $lastInsertID;

    function __construct($DBConnection)
    {
        if (!is_a($DBConnection, 'DBConnection')) {
            $errorMsg = '[DB INTERFACE ERROR] Passed DBConnection object is '.
                'not an instance of DBConnection class.';
            die($errorMsg);
        }
        $this->DBConnection = $DBConnection;
    }

    function backticks_wrap(&$item)
    {
        $item = "`$item`";
    }

    /**
     * Normalize and sanitize an array of values.
     *
     * Strings are sanitized and wrapped by double quotes.
     * Booleans are converted to respective keywords.
     * Null values are converted to the respective keyword.
     *
     * @param mixed $v Value to queryfy.
     */
    function queryfyValue(&$v)
    {
        // is it boolean ?
        if (get_type($v) == "boolean") {
            $v = $v ? 'TRUE' : 'FALSE';
            return;
        }

        // is it null ?
        if (get_type($v) == "NULL") {
            $v = 'NULL';
            return;
        }

        // is it string ?
        if (get_type($v) == "string") {
            $v = addslashes($v);
            $v = '"'.$v.'"';
            return;
        }
    }

    /**
     * Error handler for MySQLi errors.
     *
     * @param string $errInfo Customizable info error.
     */
    function handleMySQLiError($errInfo="Query execution error: ")
    {
        $errorMsg = $this->DBConnection->getDB()->error;
        if ($errorMsg) {
            $errorMsg =
                "<h3>MYSQLI ERROR</h3>".
                $this->lastQuery."\n<br>\n<br>".
                $errInfo.
                $errorMsg;

            if (DEBUG !== true) {
                $errorMsg = 'ERROR';
            }
            die($errorMsg);
        }
    }

    /**
     * SQL insert statement wrapper.
     *
     * Helper to built the SQL query.
     * $fields = array(string, string, ...);
     * $multiValues = ( array(array(str, str, ..), array(str, str, ..), ...) |
     *                  array(str, str, ...) )
     *
     * @param string $table Table name.
     * @param array $fields Name of the fields.
     * @param array $multiValues Array of values or array of arrays of values.
     * @param string $insertReplace Execute a INSERT or REPLACE.
     * @return int Last inserted id.
     */
    function insert($table, $fields, $multiValues, $insertReplace="INSERT")
    {
        if (get_type($multiValues[0]) != 'array') {
            $multiValues = array($multiValues);
        }

        $query = $insertReplace;
        $query .= " INTO `$table`";

        if (!empty($fields)) {
            array_walk($fields, array($this, 'backticks_wrap'));
            $query .= " (".implode(", ", $fields).")";
        }

        $prepValues = array();
        foreach ($multiValues as $k => $values) {
            // prepare values for the query
            array_walk($values, array($this, 'queryfyValue'));
            // join values for each record
            $valuesString = implode(', ', $values);
            $prepValues[] = " ({$valuesString})";
        }
        $query .= " VALUES".implode(', ', $prepValues).";";

        pprint($query);
        $this->lastQuery = $query;
        $this->DBConnection->exec($this->lastQuery);
        $this->handleMySQLiError();

        $this->lastInsertID = mysqli_insert_id($this->DBConnection->getDB());
        return $this->lastInsertID;
    }

    /**
     * Insert by the associative array $kv_fields of which:
     *  - keys are used as fields names.
     *  - values are (inserted|replaced).
     *
     * @param string $table Table name.
     * @param array $kv_fields Associative array fields' names, values.
     * @param string $insertReplace Execute a INSERT or REPLACE.
     * @return int Last inserted id.
     */
    function insert_kv($table, $kv_fields, $insertReplace = "INSERT")
    {
        $fields = array_keys($kv_fields);
        return $this->insert($table, $fields, array($kv_fields), $insertReplace);
    }

    /**
     * Create an insert prepare statement.
     *
     * $fields = array('name', 'surname', 'age', 'address');
     * $types = "(i|d|s|b)+";
     *    i    corresponding variable has type integer
     *    d    corresponding variable has type double
     *    s    corresponding variable has type string
     *    b    corresponding variable is a blob and will be sent in packets
     *
     * @param string $table Table name.
     * @param array $fields Fields names.
     * @param string $types_string Definition of types of values for each field.
     * @param string $insertReplace (INSERT|REPLACE) Which SQL action to use.
     * @return array The statement object.
     */
    function ps_create_insert(
        $table, $fields, $types_string, $insertReplace = 'INSERT')
    {
        array_walk($fields, array($this, 'backticks_wrap'));
        $fieldsList = join(',', $fields);
        $paramsList = join(
            ',',
            array_fill(0, count($fields), '?')
        );

        $query = $insertReplace;
        $query .= " INTO `$table` ($fieldsList) VALUES ($paramsList);";

        $this->lastQuery = $query;
        $stmt = $this->DBConnection->getDB()->prepare($this->lastQuery);
        $this->handleMySQLiError("Prepare statement creation: ");

        $params = array();
        // fill $params with distinct references of empty strings
        $placeHolders = array_fill(0, count($fields), '');
        for ($i = 0; $i < count($fields); $i++) {
            $params[$i] = &$placeHolders[$i];
        }
        array_unshift($params, $types_string);
        call_user_func_array(array($stmt, 'bind_param'), $params);
        return array($stmt, $params);
    }

    /**
     * Execute a prepared statement.
     *
     * @param object $stmt Statement object.
     * @param array $values Values to insert according to the fields definition.
     * @return mixed Statement execution result.
     */
    function ps_exec($stmt, $values)
    {
        $params = $stmt[1];
        //set params as new values
        foreach ($values as $idx => $v) {
            $params[$idx + 1] = addslashes($v); // reasonable to add slashes?
        }
        $res = $stmt[0]->execute();
        if (!$res) {
            $errorMsg =
                '<h3>MYSQLI STATEMENT ERROR<h3>'.
                'Prepared statement execution error: '.
                $stmt[0]->error;
            if (DEBUG !== true) {
                $errorMsg = 'ERROR';
            }
            die($errorMsg);
        }
        return $res;
    }

    /**
     * Close a statement.
     *
     * @param object $stmt Statement object.
     * @return mixed Closing function result.
     */
    function ps_close($stmt)
    {
        return $stmt[0]->close();
    }

    /**
     * SQL update statement wrapper.
     *
     * @param string $table Table name.
     * @param array $fields Array of fields' names.
     * @param array $values Array with new values.
     * @param string $clause SQL clause string: WHERE, HAVING, ..
     * @return mixed Query result.
     */
    function update($table, $fields, $values, $clause = "")
    {
        array_walk($fields, array($this, 'backticks_wrap'));
        array_walk($values, array($this, 'queryfyValue'));

        $fieldValues = array();
        foreach ($fields as $idx => $field) {
            $fieldValues[] = "{$field}={$values[$idx]}";
        }

        $query = "UPDATE `$table` SET ";
        $query .= implode(", ", $fieldValues)." ";
        $query .= $clause;
        $query .= ";";

        $this->lastQuery = $query;
        $res = $this->DBConnection->exec($this->lastQuery);
        $this->handleMySQLiError();

        return $res;
    }

    /**
     * Update by the associative array $kv_fields of which:
     *  - keys are used as fields names.
     *  - values are (inserted|replaced).
     *
     * @param string $table Table name.
     * @param array $kv_fields Associative array fields' names, values.
     * @param string $clause SQL clause string: WHERE, HAVING, ..
     * @return mixed Query result.
     */
    function update_kv($table, $kv_fields, $clause="")
    {
        $fields = array_keys($kv_fields);
        // due to how update function works
        $fields = array_combine($fields, $fields);
        return $this->update($table, $fields, $kv_fields, $clause);
    }

    /**
     * Update by the associative array $kv_fields of which:
     *  - keys are used as fields names.
     *  - values are (inserted|replaced).
     *
     * @param string $table Table name.
     * @param array $kv_fields Associative array fields' names, values.
     * @param string $clause SQL clause string: WHERE, HAVING, ..
     * @return mixed Query result.
     */

    /**
     * SQL delete statement wrapper.
     *
     * @param string $table Table name.
     * @param string $clause SQL clause string: WHERE, HAVING, ..
     * @return mixed Query result.
     */
    function delete($table, $clause="")
    {
        $query = "DELETE FROM `{$table}` {$clause};";
        $this->lastQuery = $query;
        $res = $this->DBConnection->exec($this->lastQuery);
        $this->handleMySQLiError();
        return $res;
    }
}
