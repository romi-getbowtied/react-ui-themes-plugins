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
        private $context_type;
        private $active_server_components = [];

        private function __construct() {
            $this->context_type = strpos(__DIR__, 'themes') !== false ? 'theme' : 'plugin';
            $this->setup_paths();
            $this->register_hooks();
        }

        private function setup_paths() {
            if ($this->context_type === 'theme') {
                $this->base_path = get_template_directory();
                $this->base_url = get_template_directory_uri();
            } else {
                $plugin_root = dirname(__DIR__);
                $plugin_file = glob("$plugin_root/*.php")[0] ?? '';
                $this->base_path = $plugin_file ? plugin_dir_path($plugin_file) : $plugin_root;
                $this->base_url = $plugin_file ? plugin_dir_url($plugin_file) : plugins_url(basename($plugin_root));
            }
        }

        private function register_hooks() {
            add_action('init', [$this, 'load_server_components'], 1);
            $enqueue_hook = $this->context_type === 'theme' ? 'wp_enqueue_scripts' : 'admin_enqueue_scripts';
            add_action($enqueue_hook, [$this, 'enqueue_assets']);
        }

        private function get_filter_name() {
            return "tw_component_loader_active_components_{$this->context_type}";
        }

        private function get_handle() {
            return "tw-{$this->context_type}";
        }

        private function get_active_server_components() {
            if (empty($this->active_server_components)) {
                $this->active_server_components = apply_filters($this->get_filter_name(), []) ?: [];
            }
            return $this->active_server_components;
        }

        public function load_server_components() {
            $server_side_base = "$this->base_path/ui/src/components/app/server-side";
            foreach ($this->get_active_server_components() as $component_slug) {
                $component_file = "$server_side_base/$component_slug/index.php";
                if (file_exists($component_file)) include_once $component_file;
            }
        }

        public function enqueue_assets() {
            $assets_path = "$this->base_path/ui/assets";
            $assets_url = "$this->base_url/ui/assets";
            $styles_file = "$assets_path/styles.css";
            $version = file_exists($styles_file) ? filemtime($styles_file) : '1.0.0';
            $handle = $this->get_handle();
            
            wp_enqueue_style("$handle-style", "$assets_url/styles.css", [], $version);
            wp_enqueue_script("$handle-script", "$assets_url/scripts.js", ['wp-element'], $version, true);
        }

        public function get_context_type() {
            return $this->context_type;
        }

        public static function init() {
            return self::$instance ??= new self();
        }
    }
}

function tw_register_components($server_components) {
    $instance = TW_Components::init();
    add_filter("tw_component_loader_active_components_{$instance->get_context_type()}", fn() => $server_components);
}

TW_Components::init();
