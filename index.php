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

// Store in context-specific globals (sanitize context ID)
$global_key = 'tw_' . str_replace(':', '_', $context_id);
$GLOBALS["{$global_key}_setup"] = $tw_setup;
$GLOBALS["{$global_key}_component_loader"] = $tw_component_loader;

// Enqueue assets function (memory-optimized: uses cached instances)
function tw_enqueue_assets($hook = '') {
	$setup = TW_Setup::init();
	$context_id = $setup->get_context_id();
	// Sanitize context ID for global variable key
	$global_key = 'tw_' . str_replace(':', '_', $context_id);
	$loader = $GLOBALS["{$global_key}_component_loader"] ?? null;
	
	if (!$loader) return;
	
	$paths = $setup->get_components_paths();
	$assets_path = "{$paths['path']}/assets";
	$assets_url = "{$paths['url']}/assets";
	$version = file_exists("$assets_path/styles.css") ? filemtime("$assets_path/styles.css") : '1.0.0';
	$handle = 'tw-' . str_replace(':', '-', $context_id);

	wp_enqueue_style("$handle-style", "$assets_url/styles.css", [], $version);
	wp_enqueue_script("$handle-script", "$assets_url/scripts.js", ['wp-element'], $version, true);
	wp_localize_script("$handle-script", 'twActiveComponents', [
		'serverSide' => $loader->get_active_server_side_components(),
	]);
}

// Auto-enqueue for theme frontend
if (strpos($context_id, 'theme:') === 0) {
	add_action('wp_enqueue_scripts', 'tw_enqueue_assets');
}

