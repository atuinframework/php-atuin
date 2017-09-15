<?php
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);

$error_config_file_missing = <<<EOT
		<h2>ATUIN ERROR</h2>
		<h4>Configuration file is missing.</h4>
		<p>
			Please create the file <code>app/config.php</code> starting from the
			file <code>app/config.tpl.php</code>.
		</p>
EOT;

/* import configs */
if (file_exists('config.php' )) {
    require_once('config.php');
} else {
	die($error_config_file_missing);
}

if (DEBUG) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

/* import version */
if (file_exists('version.php' )) {
    require_once('version.php');
} else {
    die('No file app/version.php found.');
}

/* import languages */
if (file_exists('languages.php' )) {
    require_once('languages.php');
} else {
    die('No file app/languages.php found.');
}
if (!MULTILANGUAGE) {
    define('SITE_LANGUAGE', $MULTILANGUAGE_LANGS[0]);
} else {
    // TODO
}

session_start();

/* using specific headers */
header('Content-Type: text/html; charset=utf-8');

/* setting locales */
setlocale(LC_TIME, '');
setlocale(LC_TIME, 'en', 'en_US');
date_default_timezone_set('Europe/Rome');


/* FATAL HANDLER to handle not-catching exceptions */
register_shutdown_function("fatal_handler", DEBUG);
function fatal_handler($DEBUG) {
    $error = error_get_last();

    $errno   = $error["type"];
    $errfile = $error["file"];
    $errline = $error["line"];
    $errstr  = $error["message"];

    if (!in_array($errno, array(E_ERROR,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_USER_ERROR
    ))) {
        return $errno;
    }

    if (DEBUG != true) { die("ERROR"); }

    $errfile = substr($errfile, strlen(getcwd()));
    $msg = '<pre style="font-weight: bold;font-size: 2em; line-height: 2em;background-color: #000000; color:#FFFFFF;">' . "
			
			[TYPE] $errno
			[FILE] $errfile
			[LINE] $errline
			[DESC] $errstr
		</pre>";
    die($msg);
}

/* include all utilities */
require_once("libs/utility/all.php");

/* include permission_policies */
require_once('permission_policies.php');

/* initialize db */
require_once("db/db_init.php");

/* debug operator handle */
if (DEBUG == true and !empty($_SESSION["data_dump"])) {
    pprint($_SESSION["data_dump"]);
}
unset($_SESSION["data_dump"]);

// main page variable
$p = array('blocks' => array());

/* routing engine */
require_once('router/engine.php');

?>
