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

