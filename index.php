<?php
/**
 * Components Entry Point
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/inc/class-setup.php';
require_once __DIR__ . '/inc/class-component-loader.php';

$tw_components_paths = TW_Setup::init()->get_components_paths();
$tw_component_loader = TW_Component_Loader::init($tw_components_paths);

global $tw_component_loader, $tw_components_paths;

$tw_component_loader->load_components();

// Enqueue assets for both theme (frontend) and plugin (admin) contexts
function tw_enqueue_assets($hook = '') {
	global $tw_components_paths, $tw_component_loader;
	$base = $tw_components_paths['path'] . '/assets';
	$version = file_exists("$base/styles.css") ? filemtime("$base/styles.css") : '1.0.0';
	$url = $tw_components_paths['url'] . '/assets';

	wp_enqueue_style('tailwind-scoped-style', "$url/styles.css", [], $version);
	wp_enqueue_script('tailwind-scoped-script', "$url/scripts.js", ['wp-element'], $version, true);
	
	if (isset($tw_component_loader)) {
		wp_localize_script('tailwind-scoped-script', 'twActiveComponents', [
			'serverSide' => $tw_component_loader->get_active_server_side_components(),
		]);
	}
}

// Auto-enqueue for theme (frontend)
add_action('wp_enqueue_scripts', 'tw_enqueue_assets');

