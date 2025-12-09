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
            $components_dir = dirname(dirname(__FILE__));
            $folder_name = basename($components_dir);
            
            // Extract context type and identifier
            $parts = explode(':', $context_id, 2);
            $type = $parts[0];
            $identifier = $parts[1] ?? '';
            
            if ($type === 'plugin') {
                $plugin_root = dirname($components_dir);
                $plugin_file = $this->find_plugin_file($plugin_root);
                $base_path = $plugin_file ? plugin_dir_path($plugin_file) : $plugin_root;
                $base_url = $plugin_file ? plugin_dir_url($plugin_file) : plugins_url($identifier);
            } else {
                $base_path = get_template_directory();
                $base_url = get_template_directory_uri();
            }
            
            $this->components_paths = [
                'path' => "$base_path/$folder_name",
                'url'  => "$base_url/$folder_name"
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
            // Check backtrace to find which file included the components folder
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
            $components_dir = dirname(dirname(__FILE__));
            $folder_name = basename($components_dir);
            
            foreach ($backtrace as $frame) {
                if (isset($frame['file'])) {
                    $file = $frame['file'];
                    // Skip our own files (components folder)
                    if (strpos($file, "/$folder_name/") !== false || 
                        strpos($file, DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR) !== false) {
                        continue;
                    }
                    // Check if from plugin
                    if (strpos($file, DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR) !== false ||
                        strpos($file, '/plugins/') !== false) {
                        // Extract plugin directory name for unique ID
                        $plugin_root = dirname($components_dir);
                        $identifier = basename($plugin_root);
                        return 'plugin:' . self::sanitize_context_id($identifier);
                    }
                    // Check if from theme
                    if (strpos($file, DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR) !== false ||
                        strpos($file, '/themes/') !== false) {
                        // Extract theme directory name for unique ID
                        $identifier = basename(get_template_directory());
                        return 'theme:' . self::sanitize_context_id($identifier);
                    }
                }
            }
            // Fallback: check components directory location
            if (strpos($components_dir, 'plugins') !== false) {
                $identifier = basename(dirname($components_dir));
                return 'plugin:' . self::sanitize_context_id($identifier);
            }
            $identifier = basename(get_template_directory());
            return 'theme:' . self::sanitize_context_id($identifier);
        }

        private static function sanitize_context_id($id) {
            // Sanitize for use in filter names and global variables
            return preg_replace('/[^a-z0-9_-]/i', '_', $id);
        }

        public function get_context_id() {
            return $this->context_id;
        }

        public function get_components_paths() {
            return $this->components_paths;
        }
    }
}

