<?php
if (!defined('ABSPATH')) exit;

/**
 * UI Tools Class
 * 
 * Helper utilities for working with React island components in WordPress.
 */
class UI_Tools {
	/**
	 * Generate data-props attribute value for React island components
	 * 
	 * Encodes an array as JSON and escapes it for safe use in HTML attributes.
	 * This is the recommended way to pass props from PHP to React components.
	 * 
	 * @param array $props Array of props to pass to the React component
	 * @return string Escaped JSON string ready for use in data-props attribute
	 * 
	 * @example
	 * $menu_items = [
	 *     ['id' => 1, 'label' => 'Copy', 'icon' => 'Copy'],
	 *     ['id' => 2, 'label' => 'Cut', 'icon' => 'Scissors'],
	 * ];
	 * 
	 * <div 
	 *     data-island="radial-menu-demo" 
	 *     data-props="<?php echo UI_Tools::data_props(['menuItems' => $menu_items]); ?>"
	 * ></div>
	 * 
	 * @example
	 * $dock_items = [
	 *     ['title' => 'Home', 'icon' => 'IconHome', 'href' => '#'],
	 *     ['title' => 'Products', 'icon' => 'IconTerminal2', 'href' => '#'],
	 * ];
	 * 
	 * <div 
	 *     data-island="floating-dock" 
	 *     data-props="<?php echo UI_Tools::data_props([
	 *         'items' => $dock_items
	 *     ]); ?>"
	 * ></div>
	 */
	public static function data_props(array $props): string {
		return esc_attr(json_encode($props, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}

	/**
	 * Render a client-side component island
	 * 
	 * Renders a data-island div with height set to prevent layout shift during hydration.
	 * 
	 * @param string $slug Component slug (e.g., 'stack-demo', 'radial-menu-demo')
	 * @param array $props Props to pass to the component
	 * @param array $attributes Additional HTML attributes for the container div
	 * @return void
	 * 
	 * @example
	 * UI_Tools::render_island('stack-demo', [
	 *     'images' => $images,
	 *     'width' => 250,
	 *     'height' => 250
	 * ]);
	 */
	public static function render_island($slug, $props = [], $attributes = []) {
		static $skeletons_loaded = false;
		if (!$skeletons_loaded) {
			require_once __DIR__ . '/class-skeletons.php';
			$skeletons_loaded = true;
		}
		
		if (($height = UI_Skeletons::get_height($slug, $props)) !== null) {
			$attributes['style'] = ($attributes['style'] ?? '') . ' height: ' . $height . 'px;';
		}
		
		$attrs = '';
		foreach ($attributes as $k => $v) {
			$attrs .= ' ' . esc_attr($k) . '="' . esc_attr($v) . '"';
		}
		
		echo '<div data-island="', esc_attr($slug), '" data-props="', self::data_props($props), '"', $attrs, '></div>';
	}
}

