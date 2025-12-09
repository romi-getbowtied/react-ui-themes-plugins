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
        private $base_paths;
        private $components_paths;

        private function __construct($context_id) {
            $this->context_id = $context_id;
            $ui_dir = dirname(dirname(__FILE__));
            
            if ($context_id === 'plugin') {
                $plugin_root = dirname($ui_dir);
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
            $context_id = self::detect_context();
            if (!isset(self::$instances[$context_id])) {
                self::$instances[$context_id] = new self($context_id);
            }
            return self::$instances[$context_id];
        }

        private static function detect_context() {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
            foreach ($backtrace as $frame) {
                if (isset($frame['file'])) {
                    if (strpos($frame['file'], DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR) !== false ||
                        strpos($frame['file'], '/plugins/') !== false) {
                        return 'plugin';
                    }
                    if (strpos($frame['file'], DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR) !== false ||
                        strpos($frame['file'], '/themes/') !== false) {
                        return 'theme';
                    }
                }
            }
            return 'theme'; // Default to theme
        }

        public function get_context_id() {
            return $this->context_id;
        }

        public function get_components_paths() {
            return $this->components_paths;
        }
    }
}

