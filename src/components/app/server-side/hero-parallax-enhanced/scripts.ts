/**
 * Hero Parallax Enhancement - Optimized for maximum FPS with GPU acceleration
 */

export function enhanceHeroParallax() {
	// Defer all DOM queries to avoid forced reflow on init
	requestAnimationFrame(() => {
		const section = document.querySelector('.hero-parallax-section') as HTMLElement;
	if (!section) return;
	
		const container = section.querySelector('.hero-parallax-container') as HTMLElement;
	if (!container) return;
	
		// Cache row elements and directions
		const rows = Array.from(container.querySelectorAll('.hero-parallax-row')) as HTMLElement[];
		const rowDirections = rows.map((row) => row.getAttribute('data-direction') === 'reverse');
		
		// Set 3D transform styles once
		section.style.perspective = '1000px';
		section.style.transformStyle = 'preserve-3d';
	
		// Cache dimensions (read once in RAF)
		let windowHeight = window.innerHeight;
		const rect = section.getBoundingClientRect();
		let sectionHeight = rect.height;
		let resizeTimeout: ReturnType<typeof setTimeout>;
		
		const updateDimensions = () => {
			windowHeight = window.innerHeight;
			// Read layout property only when needed (inside RAF)
			requestAnimationFrame(() => {
				sectionHeight = section.getBoundingClientRect().height;
			});
		};
		
		window.addEventListener('resize', () => {
			clearTimeout(resizeTimeout);
			resizeTimeout = setTimeout(updateDimensions, 150);
		}, { passive: true });
		
		let ticking = false;
		let rafId: number;
		
		const updateParallax = () => {
			// Single layout read
			const sectionTop = section.getBoundingClientRect().top;
			
			// Calculate progress (0 to 1)
			const scrollProgress = Math.max(0, Math.min(1, -sectionTop / (sectionHeight - windowHeight)));
		
			// Pre-calculate all values
		const translateX = scrollProgress * 1000;
			const translateXReverse = -translateX;
		const rotateX = (1 - scrollProgress) * 15;
		const rotateZ = (1 - scrollProgress) * 20;
		const translateY = scrollProgress * 1200 - 700;
		const opacity = Math.max(0.2, Math.min(1, scrollProgress * 4));
		
			// Use transform3d for GPU acceleration
			const containerTransform = `translate3d(0, ${translateY}px, 0) rotateX(${rotateX}deg) rotateZ(${rotateZ}deg)`;
			container.style.transform = containerTransform;
			container.style.opacity = String(opacity);
			
			// Apply row transforms (GPU accelerated)
			rows.forEach((row, i) => {
				const translate = rowDirections[i] ? translateX : translateXReverse;
				row.style.transform = `translate3d(${translate}px, 0, 0)`;
			});
		
		ticking = false;
	};
	
	const onScroll = () => {
		if (!ticking) {
				rafId = requestAnimationFrame(updateParallax);
			ticking = true;
		}
	};
	
		// Register scroll listener
	window.addEventListener('scroll', onScroll, { passive: true });
		
		// Initial update (already in RAF context)
		updateParallax();
	});
}
