# Base Paths Pattern

This directory contains the setup and loader classes that enable the same codebase to work in both theme and plugin contexts, with components in a separate submodule folder.

## Architecture

The codebase is structured with:
- **Components folder** (`components/`): Shared component code (future Git submodule) - component provider only
- **Theme/Plugin** (`inc/`): Setup and activation logic - controls which components are loaded

## How It Works

1. **`TW_Theme_Setup`**: Detects theme/plugin context and provides base paths
2. **`TW_Component_Loader`**: Controls which components are activated (theme/plugin specific)
3. **Components folder**: Provides components but doesn't activate them

## Usage in Theme

In your theme's `functions.php`:

```php
<?php
if (!defined('ABSPATH')) exit;

// Initialize theme setup class to get base paths
require_once get_template_directory() . '/inc/class-theme-setup.php';
require_once get_template_directory() . '/inc/class-component-loader.php';

// Use the init method to ensure proper initialization
$tw_theme_setup = TW_Theme_Setup::init();
$base_paths = $tw_theme_setup->get_base_paths();
$components_paths = $tw_theme_setup->get_components_paths();

// Initialize component loader
$tw_component_loader = TW_Component_Loader::init($components_paths);

// Load active components (activation controlled here, not in components folder)
$tw_component_loader->load_components();
```

## Usage in Plugin

In your plugin's main file (e.g., `your-plugin.php`):

```php
<?php
if (!defined('ABSPATH')) exit;

// Initialize setup classes
require_once plugin_dir_path(__FILE__) . 'inc/class-theme-setup.php';
require_once plugin_dir_path(__FILE__) . 'inc/class-component-loader.php';

$tw_theme_setup = TW_Theme_Setup::init();
$base_paths = $tw_theme_setup->get_base_paths();
$components_paths = $tw_theme_setup->get_components_paths();

// Initialize component loader
$tw_component_loader = TW_Component_Loader::init($components_paths);

// Load active components
$tw_component_loader->load_components();
```

## Directory Structure

```
theme-name/                          OR    plugin-name/
├── components/                            ├── components/  (Git submodule)
│   └── src/                               │   └── src/
│       └── components/                    │       └── components/
│           └── app/                        │           └── app/
│               └── server-side/            │               └── server-side/
│                   └── hero-parallax/     │                   └── hero-parallax/
│                       └── index.php       │                       └── index.php
├── inc/                                    ├── inc/
│   ├── class-theme-setup.php             │   ├── class-theme-setup.php
│   └── class-component-loader.php        │   └── class-component-loader.php
└── functions.php                         └── your-plugin.php
```

## Component Activation

Components are activated **exclusively** in the theme/plugin, not in the components folder:

```php
// Customize which components are active using filter
add_filter('tw_component_loader_active_components', function($components) {
    // Modify $components array to activate/deactivate components
    $components['server-side'] = [
        'hero-parallax-enhanced',
        'navigation-menu-enhanced',
        // Add or remove components here
    ];
    return $components;
});
```

## Benefits

1. **Code Reusability**: Components in submodule, activation in theme/plugin
2. **Separation of Concerns**: Components provide, theme/plugin activates
3. **Easy Maintenance**: Update components in one place (submodule)
4. **Flexible Activation**: Each theme/plugin controls which components to use
5. **Version Control**: Submodule ensures consistent component versions

## API

### `TW_Theme_Setup`

- `init()`: Returns singleton instance
- `get_base_paths()`: Returns theme/plugin base paths
- `get_components_paths()`: Returns components folder paths

### `TW_Component_Loader`

- `init($components_paths)`: Initialize with components paths
- `load_components()`: Load all active server-side components
- `load_server_side_component($slug)`: Load specific component
- `is_component_active($type, $slug)`: Check if component is active
- `get_active_components()`: Get all active components
