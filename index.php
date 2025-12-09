<?php
/**
 * Components Entry Point
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/inc/class-setup.php';
require_once __DIR__ . '/inc/class-component-loader.php';

// Initialize and load components
$tw_setup = TW_Setup::init();
$context_id = $tw_setup->get_context_id();
$tw_component_loader = TW_Component_Loader::init($tw_setup->get_components_paths(), $context_id);
$tw_component_loader->load_components();

// Store in context-specific globals
$GLOBALS["tw_{$context_id}_setup"] = $tw_setup;
$GLOBALS["tw_{$context_id}_component_loader"] = $tw_component_loader;

// Enqueue assets function
function tw_enqueue_assets($hook = '') {
	$setup = TW_Setup::init();
	$context_id = $setup->get_context_id();
	$loader = $GLOBALS["tw_{$context_id}_component_loader"] ?? null;
	
	if (!$loader) return;
	
	$paths = $setup->get_components_paths();
	$assets_path = "{$paths['path']}/assets";
	$assets_url = "{$paths['url']}/assets";
	$version = file_exists("$assets_path/styles.css") ? filemtime("$assets_path/styles.css") : '1.0.0';
	$handle = "tw-$context_id";

	wp_enqueue_style("$handle-style", "$assets_url/styles.css", [], $version);
	wp_enqueue_script("$handle-script", "$assets_url/scripts.js", ['wp-element'], $version, true);
	wp_localize_script("$handle-script", 'twActiveComponents', [
		'serverSide' => $loader->get_active_server_side_components(),
	]);
}

// Auto-enqueue for theme frontend
if ($context_id === 'theme') {
	add_action('wp_enqueue_scripts', 'tw_enqueue_assets');
}

