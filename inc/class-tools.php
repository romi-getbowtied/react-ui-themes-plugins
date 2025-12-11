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
	 *         'items' => $dock_items,
	 *         'mobileClassName' => 'translate-y-20'
	 *     ]); ?>"
	 * ></div>
	 */
	public static function data_props(array $props): string {
		return esc_attr(json_encode($props, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
}

