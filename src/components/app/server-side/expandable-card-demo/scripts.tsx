import React, { useEffect, useId, useRef, useState } from "react";
import { createRoot } from "react-dom/client";
import { AnimatePresence, motion } from "motion/react";
import { useOutsideClick } from "@/hooks/use-outside-click";
import { lockHeightDuringHydration } from "@/lib/hydration-utils";

/**
 * Card data structure
 */
type CardData = {
	title: string;
	description: string;
	src: string;
	ctaText: string;
	ctaLink: string;
	content: string;
};

const CloseIcon = () => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="24"
		height="24"
		viewBox="0 0 24 24"
		fill="none"
		stroke="currentColor"
		strokeWidth="2"
		strokeLinecap="round"
		strokeLinejoin="round"
		className="h-4 w-4 text-black"
	>
		<path d="M18 6l-12 12" />
		<path d="M6 6l12 12" />
	</svg>
);

function ExpandableCardComponent({ cards, thumbnailWidth = 56, thumbnailHeight = 56 }: { cards: CardData[]; thumbnailWidth?: number; thumbnailHeight?: number }) {
	const [activeIndex, setActiveIndex] = useState<number | null>(null);
	const ref = useRef<HTMLDivElement>(null);
	const id = useId();
	
	// Handle proportionality: if only thumbnailWidth or thumbnailHeight is provided, use it for both (square)
	const imageWidth = thumbnailWidth || thumbnailHeight || 56;
	const imageHeight = thumbnailHeight || thumbnailWidth || 56;

	const active = activeIndex !== null ? cards[activeIndex] : null;
	const close = () => setActiveIndex(null);

	useEffect(() => {
		if (!active) return;

		const handleEscape = (e: KeyboardEvent) => e.key === "Escape" && close();
		document.body.style.overflow = "hidden";
		window.addEventListener("keydown", handleEscape);
		return () => {
			document.body.style.overflow = "auto";
			window.removeEventListener("keydown", handleEscape);
		};
	}, [active]);

	useOutsideClick(ref, close);

	return (
		<>
			<AnimatePresence>
				{active && (
					<motion.div
						initial={{ opacity: 0 }}
						animate={{ opacity: 1 }}
						exit={{ opacity: 0 }}
						className="fixed inset-0 bg-black/20 h-full w-full z-10"
					/>
				)}
			</AnimatePresence>
			<AnimatePresence>
				{active ? (
					<div className="fixed inset-0 grid place-items-center z-50">
						<motion.button
							key={`close-${activeIndex}-${id}`}
							layout
							initial={{ opacity: 0 }}
							animate={{ opacity: 1 }}
							exit={{ opacity: 0, transition: { duration: 0.05 } }}
							className="flex absolute top-2 right-2 lg:hidden items-center justify-center bg-white rounded-full h-6 w-6"
							onClick={close}
						>
							<CloseIcon />
						</motion.button>
						<motion.div
							layoutId={`card-${activeIndex}-${id}`}
							ref={ref}
							className="w-full max-w-[500px]  h-full md:h-fit md:max-h-[90%]  flex flex-col bg-white dark:bg-neutral-900 sm:rounded-3xl overflow-hidden"
						>
							<motion.div layoutId={`image-${activeIndex}-${id}`}>
								<div
									role="img"
									aria-label={active.title}
									style={{ backgroundImage: `url('${active.src}')` }}
									className="w-full h-80 lg:h-80 sm:rounded-tr-lg sm:rounded-tl-lg bg-cover bg-top"
								/>
							</motion.div>

							<div>
								<div className="flex justify-between items-start p-4">
									<div className="">
										<motion.h3
											layoutId={`title-${activeIndex}-${id}`}
											className="font-bold mt-2 mb-2 text-neutral-700 dark:text-neutral-200"
										>
											{active.title}
										</motion.h3>
										<motion.p
											layoutId={`description-${activeIndex}-${id}`}
											className="mt-0 mb-2 text-neutral-600 dark:text-neutral-400"
										>
											{active.description}
										</motion.p>
									</div>

									<motion.a
										layoutId={`button-${activeIndex}-${id}`}
										href={active.ctaLink}
										target="_blank"
										className="px-4 py-3 text-sm rounded-full font-bold bg-green-500 text-white"
									>
										{active.ctaText}
									</motion.a>
								</div>
								<div className="pt-4 relative px-4">
									<motion.div
										layout
										initial={{ opacity: 0 }}
										animate={{ opacity: 1 }}
										exit={{ opacity: 0 }}
										className="text-neutral-600 text-xs md:text-sm lg:text-base h-40 md:h-fit pb-10 flex flex-col items-start gap-4 overflow-auto dark:text-neutral-400 [mask:linear-gradient(to_bottom,white,white,transparent)] [scrollbar-width:none] [-ms-overflow-style:none]"
									>
										<p>{active.content}</p>
									</motion.div>
								</div>
							</div>
						</motion.div>
					</div>
				) : null}
			</AnimatePresence>
			<ul className="max-w-2xl mx-auto w-full gap-4">
				{cards.map((card, index) => (
					<motion.div
						key={`card-${index}`}
						layoutId={`card-${index}-${id}`}
						onClick={() => setActiveIndex(index)}
						className="p-4 flex flex-row justify-between items-center hover:bg-neutral-50 dark:hover:bg-neutral-800 rounded-xl cursor-pointer"
					>
						<div className="flex gap-4 flex-row items-center">
							<motion.div layoutId={`image-${index}-${id}`} className="flex items-center shrink-0">
								<div
									role="img"
									aria-label={card.title}
									style={{
										width: `${imageWidth}px`,
										height: `${imageHeight}px`,
										aspectRatio: `${imageWidth} / ${imageHeight}`,
										backgroundImage: `url('${card.src}')`
									}}
									className="rounded-lg bg-cover bg-top shrink-0"
								/>
							</motion.div>
							<div className="flex flex-col justify-center shrink">
								<motion.h3
									layoutId={`title-${index}-${id}`}
									className="font-bold mt-2 mb-2 text-neutral-800 dark:text-neutral-200 text-left"
								>
									{card.title}
								</motion.h3>
								<motion.p
									layoutId={`description-${index}-${id}`}
									className="mt-0 mb-2 text-neutral-600 dark:text-neutral-400 text-left"
								>
									{card.description}
								</motion.p>
							</div>
						</div>
						<motion.button
							layoutId={`button-${index}-${id}`}
							className="px-4 py-2 text-sm rounded-full font-bold bg-gray-100 hover:bg-green-500 hover:text-white text-black mt-0"
						>
							{card.ctaText}
						</motion.button>
					</motion.div>
				))}
			</ul>
		</>
	);
}

const extractCardData = (el: Element): CardData => ({
	title: el.getAttribute('data-card-title') || '',
	description: el.getAttribute('data-card-description') || '',
	src: el.getAttribute('data-card-src') || '',
	ctaText: el.getAttribute('data-card-cta-text') || '',
	ctaLink: el.getAttribute('data-card-cta-link') || '#',
	content: el.getAttribute('data-card-content') || '',
});

export function expandableCardDemo() {
	document.querySelectorAll('[data-expandable-card-container]').forEach((container) => {
		const cards: CardData[] = Array.from(
			container.querySelectorAll('[data-card-index]'),
			extractCardData
		);

		if (!cards.length) return;

		// Parse props from data-props attribute (same pattern as client components)
		let props: { thumbnailWidth?: number; thumbnailHeight?: number } = {};
		const propsData = container.getAttribute('data-props');
		if (propsData) {
			try {
				props = JSON.parse(propsData);
			} catch (e) {
				console.warn('Failed to parse data-props for expandable-card-demo:', e);
			}
		}

		// Handle proportionality: if only thumbnailWidth or thumbnailHeight is provided, use it for both (square)
		const thumbnailWidth = props.thumbnailWidth || props.thumbnailHeight || 56;
		const thumbnailHeight = props.thumbnailHeight || props.thumbnailWidth || 56;

		// Prevent layout jumps during hydration using reusable utility
		lockHeightDuringHydration(container, () => {
			// Remove server-rendered content
			container.querySelector('ul')?.remove();
			
			// Render React component
			createRoot(container).render(
				<ExpandableCardComponent 
					cards={cards} 
					thumbnailWidth={thumbnailWidth} 
					thumbnailHeight={thumbnailHeight} 
				/>
			);
		});
	});
}

