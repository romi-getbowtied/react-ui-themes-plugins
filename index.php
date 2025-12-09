<?php
/**
 * Components Entry Point
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/inc/class-setup.php';
require_once __DIR__ . '/inc/class-component-loader.php';

// Initialize setup and detect context
$tw_setup = TW_Setup::init();
$context_id = $tw_setup->get_context_id();
$tw_components_paths = $tw_setup->get_components_paths();
$tw_component_loader = TW_Component_Loader::init($tw_components_paths, $context_id);

// Set context-specific globals
$global_key = 'tw_' . $context_id;
$GLOBALS[$global_key . '_setup'] = $tw_setup;
$GLOBALS[$global_key . '_components_paths'] = $tw_components_paths;
$GLOBALS[$global_key . '_component_loader'] = $tw_component_loader;

// Load components
$tw_component_loader->load_components();

// Enqueue assets function (context-aware)
function tw_enqueue_assets($hook = '') {
	$setup = TW_Setup::init();
	$context_id = $setup->get_context_id();
	$global_key = 'tw_' . $context_id;
	
	$components_paths = $GLOBALS[$global_key . '_components_paths'] ?? null;
	$component_loader = $GLOBALS[$global_key . '_component_loader'] ?? null;
	
	if (!$components_paths) return;
	
	$base = $components_paths['path'] . '/assets';
	$version = file_exists("$base/styles.css") ? filemtime("$base/styles.css") : '1.0.0';
	$url = $components_paths['url'] . '/assets';
	$handle = 'tailwind-scoped-' . $context_id;

	wp_enqueue_style($handle . '-style', "$url/styles.css", [], $version);
	wp_enqueue_script($handle . '-script', "$url/scripts.js", ['wp-element'], $version, true);
	
	if ($component_loader) {
		wp_localize_script($handle . '-script', 'twActiveComponents', [
			'serverSide' => $component_loader->get_active_server_side_components(),
		]);
	}
}

// Auto-enqueue for theme (frontend)
if ($context_id === 'theme') {
	add_action('wp_enqueue_scripts', 'tw_enqueue_assets');
}

