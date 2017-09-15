<?php
/**
 * Debug mode. If true errors and data dumps are printed.
 */
define('DEBUG', true);


/**
 * Secret key. Randomize it for each project.
 */
define('SECRET_KEY', 's0m3^rand0m^stuff');


/**
 * Session timeout in seconds.
 */
define('SESSION_EXPIRE_TIME', 60*30);


/**
 * Website title.
 */
define('SITE_TITLE', "PHP Atuin framework");


/**
 * Multi language support.
 */
define('MULTILANGUAGE', false);


/**
 * Array of supported languages.
 *
 * The first language is used for both multi language websites and
 * single language websites as the default routing language.
 */
$MULTILANGUAGE_LANGS = array('en'); //, 'it', 'es');

/**
 * Cache configuration. Considered only if $DEBUG == false.
 */
define('CACHE_TYPE', '');

/**
 * Cache default expiration time.
 */
define('CACHE_DEFAULT_TIME', 60 * 60 * 24);


/**
 * Force the website to redirect to https.
 */
define('FORCE_HTTPS', false);

/**
 * Database access parameters.
 */
$DB_CONNECTION_PARAMS = array(
	"host" => "mariadbhost",
	"username" => "username",
	"password" => "password",
	"port" => 3306,
	"database" => "db_name"
);
