<?php
$version = array(0, 0, 1);
$varsion_date = array(15, 9, 2017);

$version_string = sprintf(
    "%s.%s.%s",
    $version[0],
    $version[1],
    $version[2]
);

$version_date_string = sprintf(
    "%s.%s.%s",
    $varsion_date[0],
    $varsion_date[1],
    $varsion_date[2]
);

$version_full_string =  sprintf("%s - %s", $version_string,
    $version_date_string);

define('SITE_VERSION', $version_string);
define('SITE_VERSION_DATE', $version_date_string);
define('SITE_VERSION_FULL', $version_full_string);