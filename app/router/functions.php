<?php
// association table routes -> pages
$table_route_page = array();
// association table endpoints -> pages
$table_endpoint_page = array();

/**
 * Route definition. Variadic function.
 *
 * This function expects as arguments:
 *  - any number of strings (at least 1): Regular expressions that define the
 * valid URLs for the page.
 *  - [Optional. third last parameter: array Roles that can access the page.
 *  - second last parameter: string The page endpoint name.
 *  - last parameter: function The page handler.
 *
 * Example:
 *   route(
 *       '#^/$#',
 *       '#^/(?P<id>[0-9]+)$#',
 *       [array('ADMIN', 'GUEST'),]
 *       'home_index',
 *       function ($id=null) {
 *          return render_template('home/index.php', array('id'=>$id));
 *       }
 *   );
 *
 * @param string $regex_1 [, $regex_2, ...] Regular expressions defining the
 * URLs patterns.
 * @param string $endpoint The name of the page, the endpoint.
 * @param clojure $function The page function.
 * @return void
 */
function route()
{
    global $section_prefix, $table_route_page, $table_endpoint_page;
    $args = func_get_args();

    $page_clojure = array_pop($args);

    $page_endpoint = $section_prefix.array_pop($args);

    $page_roles = array();
    // check if there's any role defined
    if (get_type(end($args)) == 'array') {
        $page_roles = array_pop($args);
    }

    $routes = array();
    while(($r = array_shift($args)) !== null) { $routes[] = $r; }

    $page_data = array(
        'endpoint'=>$page_endpoint,
        'clojure'=>$page_clojure,
        'roles'=>$page_roles,
        'routes'=>$routes
    );

    // save page in tables, by reference to optimize
    $table_endpoint_page[$page_endpoint] = &$page_data;
    foreach($routes as $r) {
        $table_route_page[$r] = &$page_data;
    }
};


// helper function to build the group name pattern
function _group_name_patter_builder(&$group_name)
{
    $group_name = "\(\?P<{$group_name}>[^\)]+\)";
}

// helper function to build the group name pattern
function _group_name_patter_builder_d(&$group_name)
{
    $group_name = "#\(\?P<{$group_name}>[^\)]+\)#";
}

//
/**
 * Helper function to print in the best way possible the url_for
 * function's errors.
 *
 * @param string $endpoint Endpoint name.
 * @param array $params Params were passed to url_for.
 * @param array $routes Routes eventually found for the endpoint.
 * @param string $msg Error message.
 * @param array $backtrace debug_backtrace() function result.
 */
function _url_for_error($endpoint, $params, $routes, $msg, $backtrace)
{
    echo "\"'><h2>URL_FOR ERROR: $msg</h2>";
    if (empty($params)) {
        echo "<code style=\"font-size:1.2em\">".
            "<i>url_for('{$endpoint}')</i></code>";
    } else {
        echo "<code style=\"font-size:1.2em\"><i>url_for('{$endpoint}', ";
        var_export($params);
        echo ")</i></pre>";
    }

    echo "<h4>INFO</h4>";
    pprint(
        $backtrace[0],
        "endpoint: $endpoint",
        'passed params:',
        $params,
        'available routes:',
        $routes
    );
    die();
}

/**
 * Helper function to search and return the more appropriate regex url.
 *
 * The number and name of groups of the regex must coincide with params' keys.
 * The remaining parameters, matched at least all groups, will be encoded and
 * appended to the generated url as query string.
 *
 * @param array $routes Regex URLs among which look for.
 * @param array $params Parameters to be replaced at groups' definitions.
 * @return null|string Found regex.
 */
function _get_regex_url($routes, $params)
{
    $found_route = null;
    $groups_names = array_keys($params);

    // search for a regex url without any group
    $search_pattern = '#^[^\(\)]+$#';
    foreach ($routes as $route) {
        if (preg_match_all($search_pattern, $route)) {
            $found_route = $route;
            break;
        }
    }

    if (empty($groups_names)) { return $found_route; }

    // convert group names in their pattern
    array_walk($groups_names, '_group_name_patter_builder');

    // search for a regex url that contains the given groups names
    $search_pattern = '#('.implode('|', $groups_names).')#';

    $max_matches = 0;
    foreach ($routes as $route) {
        $matches_count = preg_match_all($search_pattern, $route);
        if ($max_matches < $matches_count) {
            $max_matches = $matches_count;
            $found_route = $route;
        }
    }
    return $found_route;
}

$additional_url_params = array();
/**
 * Helper function to replace groups' definitions with values that are popped
 * from $additional_url_params array. So, $additional_url_params array at the
 * end of all the substitutions will still have the additional params.
 *
 * @param array $matches Matches from preg_replace_callback function.
 * @return string Matching value.
 */
function _on_group_match($matches)
{
    global $additional_url_params;
    $matched_group_name = $matches[0];

    foreach ($additional_url_params as $k=> $v) {
        if (strpos($matched_group_name, $k) !== false) {
            break;
        }
    }
    unset($additional_url_params[$k]);
    return $v;
}

/**
 * Build an URL starting from the endpoint name and params that should be appear
 * inside the correspondent routes.
 *
 * Additional parameters will be appended as URL query string.
 *
 * @param string $endpoint The endpoint name.
 * @param array $params Parameters to substitute in the matched URL pattern.
 * @return string The built url.
 */
function url_for($endpoint, $params=array())
{
    global $table_endpoint_page, $additional_url_params;

    $page_data = array_safe_get($table_endpoint_page[$endpoint], null);
    if ($page_data === null) {
        _url_for_error(
            $endpoint,
            $params,
            array(),
            "endpoint NOT found",
            debug_backtrace()
        );
    }

    $regex_url = _get_regex_url($page_data['routes'], $params);
    if ($regex_url === null) {
        _url_for_error(
            $endpoint,
            $params,
            $page_data['routes'],
            "mismatch between found routes and given parameters",
            debug_backtrace()
        );
    }

    // replace each group with correspondent parameters' value.
    $group_names = array_keys($params);
    array_walk($group_names, '_group_name_patter_builder_d');

    $additional_url_params =  $params;
    $url = preg_replace_callback($group_names,'_on_group_match', $regex_url);

    // check that all groups have been replaced
    $search_pattern = '#^(.*[\(\)].*)+$#';
    if (preg_match_all($search_pattern, $url)) {
        _url_for_error(
            $endpoint,
            $params,
            $page_data['routes'],
            "one or more url variable missing",
            debug_backtrace()
        );
    }

    // clean url from regex characters
    $regex_rm_characters = array('#', '^', '$', '?');
    $url = str_replace($regex_rm_characters, "", $url);

    if (!empty($additional_url_params)) {
        $url .= '?'.http_build_query($additional_url_params);
    }
    return $url;
}

/**
 * Search the matching page by the request path.
 *
 * @param string $request_path The path to search for.
 * @param array $rpath_vars Request path variables.
 * @return array|null The found page.
 */
function search_page($request_path, &$rpath_vars)
{
    global $table_route_page;

    foreach ($table_route_page as $regex => $p) {
        $res = preg_match($regex, $request_path, $rpath_vars);
        $rpath_vars = array_filter($rpath_vars, "is_string", ARRAY_FILTER_USE_KEY);
        if ($res) {
            return $p;
        }
    }
    return null;
}

/**
 * Template rendering function.
 *
 * It renders a template and return a response array.
 *
 * @param string $template Template path.
 * @param array $vars The variable to inject during the template rendering.
 * @return array Response array
 */
function render_template($template, $vars=array())
{
    return array(
        'type'=>'render_template',
        'page_content'=>get_template_engine_result($template, $vars)
    );
};

/**
 * Render template response handler.
 *
 * @param array $response Response array.
 */
function handle_render_template($response) {
    echo $response['page_content'];
    die();
}

/**
 * Redirect to URL function.
 *
 * @param string $url URL to which do the redirect.
 * @param int $response_code HTTP protocol response code.
 * @return array Response array.
 */
function redirect($url, $response_code=303)
{
    return array(
        'type'=>'redirect',
        'response_code'=>$response_code,
        'url'=>$url
    );
};

/**
 * Redirect response handler.
 *
 * @param array $response Response array.
 */
function handle_redirect($response) {
    http_response_code($response['response_code']);
    header("Location: {$response['url']}");
    exit();
}

/**
 * Handles a response array.
 *
 * @param array $response Response array
 */
function handle_response($response) {
    switch($response['type']) {
        case 'render_template':
            handle_render_template($response);
            break;
        case 'redirect':
            handle_redirect($response);
            break;
        default:
            die('Not matching response type. '.$response['type']);
            break;
    };
}
