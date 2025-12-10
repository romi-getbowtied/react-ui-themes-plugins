/**
 * Bento Grid Enhanced - Optimized for maximum FPS
 */
export function bentoGrid() {
	// Defer DOM query to avoid forced reflow on init
	requestAnimationFrame(() => {
		const bentoGrids = document.querySelectorAll('.bento-grid-section');
		if (bentoGrids.length === 0) return;
		
		// Single observer for all grids (more efficient)
		const observer = new IntersectionObserver(
			(entries) => {
				// Batch class additions
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						entry.target.classList.add('animate-in');
						observer.unobserve(entry.target); // Unobserve immediately
					}
				});
			},
			{ threshold: 0.1, rootMargin: '50px' }
		);
		
		// Observe all items at once
		bentoGrids.forEach((grid) => {
			grid.querySelectorAll('article').forEach((item) => observer.observe(item));
		});
	});
}

