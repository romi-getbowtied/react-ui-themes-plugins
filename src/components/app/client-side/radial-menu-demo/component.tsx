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

// Icon mapping for dynamic icon loading
const iconMap: Record<string, LucideIcon> = {
	Copy,
	Scissors,
	ClipboardPaste,
	Trash2,
	Star,
	Pin,
};

// Default menu items fallback
const DEFAULT_MENU_ITEMS = [
	{ id: 1, label: 'Copy', icon: Copy },
	{ id: 2, label: 'Cut', icon: Scissors },
	{ id: 3, label: 'Paste', icon: ClipboardPaste },
	{ id: 4, label: 'Favorite', icon: Star },
	{ id: 5, label: 'Pin', icon: Pin },
	{ id: 6, label: 'Delete', icon: Trash2 },
];

type MenuItemData = {
	id: number;
	label: string;
	icon: string; // Icon name as string
};

type RadialMenuDemoProps = {
	menuItems?: MenuItemData[];
	onSelect?: (item: { id: number; label: string; icon: LucideIcon }) => void;
	children?: React.ReactNode;
};

export const RadialMenuDemo = ({ 
	menuItems: menuItemsProp, 
	onSelect: onSelectProp,
	children 
}: RadialMenuDemoProps) => {
	// Process menu items: convert icon strings to icon components
	const menuItems = React.useMemo(() => {
		const items = menuItemsProp || DEFAULT_MENU_ITEMS;
		
		// If items already have icon components, return as-is
		if (items.length > 0 && typeof items[0].icon !== 'string') {
			return items as Array<{ id: number; label: string; icon: LucideIcon }>;
		}
		
		// Convert icon strings to icon components
		return (items as MenuItemData[]).map(item => ({
			id: item.id,
			label: item.label,
			icon: iconMap[item.icon] || Copy, // Fallback to Copy if icon not found
		}));
	}, [menuItemsProp]);

	const handleSelect = React.useCallback((item: { id: number; label: string; icon: LucideIcon }) => {
		if (onSelectProp) {
			onSelectProp(item);
		} else {
			console.log(item);
			// run your action here
		}
	}, [onSelectProp]);

	return (
		<RadialMenu
			menuItems={menuItems}
			onSelect={handleSelect}
		>
			{children || (
				<div className="size-80 flex justify-center items-center border-2 border-dashed rounded-lg">
					Right click to open the radial menu
				</div>
			)}
		</RadialMenu>
	);
};
