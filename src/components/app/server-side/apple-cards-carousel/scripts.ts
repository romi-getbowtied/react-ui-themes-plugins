/**
 * Apple Cards Carousel Enhancement - Optimized for maximum FPS
 */

export function appleCardsCarousel() {
	requestAnimationFrame(() => {
		document.querySelectorAll('.apple-cards-carousel').forEach((carousel) => {
			const container = carousel.querySelector('.overflow-x-scroll') as HTMLElement;
			if (!container) return;
			
			const prev = carousel.querySelector('.carousel-prev') as HTMLButtonElement;
			const next = carousel.querySelector('.carousel-next') as HTMLButtonElement;
			
			let ticking = false;
			const update = () => {
				const { scrollLeft, scrollWidth, clientWidth } = container;
				if (prev) prev.disabled = scrollLeft <= 0;
				if (next) next.disabled = scrollLeft >= scrollWidth - clientWidth - 1;
				ticking = false;
			};
			
			const requestUpdate = () => {
				if (!ticking) {
					requestAnimationFrame(update);
					ticking = true;
				}
			};
			
			container.addEventListener('scroll', requestUpdate, { passive: true });
			update();
			
			if (prev) prev.addEventListener('click', () => container.scrollBy({ left: -300, behavior: 'smooth' }), { passive: true });
			if (next) next.addEventListener('click', () => container.scrollBy({ left: 300, behavior: 'smooth' }), { passive: true });
		});
	});
}
