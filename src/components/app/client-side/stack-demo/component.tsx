import Stack from '@/components/ui/images-stack';

/**
 * Props for StackDemo component
 */
type StackDemoProps = {
	/** Array of image URLs to display in the stack */
	images?: string[];
	/** Enable random rotation for cards */
	randomRotation?: boolean;
	/** Sensitivity threshold for drag-to-send-back (in pixels) */
	sensitivity?: number;
	/** Send card to back on click */
	sendToBackOnClick?: boolean;
	/** Animation configuration */
	animationConfig?: { stiffness: number; damping: number };
	/** Enable autoplay */
	autoplay?: boolean;
	/** Autoplay delay in milliseconds */
	autoplayDelay?: number;
	/** Pause autoplay on hover */
	pauseOnHover?: boolean;
	/** Drag elastic value (0-1) for drag resistance */
	dragElastic?: number;
	/** Enable drag functionality */
	dragEnabled?: boolean;
	/** Container width */
	width?: number;
	/** Container height */
	height?: number;
};

/**
 * StackDemo Component
 * 
 * A stack of draggable cards with images that can be sent to the back.
 * Supports dynamic configuration via props passed from PHP.
 * 
 * @example
 * // From PHP:
 * $images = [
 *     'https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?q=80&w=500&auto=format',
 *     'https://images.unsplash.com/photo-1449844908441-8829872d2607?q=80&w=500&auto=format',
 *     'https://images.unsplash.com/photo-1452626212852-811d58933cae?q=80&w=500&auto=format',
 *     'https://images.unsplash.com/photo-1572120360610-d971b9d7767c?q=80&w=500&auto=format',
 * ];
 * 
 * <div 
 *     data-island="stack-demo" 
 *     data-props="<?php echo esc_attr(json_encode([
 *         'images' => $images,
 *         'randomRotation' => true,
 *         'sensitivity' => 180,
 *         'sendToBackOnClick' => true,
 *         'width' => 208,
 *         'height' => 208
 *     ])); ?>"
 * ></div>
 * 
 * @param {StackDemoProps} props - Component props
 * @param {string[]} [props.images=[]] - Array of image URLs
 * @param {boolean} [props.randomRotation=false] - Enable random rotation
 * @param {number} [props.sensitivity=200] - Drag sensitivity threshold
 * @param {boolean} [props.sendToBackOnClick=false] - Send to back on click
 * @param {{ stiffness: number; damping: number }} [props.animationConfig] - Animation config
 * @param {boolean} [props.autoplay=false] - Enable autoplay
 * @param {number} [props.autoplayDelay=3000] - Autoplay delay
 * @param {boolean} [props.pauseOnHover=false] - Pause on hover
 * @param {number} [props.width=208] - Container width
 * @param {number} [props.height=208] - Container height
 * 
 * @returns {JSX.Element} Stack component
 */
export function StackDemo({
	images,
	randomRotation = true,
	sensitivity = 180,
	sendToBackOnClick = true,
	autoplay = true,
	autoplayDelay = 3000,
	pauseOnHover = true,
	dragElastic = 0.6,
	dragEnabled = true,
	width = 208,
	height = 208,
}: StackDemoProps) {
	const imageList = images || [
		"https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?q=80&w=500&auto=format",
		"https://images.unsplash.com/photo-1449844908441-8829872d2607?q=80&w=500&auto=format",
		"https://images.unsplash.com/photo-1452626212852-811d58933cae?q=80&w=500&auto=format",
		"https://images.unsplash.com/photo-1572120360610-d971b9d7767c?q=80&w=500&auto=format"
	];

	return (
		<div style={{ width, height }}>
			<Stack
				randomRotation={randomRotation}
				sensitivity={sensitivity}
				sendToBackOnClick={sendToBackOnClick}
				autoplay={autoplay}
				autoplayDelay={autoplayDelay}
				pauseOnHover={pauseOnHover}
				dragElastic={dragElastic}
				dragEnabled={dragEnabled}
				cards={imageList.map((src, i) => (
					<img 
						key={i} 
						src={src} 
						alt={`card-${i + 1}`} 
						style={{ width: '100%', height: '100%', objectFit: 'cover' }}
						className="pointer-events-none"
					/>
				))}
			/>
		</div>
	);
}

