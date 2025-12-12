import * as React from 'react';
import { FloatingDock } from "@/components/ui/floating-dock";
import {
	IconBrandGithub,
	IconBrandX,
	IconExchange,
	IconHome,
	IconNewSection,
	IconTerminal2,
} from "@tabler/icons-react";

/**
 * Icon mapping for Tabler icons.
 * Available icon names: IconHome, IconTerminal2, IconNewSection, IconExchange, IconBrandX, IconBrandGithub
 */
const iconMap: Record<string, React.ComponentType<any>> = {
	IconHome,
	IconTerminal2,
	IconNewSection,
	IconExchange,
	IconBrandX,
	IconBrandGithub,
};

/**
 * Link item configuration
 */
type LinkItem = {
	/** Display title for the dock item */
	title: string;
	/** 
	 * Icon can be:
	 * - A string matching an icon name from iconMap (e.g., 'IconHome')
	 * - An image URL (will be rendered as <img>)
	 * - A React node (passed through as-is)
	 */
	icon: string | React.ReactNode;
	/** Link URL */
	href: string;
};

/**
 * Props for FloatingDockDemo component
 */
type FloatingDockDemoProps = {
	/** Array of dock items to display */
	items?: LinkItem[];
	/** Optional CSS class for the dock */
	className?: string;
};

/**
 * FloatingDockDemo Component
 * 
 * A floating dock navigation component that displays items with icons.
 * Supports dynamic configuration via props passed from PHP.
 * 
 * @example
 * // From PHP:
 * $dock_items = [
 *     ['title' => 'Home', 'icon' => 'IconHome', 'href' => '#'],
 *     ['title' => 'Products', 'icon' => 'IconTerminal2', 'href' => '#'],
 *     ['title' => 'Logo', 'icon' => 'https://example.com/logo.png', 'href' => '#'],
 * ];
 * 
 * <div 
 *     data-island="floating-dock" 
 *     data-props="<?php echo esc_attr(json_encode(['items' => $dock_items])); ?>"
 * ></div>
 * 
 * @param {FloatingDockDemoProps} props - Component props
 * @param {LinkItem[]} [props.items=[]] - Array of dock items
 * @param {string} [props.className] - CSS class for the dock
 * 
 * @returns {JSX.Element} Floating dock component
 */
export function FloatingDockDemo({ 
	items = [], 
	className 
}: FloatingDockDemoProps) {
	// Transform items: convert icon strings to React components
	const linksWithIcons = items.map(item => {
		let icon: React.ReactNode;
		
		if (typeof item.icon === 'string') {
			// Check if it's a known icon name from iconMap
			const IconComponent = iconMap[item.icon];
			if (IconComponent) {
				// Render as Tabler icon component
				icon = <IconComponent className="h-full w-full text-neutral-500 dark:text-neutral-300" />;
			} else {
				// Assume it's an image URL and render as <img>
				icon = <img src={item.icon} width={20} height={20} alt={item.title} />;
			}
		} else {
			// Already a React node, use as-is
			icon = item.icon;
		}
		
		return {
			title: item.title,
			icon,
			href: item.href,
		};
	});

	return (
		<div className="flex items-center justify-center w-full">
			<FloatingDock
				className={className}
				items={linksWithIcons}
			/>
		</div>
	);
}

