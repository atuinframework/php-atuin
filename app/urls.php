<?php
/**
 *  Pages includes.
 *
 *  Pages functions included here will be routed.
 *
 *  WARNING!! The include order is RELEVANT.
 *  When two identical regular expressions are used to define URLs of two
 * distinct pages only the last included will be routed correctly.
 */

/**
 * This section prefix is prepended before each endpoint that follows it.
 *
 * Redefine it in each section file in order to avoid namespace conflicts.
 *
 * Example:
 * $section_prefix = 'home_pkg_';
 *
 * route(
 *      '#^/$#',
 *      'index', function () {

 * });
 *
 * // Actual created endpoint: home_pkg_index
 */
$section_prefix = 'default_';

// auth
require_once('auth/views.php');
require_once('auth/admin.php');

// home
require_once('home/views.php');
require_once('home/admin.php');

