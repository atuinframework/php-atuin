<?php
/** Include routing functions */
require_once('router/functions.php');

/**
 * Include all pages.
 *
 * This load all the defined routes.
 */
require_once('urls.php');

$current_path = explode('?', $_SERVER['REQUEST_URI'])[0];

$rpath_vars = array();
$page_data = search_page($current_path, $rpath_vars);

// if the route does not exists
if ($page_data === null) {
    handle_response(render_template('atuin/service/404.php'));
}

// check the session validity and permissions of the user to access the page
require_once('auth/session_permissions_check.php');

try {
    // inside the page function, it's possible to: global $current_path;
    $response = call_user_func_array($page_data['clojure'], $rpath_vars);
    handle_response($response);
}
catch (Exception $e) {
    if (DEBUG) {
        data_dump('GENERIC_ERROR', array(
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "code" => $e->getCode(),
            "message" => $e->getMessage(),
            "trace" => $e->getTrace()
        ));
    }
    handle_response(render_template('atuin/service/500.php'));
}
