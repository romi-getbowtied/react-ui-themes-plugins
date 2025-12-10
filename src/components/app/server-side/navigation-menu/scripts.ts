/**
 * Navigation Menu Enhancement - Optimized for maximum FPS
 */

export function navigationMenu() {
	// Defer DOM query to avoid forced reflow on init
	requestAnimationFrame(() => {
	const nav = document.querySelector('nav[role="navigation"]');
	if (!nav) return;
	
	const menuItems = Array.from(nav.querySelectorAll('.menu-item-has-children')) as HTMLElement[];
	if (menuItems.length === 0) return;
	
	// Cache all submenus and links upfront
	const menuData = menuItems.map((item) => {
		const link = item.querySelector('a');
		const subMenu = item.querySelector('.sub-menu') as HTMLElement;
		return { item, link, subMenu };
	}).filter(({ link, subMenu }) => link && subMenu);
	
	if (menuData.length === 0) return;
		
	// Cache window width
	let windowWidth = window.innerWidth;
	let resizeTimeout: ReturnType<typeof setTimeout>;
	
	window.addEventListener('resize', () => {
		clearTimeout(resizeTimeout);
		resizeTimeout = setTimeout(() => { windowWidth = window.innerWidth; }, 150);
	}, { passive: true });
	
	// Optimized toggle function - uses single class toggle
	const toggleSubMenu = (target: HTMLElement, show: boolean) => {
		target.classList.toggle('opacity-100', show);
		target.classList.toggle('visible', show);
		target.classList.toggle('opacity-0', !show);
		target.classList.toggle('invisible', !show);
	};
	
	// Close all submenus except target
	const closeOthers = (except: HTMLElement) => {
		menuData.forEach(({ subMenu }) => {
			if (subMenu && subMenu !== except) {
				toggleSubMenu(subMenu, false);
			}
		});
	};
	
	// Setup event handlers
	menuData.forEach(({ item, link, subMenu }) => {
		if (!link) return; // Type guard
		
		// Mobile click handler
		link.addEventListener('click', (e) => {
			if (windowWidth < 768) {
				e.preventDefault();
				const isOpen = subMenu.classList.contains('opacity-100');
				closeOthers(subMenu);
				toggleSubMenu(subMenu, !isOpen);
					}
		}, { passive: false });
		
		// Desktop hover handlers (no RAF needed - CSS handles transitions)
		item.addEventListener('mouseenter', () => {
			if (windowWidth >= 768) toggleSubMenu(subMenu, true);
		}, { passive: true });
		
		item.addEventListener('mouseleave', () => {
			if (windowWidth >= 768) toggleSubMenu(subMenu, false);
		}, { passive: true });
	});
	
		// Close on outside click
	document.addEventListener('click', (e) => {
		if (!nav.contains(e.target as Node)) {
				menuData.forEach(({ subMenu }) => toggleSubMenu(subMenu, false));
				}
		}, { passive: true });
	});
}
