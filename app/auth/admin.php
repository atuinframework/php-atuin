<?php

$section_prefix = 'admin_auth_';

route(
    '#^/admin/auth/users$#',
    array('ADMIN'),
    'users',
    function () {
        flash_message("Users section still to be implemented!");

        return redirect(url_for('admin_home_index'));
    }
);
