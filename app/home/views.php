<?php

$section_prefix = 'home_';

route(
    '#^/$#',
    'index',
    function () {
        return render_template('home/index.php');
    }
);


route(
    '#^/redirect$#',
    'redirect',
    function () {
        flash_message('Message from <a href="/redirect">/redirect</a> page!');
        return redirect(url_for('admin_home_experiments'));
    }
);
