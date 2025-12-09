<?php
/**
 * Components Entry Point
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Components')) {
    class TW_Components {
        private static $instances = [];
        private $context_id;
        private $components_paths;
        private $active_components = [];

        private function __construct() {
            $this->context_id = self::detect_context();
            $this->components_paths = $this->setup_paths();
            $this->initialize();
        }

        private function setup_paths() {
            $components_dir = dirname(__FILE__);
            $folder_name = basename($components_dir);
            $parts = explode(':', $this->context_id, 2);
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
            
            return [
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

        private function get_active_components() {
            if (empty($this->active_components)) {
                [$type] = explode(':', $this->context_id, 2);
                $filter_id = str_replace(':', '_', $this->context_id);
                $filtered = apply_filters("tw_component_loader_active_components_$filter_id", 
                    apply_filters("tw_component_loader_active_components_$type", []));
                $this->active_components = ['server-side' => $filtered['server-side'] ?? (is_array($filtered) && !isset($filtered['server-side']) ? $filtered : [])];
            }
            return $this->active_components;
        }

        private function initialize() {
            $global_key = 'tw_' . str_replace(':', '_', $this->context_id);
            $GLOBALS["{$global_key}_setup"] = $GLOBALS["{$global_key}_component_loader"] = $this;
            
            add_action('init', fn() => $this->load_components(), 1);
            add_action(strpos($this->context_id, 'theme:') === 0 ? 'wp_enqueue_scripts' : 'admin_enqueue_scripts', fn() => $this->enqueue_assets());
        }

        public function load_components() {
            $base = "{$this->components_paths['path']}/src/components/app/server-side";
            foreach ($this->get_active_components()['server-side'] ?? [] as $slug) {
                $file = "$base/$slug/index.php";
                if (file_exists($file)) include_once $file;
            }
        }

        public function enqueue_assets() {
            $paths = $this->components_paths;
            $assets_path = "{$paths['path']}/assets";
            $assets_url = "{$paths['url']}/assets";
            $version = file_exists("$assets_path/styles.css") ? filemtime("$assets_path/styles.css") : '1.0.0';
            $handle = 'tw-' . str_replace(':', '-', $this->context_id);

            wp_enqueue_style("$handle-style", "$assets_url/styles.css", [], $version);
            wp_enqueue_script("$handle-script", "$assets_url/scripts.js", ['wp-element'], $version, true);
            wp_localize_script("$handle-script", 'twActiveComponents', [
                'serverSide' => $this->get_active_server_side_components(),
            ]);
        }

        public function get_context_id() {
            return $this->context_id;
        }

        public function get_components_paths() {
            return $this->components_paths;
        }

        public function get_active_server_side_components() {
            return $this->get_active_components()['server-side'] ?? [];
        }

        public static function init() {
            $context_id = self::detect_context();
            return self::$instances[$context_id] ??= new self();
        }

        private static function detect_context() {
            $components_dir = dirname(__FILE__);
            $folder_name = basename($components_dir);
            $sep = DIRECTORY_SEPARATOR;
            $plugins_sep = $sep . 'plugins' . $sep;
            $themes_sep = $sep . 'themes' . $sep;
            
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10) as $frame) {
                if (!isset($frame['file'])) continue;
                $file = $frame['file'];
                if (strpos($file, "/$folder_name/") !== false || strpos($file, "$sep$folder_name$sep") !== false) continue;
                if (strpos($file, $plugins_sep) !== false || strpos($file, '/plugins/') !== false) {
                    return 'plugin:' . preg_replace('/[^a-z0-9_-]/i', '_', basename(dirname($components_dir)));
                }
                if (strpos($file, $themes_sep) !== false || strpos($file, '/themes/') !== false) {
                    return 'theme:' . preg_replace('/[^a-z0-9_-]/i', '_', basename(get_template_directory()));
                }
            }
            $id = preg_replace('/[^a-z0-9_-]/i', '_', basename(dirname($components_dir)));
            return strpos($components_dir, 'plugins') !== false 
                ? 'plugin:' . $id
                : 'theme:' . preg_replace('/[^a-z0-9_-]/i', '_', basename(get_template_directory()));
        }
    }
}

// Helper function to register components
function tw_register_components($components) {
    $type = explode(':', TW_Components::init()->get_context_id())[0];
    add_filter("tw_component_loader_active_components_$type", fn() => $components);
}

// Helper function for enqueue (backward compatibility)
function tw_enqueue_assets() {
    TW_Components::init()->enqueue_assets();
}

// Initialize
TW_Components::init();
