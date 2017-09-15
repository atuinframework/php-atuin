<?php

/**
 * Returns the complete template path.
 *
 * @param string $template_path Template path.
 * @return string Full path to the template file.
 */
function template_path($template_path)
{
    return "templates/$template_path";
}

/**
 * Return the PHP file execution result.
 *
 * @param string $template Template path of which execute the content.
 * @param array $variables Variables to be injected in the file execution
 * context.
 * @return bool|string Processed content of the file.
 */
function get_template_result($template, $variables=array())
{
    $filename = template_path($template);

    global $p, $LANG_TITLES, $current_user;
    $variables['p'] = $p;
    $variables['LANG_TITLES'] = $LANG_TITLES;
    $variables['current_user'] = $current_user;

    if (is_file($filename)) {
        extract($variables, EXTR_SKIP);
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    die('<h2>ERROR</h2><p>'.$filename.' is not a valid PHP file path.</p>');
}

$blocks_stack = array();
/**
 * Defines the beginning of a template's block.
 *
 * To be used in conjunction with endblock() function.
 * Example:
 * <?= block('address') ?><?= endblock() ?>
 *
 * @param string $block_name Block name.
 */
function block($block_name)
{
    global $blocks_stack;
    array_push($blocks_stack, $block_name);
    ob_start();
}

/**
 * Defines the end of a template's block.
 *
 * To be used in conjunction with block($block_name) function.
 * Example:
 * <?= block('address') ?><?= endblock() ?>
 *
 * @param string $block_name Block name.
 */
function endblock()
{
    global $p, $blocks_stack;
    $block_name = array_pop($blocks_stack);
    if (array_key_exists($block_name, $p['blocks'])) {
        ob_end_clean();
        echo $p['blocks'][$block_name];
    } else {
        $p['blocks'][$block_name] = ob_get_contents();
        ob_end_flush();
    }
}

$templates_stack = array();
/**
 * Provide extension functionality to implement templates' inheritance.
 *
 * @param string $template File path of the template to extend.
 */
function extends_template($template)
{
    global $templates_stack;
    array_push($templates_stack, $template);
}

/**
 * Process all extensions of templates and return the final processed result.
 *
 * @param string $template The template to start from.
 * @param array $vars Variables array to inject into template execution context.
 * @return string The resulting HTML.
 */
function get_template_engine_result($template, $vars)
{
    global $templates_stack;

    $res = get_template_result($template, $vars);

    while ($below_template = array_pop($templates_stack)) {
        $res = get_template_result($below_template, $vars);
    }
    return $res;
}
