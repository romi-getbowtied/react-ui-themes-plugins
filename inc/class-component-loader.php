<?php
/**
 * Component Loader
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Component_Loader')) {
    class TW_Component_Loader {
        private static $instance = null;
        private $components_paths;
        private $active_components = [];

        private function __construct($components_paths) {
            $this->components_paths = $components_paths;
            $this->active_components = apply_filters('tw_component_loader_active_components', ['server-side' => []]);
        }

        public static function init($components_paths) {
            return self::$instance ??= new self($components_paths);
        }

        public function load_components() {
            $base = $this->components_paths['path'] . '/src/components/app/server-side/';
            foreach ($this->active_components['server-side'] ?? [] as $slug) {
                $file = $base . $slug . '/index.php';
                if (file_exists($file)) include_once $file;
            }
        }

        public function get_active_server_side_components() {
            return $this->active_components['server-side'] ?? [];
        }
    }
}

