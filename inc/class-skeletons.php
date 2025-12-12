<?php
if (!defined('ABSPATH')) exit;

class UI_Skeletons {
	public static function get_height($slug, $props = []) {
		$class = str_replace(' ', '', ucwords(str_replace('-', ' ', $slug))) . '_Skeleton';
		return class_exists($class) ? $class::get_height($props) : null;
	}
}

