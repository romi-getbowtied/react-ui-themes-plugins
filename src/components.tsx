import * as React from "react";
import { createRoot } from "react-dom/client";
import "@/lib/portal-patch";
import { clientComponents, serverComponents } from "@config/islands.config";
import "./styles/theme.css";

declare global {
	interface Window {
		twActiveComponents?: { serverSide?: string[] };
	}
}

const mountIsland = (el: Element, Component: React.ComponentType) => {
	if ((el as any).__reactRoot) return;
	(el as any).__reactRoot = createRoot(el);
	(el as any).__reactRoot.render(<Component />);
};

const init = () => {
	requestAnimationFrame(() => {
		// Mount client-side React islands
		const islandElements = Object.entries(clientComponents).flatMap(([key, Component]) =>
			Array.from(document.querySelectorAll(`[data-island="${key}"]`), el => ({ el, Component }))
		);
		
		islandElements.forEach(({ el, Component }) => mountIsland(el, Component));

		// Execute server-side enhancements for active components
		const activeSlugs = window.twActiveComponents?.serverSide || [];
		activeSlugs.forEach(slug => {
			const enhance = serverComponents[slug as keyof typeof serverComponents];
			if (enhance) enhance();
		});
	});
};

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", init, { once: true });
} else {
	init();
}
