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

const iconMap: Record<string, LucideIcon> = {
	Copy,
	Scissors,
	ClipboardPaste,
	Trash2,
	Star,
	Pin,
};

type MenuItemData = {
	id: number;
	label: string;
	icon: string;
};

type RadialMenuDemoProps = {
	menuItems?: MenuItemData[];
	onSelect?: (item: { id: number; label: string; icon: LucideIcon }) => void;
	children?: React.ReactNode;
};

export const RadialMenuDemo = ({ 
	menuItems = [], 
	onSelect,
	children 
}: RadialMenuDemoProps) => {
	const menuItemsWithIcons = menuItems.map(item => ({
		id: item.id,
		label: item.label,
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
