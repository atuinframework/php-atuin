<?php
require_once('libs/utility/service.php');

/**
 * Pretty print of arguments.
 *
 * Arguments are printed in the page, where the function is called, in the
 * most understandable way possible.
 *
 * @param [$string, $int, $array, $mixed, ...] Variables to print.
 */
function pprint()
{
    /* Pretty print of arguments */
    $arr = func_get_args();

    // normalize data to be printed
    array_walk_recursive($arr, 'walkingPrintify');

    echo "\n<hr>\n";
    foreach ($arr as $v) {
        echo "\n<pre style=\"background-color: #FFFFFF !important; ".
            "color:#000000 !important; margin-bottom: 15px;\">\n";
        print_r($v);
        echo "\n</pre>\n";
    }
    echo "\n<hr style=\"margin-bottom:15px;\">\n";
}

/**
 * Escape both the symbols: < >
 *
 * @param string $str String to which apply the escaping.
 */
function escapeGtTLt(&$str)
{
    $str = str_replace('>', '&gt;', $str);
    $str = str_replace('<', '&lt;', $str);
}

/**
 * Converts the variables that are hard to be seen when printed in a better
 * understandable form.
 *
 * @param mixed $v Variable to convert.
 */
function printify(&$v)
{
    $varType = get_type($v);
    if ($varType == 'NULL') {
        $v = "<b><i>NULL</i></b>";
    }
    elseif ($varType == "boolean") {
        $v = $v ? 'true' : 'false';
        $v = "<b><i>{$v}</i></b>";
    }
    elseif ($varType == "string" && empty($v)) {
        $v = "<b><i>empty_string</i></b>";
    }
}

/**
 * Apply escapeGtTLt and printify functions to both passed values.
 *
 * @param mixed $k Key
 * @param mixed $v Value
 */
function walkingPrintify(&$k, &$v)
{
    escapeGtTLt($k);
    escapeGtTLt($v);
    printify($k);
    printify($v);
}
