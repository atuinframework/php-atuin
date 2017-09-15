<?php
/**
 * Roles define classes of users. Each user has to be assigned at least (and
 * at most) to one role.
 * A role defines multiple policies. Policies can be used in more than one role.
 * A policy is a group of functions.
 */

$USER_ROLE_POLICIES = array(
    'ADMIN'=>array(
        'title'=>'Administrator',
        'description'=>'Administrator. All rights.',
        'policies'=>null
    ),
    'GUEST'=>array(
        'title'=>'Guest',
        'description'=>'A guest user logged in but without any particular privilege.',
        'policies'=>null
    )
);

$ROLE_POLICIES_FUNCTIONS = array();

$USER_ROLES = array_keys($USER_ROLE_POLICIES);

?>
