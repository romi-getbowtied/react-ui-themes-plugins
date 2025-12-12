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
	const height = el.getBoundingClientRect().height;

	if (height <= 0) {
		replaceContent();
		return () => {};
	}

	el.style.height = `${height}px`;
	el.style.overflow = 'hidden';
	replaceContent();

	// Measure new content height immediately to prevent clipping
	requestAnimationFrame(() => {
		const newHeight = el.scrollHeight;
		if (newHeight > height) {
			el.style.height = `${newHeight}px`;
		}
	});

	let stableCount = 0;
	let lastHeight = height;
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

	return cleanup;
}

