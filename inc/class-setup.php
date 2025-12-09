<?php
/**
 * Setup
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Setup')) {
    class TW_Setup {
        private static $instance = null;
        private $base_paths;
        private $components_paths;

        private function __construct() {
            $plugin_root = dirname(dirname(dirname(__FILE__)));
            $is_plugin = strpos($plugin_root, 'plugins') !== false;
            
            if ($is_plugin) {
                $plugin_file = $this->find_plugin_file($plugin_root);
                $this->base_paths = $plugin_file ? [
                    'path' => plugin_dir_path($plugin_file),
                    'url'  => plugin_dir_url($plugin_file)
                ] : [
                    'path' => $plugin_root,
                    'url'  => plugins_url(basename($plugin_root))
                ];
            } else {
                $this->base_paths = [
                    'path' => get_template_directory(),
                    'url'  => get_template_directory_uri()
                ];
            }
            
            $this->components_paths = [
                'path' => $this->base_paths['path'] . '/ui',
                'url'  => $this->base_paths['url'] . '/ui'
            ];
        }

        private function find_plugin_file($plugin_root) {
            $files = glob($plugin_root . '/*.php');
            if (empty($files)) return null;

            foreach ($files as $file) {
                $header = @file_get_contents($file, false, null, 0, 8192);
                if ($header && strpos($header, 'Plugin Name:') !== false) {
                    return $file;
                }
            }
            
            return $files[0];
        }

        public static function init() {
            return self::$instance ??= new self();
        }

        public function get_components_paths() {
            return $this->components_paths;
        }
    }
}

