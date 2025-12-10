<?php
if (!defined('ABSPATH')) exit;

// Load server-side components
$path = strpos(__DIR__, 'themes') !== false 
    ? get_template_directory() 
    : plugin_dir_path(glob(dirname(__DIR__) . '/*.php')[0] ?? '');

array_map(fn($f) => include_once $f, glob("$path/ui/src/components/app/server-side/*/index.php") ?: []);
