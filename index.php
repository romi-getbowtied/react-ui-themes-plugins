<?php
/**
 * Components Entry Point
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/inc/class-theme-setup.php';
require_once __DIR__ . '/inc/class-component-loader.php';

$tw_theme_setup = TW_Theme_Setup::init();
$tw_component_loader = TW_Component_Loader::init($tw_theme_setup->get_components_paths());

global $tw_theme_setup, $tw_component_loader, $tw_base_paths, $tw_components_paths;
$tw_base_paths = $tw_theme_setup->get_base_paths();
$tw_components_paths = $tw_theme_setup->get_components_paths();

!defined('TW_THEME_VERSION') && define('TW_THEME_VERSION', '1.0.0');
!defined('TW_THEME_DIR') && define('TW_THEME_DIR', $tw_base_paths['path']);
!defined('TW_THEME_URL') && define('TW_THEME_URL', $tw_base_paths['url']);

$tw_component_loader->load_components();

