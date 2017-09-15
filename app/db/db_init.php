<?php
require_once('libs/db/DBConnection.class.php');
require_once('db/DBSampleInterface.class.php');

$persistent = !DEBUG;

// Connection to the database
$DBConnection = new DBConnection($DB_CONNECTION_PARAMS, $persistent);
// Global database connector
$db = new DBSampleInterface($DBConnection);

?>
