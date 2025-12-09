<?php
/**
 * Navigation Menu Enhanced Component
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;


/**
 * Render SEO-friendly navigation menu
 * 
 * @param string $location Menu location slug
 * @param array $args Additional arguments for wp_nav_menu
 * @return void
 */
if (!function_exists('tw_render_nav_menu')) {
function tw_render_nav_menu($location = 'primary', $args = []) {
	$defaults = [
		'theme_location' => $location,
		'container' => false,
		'menu_class' => 'flex flex-wrap gap-2',
		'menu_id' => 'primary-menu',
		'fallback_cb' => false,
		'items_wrap' => '<ul id="%1$s" class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement">%3$s</ul>',
		'walker' => new TW_Nav_Walker(),
	];
	
	$args = wp_parse_args($args, $defaults);
	
	if (has_nav_menu($location)) {
		wp_nav_menu($args);
	} else {
		// Fallback menu if no menu is assigned
		echo '<ul class="flex flex-wrap gap-2" itemscope itemtype="https://schema.org/SiteNavigationElement">';
		echo '<li><a href="' . esc_url(home_url('/')) . '" itemprop="url"><span itemprop="name">Home</span></a></li>';
		echo '<li><a href="' . esc_url(home_url('/blog')) . '" itemprop="url"><span itemprop="name">Blog</span></a></li>';
		echo '<li><a href="' . esc_url(home_url('/contact')) . '" itemprop="url"><span itemprop="name">Contact</span></a></li>';
		echo '</ul>';
	}
}
}

/**
 * Custom Navigation Walker for SEO-friendly menu output
 */
class TW_Nav_Walker extends Walker_Nav_Menu {
	
	/**
	 * Start the element output.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		// Add relative positioning for dropdowns
		if (in_array('menu-item-has-children', $classes)) {
			$classes[] = 'relative';
		}
		
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		
		$output .= $indent . '<li' . $id . $class_names . ' itemprop="name">';
		
		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
		$attributes .= ' itemprop="url"';
		
		// Add classes for styling
		$link_classes = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-transparent bg-transparent hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2';
		if (in_array('menu-item-has-children', $classes)) {
			$link_classes .= ' cursor-pointer';
		}
		
		$item_output = isset($args->before) ? $args->before : '';
		$item_output .= '<a' . $attributes . ' class="' . esc_attr($link_classes) . '">';
		$item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
		if (in_array('menu-item-has-children', $classes)) {
			$item_output .= ' <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>';
		}
		$item_output .= '</a>';
		$item_output .= isset($args->after) ? $args->after : '';
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
	/**
	 * Start the list before the elements are added.
	 */
	public function start_lvl(&$output, $depth = 0, $args = null) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu absolute top-full left-0 mt-2 min-w-[200px] rounded-md border border-input bg-background p-1 shadow-lg opacity-0 invisible transition-all duration-200 z-50\" role=\"menu\" aria-label=\"Submenu\">\n";
	}
	
	/**
	 * End the list after the elements are added.
	 */
	public function end_lvl(&$output, $depth = 0, $args = null) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
}

