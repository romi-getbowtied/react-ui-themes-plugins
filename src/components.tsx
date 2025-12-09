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

	requestAnimationFrame(async () => {
		// Load and execute server-side enhancements for active components
		const activeServerComponents = window.twActiveComponents?.serverSide || [];
		for (const slug of activeServerComponents) {
			const loader = serverComponents[slug as keyof typeof serverComponents];
			if (loader) {
				const enhance = await loader();
				enhance();
			}
		}
		
		islandElements.forEach(({ el, Component }) => mountIsland(el, Component));
	});
};

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", init, { once: true });
} else {
	init();
}
