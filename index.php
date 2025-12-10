<?php
if (!defined('ABSPATH')) exit;

(function() {
    $is_theme = strpos(__DIR__, 'themes') !== false;
    $root = dirname(__DIR__);
    
    if ($is_theme) {
        $path = get_template_directory();
        $url = rtrim(get_template_directory_uri(), '/');
    } else {
        $file = glob("$root/*.php")[0] ?? '';
        $path = $file ? plugin_dir_path($file) : $root;
        $url = rtrim($file ? plugin_dir_url($file) : plugins_url(basename($root)), '/');
    }

    $prefix = 'tw-' . ($is_theme ? 'theme' : 'plugin');
    $ver = fn($f) => file_exists($f) ? filemtime($f) : '1.0.0';

    $enqueue = fn($ctx) => (
        wp_enqueue_style("$prefix-$ctx", "$url/ui/assets/$ctx/styles.css", [], $ver("$path/ui/assets/$ctx/styles.css")) ||
        wp_enqueue_script("$prefix-$ctx", "$url/ui/assets/$ctx/scripts.js", ['wp-element'], $ver("$path/ui/assets/$ctx/scripts.js"), true)
    );

    add_action('init', fn() => array_map(fn($f) => include_once $f, glob("$path/ui/src/components/app/server-side/*/index.php") ?: []));
    add_action('wp_enqueue_scripts', fn() => $enqueue('frontend'));
    add_action('admin_enqueue_scripts', fn() => $enqueue('backend'));
})();
