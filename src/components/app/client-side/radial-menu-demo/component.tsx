'use client';

import * as React from 'react';
import { RadialMenu } from '@/components/ui/animate-ui/components/community/radial-menu';
import {
	Copy,
	Scissors,
	ClipboardPaste,
	Trash2,
	Star,
	Pin,
	type LucideIcon,
} from 'lucide-react';

/**
 * Icon mapping for Lucide icons.
 * Available icon names: Copy, Scissors, ClipboardPaste, Trash2, Star, Pin
 */
const iconMap: Record<string, LucideIcon> = {
	Copy,
	Scissors,
	ClipboardPaste,
	Trash2,
	Star,
	Pin,
};

/**
 * Menu item data structure
 */
type MenuItemData = {
	/** Unique identifier for the menu item */
	id: number;
	/** Display label for the menu item */
	label: string;
	/** Icon name matching a key from iconMap (e.g., 'Copy', 'Star') */
	icon: string;
};

/**
 * Props for RadialMenuDemo component
 */
type RadialMenuDemoProps = {
	/** Array of menu items to display in the radial menu */
	menuItems?: MenuItemData[];
	/** 
	 * Callback function called when a menu item is selected
	 * @param item - The selected menu item with icon component
	 */
	onSelect?: (item: { id: number; label: string; icon: LucideIcon }) => void;
	/** Optional custom content to trigger the radial menu (defaults to placeholder div) */
	children?: React.ReactNode;
};

/**
 * RadialMenuDemo Component
 * 
 * A radial context menu component that appears on right-click.
 * Displays menu items in a circular layout with icons.
 * Supports dynamic configuration via props passed from PHP.
 * 
 * @example
 * // From PHP:
 * $menu_items = [
 *     ['id' => 1, 'label' => 'Copy', 'icon' => 'Copy'],
 *     ['id' => 2, 'label' => 'Cut', 'icon' => 'Scissors'],
 *     ['id' => 3, 'label' => 'Paste', 'icon' => 'ClipboardPaste'],
 *     ['id' => 4, 'label' => 'Favorite', 'icon' => 'Star'],
 *     ['id' => 5, 'label' => 'Pin', 'icon' => 'Pin'],
 *     ['id' => 6, 'label' => 'Delete', 'icon' => 'Trash2'],
 * ];
 * 
 * <div 
 *     data-island="radial-menu-demo" 
 *     data-props="<?php echo esc_attr(json_encode(['menuItems' => $menu_items])); ?>"
 * ></div>
 * 
 * @param {RadialMenuDemoProps} props - Component props
 * @param {MenuItemData[]} [props.menuItems=[]] - Array of menu items
 * @param {(item: { id: number; label: string; icon: LucideIcon }) => void} [props.onSelect] - Selection callback
 * @param {React.ReactNode} [props.children] - Custom trigger content
 * 
 * @returns {JSX.Element} Radial menu component
 */
export const RadialMenuDemo = ({ 
	menuItems = [], 
	onSelect,
	children 
}: RadialMenuDemoProps) => {
	// Transform menu items: convert icon name strings to Lucide icon components
	const menuItemsWithIcons = menuItems.map(item => ({
		id: item.id,
		label: item.label,
		// Map icon name to icon component, fallback to Copy if not found
		icon: iconMap[item.icon] || Copy,
	}));

	return (
		<RadialMenu
			menuItems={menuItemsWithIcons}
			onSelect={onSelect || ((item) => console.log(item))}
		>
			{children || (
				<div className="size-80 flex justify-center items-center border-2 border-dashed rounded-lg">
					Right click to open the radial menu
				</div>
			)}
		</RadialMenu>
	);
};
