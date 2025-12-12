export interface HydrationLockOptions {
	requiredStableFrames?: number;
	heightTolerance?: number;
	fallbackTimeout?: number;
	onRelease?: () => void;
}

/**
 * Locks container height during hydration to prevent layout jumps.
 * Uses ResizeObserver to detect when content is stable before releasing.
 */
export function lockHeightDuringHydration(
	container: Element,
	replaceContent: () => void,
	options: HydrationLockOptions = {}
): () => void {
	const {
		requiredStableFrames = 2,
		heightTolerance = 1,
		fallbackTimeout = 500,
		onRelease
	} = options;

	const el = container as HTMLElement;
	
	// Force reflow and measure height (handles scrollbar appearance)
	const measureHeight = (): number => {
		void el.offsetHeight; // Force reflow
		return el.getBoundingClientRect().height;
	};
	
	// Wait for layout to stabilize before measuring
	// This handles cases where scrollbar appears/disappears
	const getStableHeight = (): Promise<number> => {
		return new Promise((resolve) => {
			let attempts = 0;
			const maxAttempts = 3;
			
			const measure = () => {
				const h = measureHeight();
				attempts++;
				
				if (h > 0 || attempts >= maxAttempts) {
					resolve(h);
				} else {
					requestAnimationFrame(measure);
				}
			};
			
			requestAnimationFrame(() => {
				requestAnimationFrame(measure);
			});
		});
	};
	
	// Initialize variables
	let height = 0;
	let stableCount = 0;
	let lastHeight = 0;
	let released = false;
	let timeoutId: ReturnType<typeof setTimeout> | null = null;
	let observer: ResizeObserver | null = null;

	const release = () => {
		if (released || !el.style.height) return;
		released = true;
		el.style.height = '';
		el.style.overflow = '';
		onRelease?.();
	};

	const cleanup = () => {
		if (timeoutId) clearTimeout(timeoutId);
		if (observer) observer.disconnect();
	};

	// Start the process
	getStableHeight().then((h) => {
		if (h <= 0) {
			replaceContent();
			return;
		}

		height = h;
		lastHeight = h;
		
		el.style.height = `${height}px`;
		el.style.overflow = 'hidden';
		replaceContent();

		// Measure new content height to prevent clipping
		requestAnimationFrame(() => {
			const newHeight = el.scrollHeight;
			if (newHeight > height) {
				el.style.height = `${newHeight}px`;
				lastHeight = newHeight;
			}
		});

		observer = new ResizeObserver(() => {
			if (released) return;
			
			const current = el.getBoundingClientRect().height;
			const diff = Math.abs(current - lastHeight);

			if (diff <= heightTolerance) {
				if (++stableCount >= requiredStableFrames) {
					release();
					cleanup();
				}
			} else {
				stableCount = 0;
				lastHeight = current;
			}
		});

		requestAnimationFrame(() => {
			requestAnimationFrame(() => {
				if (released) return;
				observer!.observe(el);
				timeoutId = setTimeout(() => {
					if (!released) {
						release();
						cleanup();
					}
				}, fallbackTimeout);
			});
		});
	});

	return cleanup;
}

