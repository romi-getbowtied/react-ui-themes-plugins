<?php
if (!defined('ABSPATH')) exit;

class StackDemo_Skeleton {
	public static function get_height($props = []) {
		return (int)($props['height'] ?? 208);
	}
}

