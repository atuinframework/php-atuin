<?php

$section_prefix = 'atuin_auth_';

/**
 * Initialize an anonymous user if no user is logged in.
 */
$anonymous = array(
    'role'=>'ANONYMOUS',
    'logged_in'=>false,
    'last_activity_timestamp'=>time(),
    'last_activity_timestamp_iso8601'=>date(DATE_ISO8601)
);
$current_user = array_safe_get($_SESSION['current_user'], $anonymous);

route(
    '#^/auth/login$#',
    'login',
    function () {
        $_SESSION['current_user'] = array(
            'role'=>'ADMIN',
            'logged_in'=>true,
            'last_activity_timestamp'=>time(),
            'last_activity_timestamp_iso8601'=>date(DATE_ISO8601)
        );

        return redirect(url_for('home_index'));
    }
);

route(
    '#^/auth/logout#',
    'logout',
    function () {
        global $db;
        // $db->log_logout();
        session_unset();
        session_destroy();
        return redirect(url_for('home_index'));
    }
);
