<?php
require_once("libs/utility/arrays.php");

/**
 * Returns the type of the passed variable.
 *
 * @param mixed $var Variable.
 * @return string Type of variable.
 */
function get_type($var)
{
    if (is_object($var)) return get_class($var);
    if (is_null($var)) return "NULL";
    if (is_array($var)) return "array";
    if (is_bool($var)) return "boolean";
    if (is_float($var)) return "float";
    if (is_int($var)) return "integer";
    if (is_numeric($var)) return "numeric";
    if (is_resource($var)) return "resource";
    if (is_string($var)) return "string";
    return "unknown type";
}

/**
 * Dump the given data into the page. Useful for debug purposes.
 *
 * @return int
 */
function data_dump()
{
    $prev_dd = array_safe_get($_SESSION["data_dump"], array());
    $_SESSION["data_dump"] = array_merge($prev_dd, func_get_args());
    return 0;
}
