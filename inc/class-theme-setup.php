<?php
/**
 * Theme Setup
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Theme_Setup')) {
    class TW_Theme_Setup {
        private static $instance = null;
        private $base_paths;
        private $components_paths;

        private function __construct() {
            $is_plugin = strpos(__FILE__, DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR) !== false 
                     || strpos(__FILE__, '/plugins/') !== false;
            
            if ($is_plugin) {
                // Go up from components/inc/ to plugin root
                $plugin_root = dirname(dirname(dirname(__FILE__)));
                // Find the main plugin PHP file (look for any .php file in plugin root)
                $plugin_file = null;
                $files = glob($plugin_root . '/*.php');
                if (!empty($files)) {
                    // Use the first PHP file found (should be the main plugin file)
                    foreach ($files as $file) {
                        // Check if it's a valid plugin file (contains Plugin Name header)
                        $content = file_get_contents($file);
                        if (strpos($content, 'Plugin Name:') !== false) {
                            $plugin_file = $file;
                            break;
                        }
                    }
                    // If no plugin header found, use first PHP file as fallback
                    if (!$plugin_file && !empty($files)) {
                        $plugin_file = $files[0];
                    }
                }
                
                if ($plugin_file && file_exists($plugin_file)) {
                    $this->base_paths = [
                        'path' => rtrim(plugin_dir_path($plugin_file), '/'),
                        'url'  => rtrim(plugin_dir_url($plugin_file), '/')
                    ];
                } else {
                    // Fallback: construct paths manually
                    $this->base_paths = [
                        'path' => rtrim($plugin_root, '/'),
                        'url'  => rtrim(plugins_url(basename($plugin_root)), '/')
                    ];
                }
            } else {
                $this->base_paths = [
                    'path' => rtrim(get_template_directory(), '/'),
                    'url'  => rtrim(get_template_directory_uri(), '/')
                ];
            }
            
            $this->components_paths = [
                'path' => $this->base_paths['path'] . '/ui',
                'url'  => $this->base_paths['url'] . '/ui'
            ];
        }

        public static function init() {
            return self::$instance ??= new self();
        }

        public function get_base_paths() {
            return $this->base_paths;
        }

        public function get_components_paths() {
            return $this->components_paths;
        }
    }

    TW_Theme_Setup::init();
}

