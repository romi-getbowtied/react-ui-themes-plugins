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
	requestAnimationFrame(async () => {
		// Load client components in parallel
		const islandElements = await Promise.all(
			Object.entries(clientComponents).flatMap(async ([key, loader]) => {
				const Component = (await loader()).default;
				return Array.from(document.querySelectorAll(`[data-island="${key}"]`), el => ({ el, Component }));
			})
		).then(results => results.flat());

		// Load and execute server-side enhancements in parallel
		const activeSlugs = window.twActiveComponents?.serverSide || [];
		const serverLoaders = activeSlugs
			.map(slug => serverComponents[slug as keyof typeof serverComponents])
			.filter(Boolean);
		
		await Promise.all(serverLoaders.map(loader => loader().then(enhance => enhance())));
		islandElements.forEach(({ el, Component }) => mountIsland(el, Component));
	});
};

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", init, { once: true });
} else {
	init();
}
