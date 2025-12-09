<?php
/**
 * Setup
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Setup')) {
    class TW_Setup {
        private static $instances = [];
        private $context_id;
        private $components_paths;

        private function __construct($context_id) {
            $this->context_id = $context_id;
            $ui_dir = dirname(dirname(__FILE__));
            
            if ($context_id === 'plugin') {
                $plugin_root = dirname($ui_dir);
                $plugin_file = $this->find_plugin_file($plugin_root);
                $base_path = $plugin_file ? plugin_dir_path($plugin_file) : $plugin_root;
                $base_url = $plugin_file ? plugin_dir_url($plugin_file) : plugins_url(basename($plugin_root));
            } else {
                $base_path = get_template_directory();
                $base_url = get_template_directory_uri();
            }
            
            $this->components_paths = [
                'path' => "$base_path/ui",
                'url'  => "$base_url/ui"
            ];
        }

        private function find_plugin_file($plugin_root) {
            foreach (glob("$plugin_root/*.php") ?: [] as $file) {
                if (strpos(@file_get_contents($file, false, null, 0, 8192) ?: '', 'Plugin Name:') !== false) {
                    return $file;
                }
            }
            return null;
        }

        public static function init() {
            $context_id = self::detect_context();
            return self::$instances[$context_id] ??= new self($context_id);
        }

        private static function detect_context() {
            static $cached = null;
            return $cached ??= (strpos(dirname(dirname(__FILE__)), 'plugins') !== false ? 'plugin' : 'theme');
        }

        public function get_context_id() {
            return $this->context_id;
        }

        public function get_components_paths() {
            return $this->components_paths;
        }
    }
}

