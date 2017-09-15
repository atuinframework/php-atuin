<?php
// session and permissions check
if (!empty($page['roles'])) {
    $user_role = $current_user['role'];
    $user_logged_id = $current_user['logged_in'];
    $last_activity_timestamp = $current_user['last_activity_timestamp'];

    $inactivity_time_interval = time() - $last_activity_timestamp;

    // check if logged in
    if (
        $user_logged_id == true &&
        $inactivity_time_interval < SESSION_EXPIRE_TIME &&
        in_array($user_role, $page['roles'])
    ) {
        $_SESSION['current_user']['last_activity_timestamp'] = time();
        $_SESSION['current_user']['last_activity_timestamp_iso8601'] =
            date(DATE_ISO8601);
    } else {
        // User wants to access a protected page URL and:
        // - he/she is not logged in
        // - session is expired
        // - the user doesn't have the rights
        if (!$user_logged_id){
            handle_response(render_template('atuin/service/403.php'));
        }
        if ($inactivity_time_interval > SESSION_EXPIRE_TIME) {
            // delete the session
            session_unset();
            session_destroy();
            handle_response(redirect(url_for('home_index')));
        }
        handle_response(render_template('atuin/service/403.php') );
    }
}
