<?php

$section_prefix = 'admin_home_';

route(
    '#^/admin$#',
    array('ADMIN'),
    'index',
    function () {
        return render_template(
            'home/admin/index.php',
            array('menuid'=>'adminarea')
        );
    }
);


route(
    '#^/admin/experiments-lab$#',
    '#^/admin/experiments-lab/string/(?P<string>[-\w]*)$#',
    '#^/admin/experiments-lab/sum/(?P<num1>\d+)/(?P<num2>\d+)$#',
    array('ADMIN'),
    'experiments',
    function ($arg1=null, $arg2=null) {

        $new_string = null;
        if ($arg1 !== null && $arg2 == null) {
            $new_string = "--- ".strtolower($arg1)." ---";
        }

        $sum = null;
        if ($arg1 !== null && $arg2 != null) {
            $sum = $arg1 + $arg2;
        }

        return render_template(
            'home/admin/experiments.php',
            array(
                'menuid'=>'experiments',
                'arg1' => $arg1,
                'arg2' => $arg2,
                'injected_string'=>$new_string,
                'cumputed_sum'=>$sum
            )
        );
    }
);
