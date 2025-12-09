import * as React from "react";
import { createRoot } from "react-dom/client";
import "@/lib/portal-patch";
import { clientComponents } from "@config/client-components.config";
import { enhanceNavigationMenu } from "@/components/app/server-side/navigation-menu-enhanced/scripts";
import { enhanceHeroParallax } from "@/components/app/server-side/hero-parallax-enhanced/scripts";
import { enhanceBentoGrid } from "@/components/app/server-side/bento-grid-enhanced/scripts";
import { enhanceAppleCardsCarousel } from "@/components/app/server-side/apple-cards-carousel-enhanced/scripts";
import "./styles/theme.css";

declare global {
	interface Window {
		twActiveComponents?: { serverSide?: string[] };
	}
}

const enhancements: Record<string, () => void> = {
	"navigation-menu-enhanced": enhanceNavigationMenu,
	"hero-parallax-enhanced": enhanceHeroParallax,
	"bento-grid-enhanced": enhanceBentoGrid,
	"apple-cards-carousel-enhanced": enhanceAppleCardsCarousel,
};

const islands = clientComponents as Record<string, React.ComponentType>;

const mountIsland = (el: Element, Component: React.ComponentType) => {
	if ((el as any).__reactRoot) return;
	(el as any).__reactRoot = createRoot(el);
	(el as any).__reactRoot.render(<Component />);
};

const init = () => {
	const islandElements = Object.entries(islands).flatMap(([key, Component]) =>
			Array.from(document.querySelectorAll(`[data-island="${key}"]`), el => ({ el, Component }))
		);

	requestAnimationFrame(() => {
		(window.twActiveComponents?.serverSide || []).forEach(slug => enhancements[slug]?.());
		islandElements.forEach(({ el, Component }) => mountIsland(el, Component));
	});
};

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", init, { once: true });
} else {
	init();
}
