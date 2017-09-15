<?php
/**
 * Functions useful to handle arrays.
 */

/**
 * Group the arrays by the value which they associate with the specified key.
 *
 * Return an array of arrays of which:
 *   - Keys are the values, for each array of those given, that are
 * associated to the given key.
 *   - Values are the originals arrays.
 *
 *
 * Example:
 * $arr_to_group = array(
 *      array('sub_key'=>'a', 'val'=>42),
 *      array('sub_key'=>'b', 'val'=>43),
 *      array('sub_key'=>'a', 'val'=>44)
 * );
 *
 * $grouped_array = array_group_by($arr_to_group, 'sub_key');
 *
 * print_r($grouped_array);
 * Array
 * (
 *      [a] => Array
 *          (
 *              Array('sub_key'=>'a', 'val'=>42),
 *              Array('sub_key'=>'a', 'val'=>44)
 *          )
 *      [b] => Array(
 *          (
 *              Array('sub_key'=>'b', 'val'=>43),
 *          )
 * )
 *
 * @param array(array(...), array(...), ...) $array
 * @param $key
 * @return array
 */
function array_group_by($array, $key)
{
    $return = array();
    foreach($array as $val) {
        $return[$val[$key]][] = $val;
    }
    return $return;
}

/**
 * As the '@' sign PHP Error Control Operator but if key is not found return
 * the default value.
 *
 * Example:
 * $safe_val1 = array_safe_get($my_arr['k']);
 * $safe_val2 = array_safe_get($my_arr['k'], 'default_val');
 *
 * @param mixed $var The array position at which retrieve the value.
 * @param mixed $default Default returned value. Its default is null.
 * @return mixed The value of the array. Null if not present.
 */
function array_safe_get(&$var, $default=null)
{
    return isset($var) ? $var : $default;
}
