<?php
/**
 * Components Entry Point
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Components')) {
    class TW_Components {
        private static $instance;
        private $base_path;
        private $base_url;
        private $handle_prefix;

        private function __construct() {
            $is_theme = strpos(__DIR__, 'themes') !== false;
            
            if ($is_theme) {
                $this->base_path = get_template_directory();
                $this->base_url = get_template_directory_uri();
            } else {
                $plugin_root = dirname(__DIR__);
                $plugin_file = glob("$plugin_root/*.php")[0] ?? '';
                $this->base_path = $plugin_file ? plugin_dir_path($plugin_file) : $plugin_root;
                $this->base_url = $plugin_file ? plugin_dir_url($plugin_file) : plugins_url(basename($plugin_root));
            }
            
            $this->handle_prefix = "tw-" . ($is_theme ? 'theme' : 'plugin');
            
            add_action('init', [$this, 'load_server_components']);
            add_action($is_theme ? 'wp_enqueue_scripts' : 'admin_enqueue_scripts', [$this, 'enqueue_assets']);
        }

        public function load_server_components() {
            $server_side_base = "$this->base_path/ui/src/components/app/server-side";
            if (is_dir($server_side_base)) {
                foreach (glob("$server_side_base/*/index.php") as $file) {
                    if (file_exists($file)) include_once $file;
                }
            }
        }

        public function enqueue_assets() {
            $assets_path = "$this->base_path/ui/assets";
            $assets_url = "$this->base_url/ui/assets";
            
            $styles_path = "$assets_path/styles.css";
            $styles_url = "$assets_url/styles.css";
            
            $scripts_path = "$assets_path/scripts.js";
            $scripts_url = "$assets_url/scripts.js";
            
            $get_version = fn($file) => file_exists($file) ? filemtime($file) : '1.0.0';
            
            wp_enqueue_style("$this->handle_prefix-style", $styles_url, [], $get_version($styles_path));
            wp_enqueue_script("$this->handle_prefix-script", $scripts_url, ['wp-element'], $get_version($scripts_path), true);
        }

        public static function init() {
            return self::$instance ??= new self();
        }
    }
}

TW_Components::init();
