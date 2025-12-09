<?php
/**
 * Component Loader
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Component_Loader')) {
    class TW_Component_Loader {
        private static $instances = [];
        private $context_id;
        private $components_paths;
        private $active_components = [];

        private function __construct($components_paths, $context_id) {
            $this->components_paths = $components_paths;
            $this->context_id = $context_id;
        }

        private function get_active_components() {
            if (empty($this->active_components)) {
                // Try specific filter first, then fallback to simple type filter
                $filter_id = str_replace(':', '_', $this->context_id);
                $type = explode(':', $this->context_id)[0];
                $filtered = apply_filters("tw_component_loader_active_components_$filter_id", 
                    apply_filters("tw_component_loader_active_components_$type", []));
                // Support both simple array format [slug1, slug2] and nested format ['server-side' => [...]]
                $this->active_components = ['server-side' => $filtered['server-side'] ?? (is_array($filtered) && !empty($filtered) && !isset($filtered['server-side']) ? $filtered : [])];
            }
            return $this->active_components;
        }

        public static function init($components_paths, $context_id) {
            return self::$instances[$context_id] ??= new self($components_paths, $context_id);
        }

        public function load_components() {
            $components = $this->get_active_components();
            $base = "{$this->components_paths['path']}/src/components/app/server-side";
            foreach ($components['server-side'] ?? [] as $slug) {
                $file = "$base/$slug/index.php";
                if (file_exists($file)) include_once $file;
            }
        }

        public function get_active_server_side_components() {
            $components = $this->get_active_components();
            return $components['server-side'] ?? [];
        }

        public function get_context_id() {
            return $this->context_id;
        }
    }
}

