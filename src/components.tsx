import * as React from "react";
import { createRoot } from "react-dom/client";
import "@/lib/portal-patch";
import { clientComponents, serverComponents } from "@config/components.registry";
import "./styles/theme.css";

const getReactRoot = (element: Element) => (element as any).__reactRoot;

const mountReactIsland = (element: Element, Component: React.ComponentType) => {
	if (getReactRoot(element)) return;
	const root = createRoot(element);
	(element as any).__reactRoot = root;
	root.render(<Component />);
};

const mountClientIslands = () => {
	const clientIslandElements = Object.entries(clientComponents).flatMap(([islandSlug, Component]) =>
		Array.from(document.querySelectorAll(`[data-island="${islandSlug}"]`), element => ({ element, Component }))
	);
	clientIslandElements.forEach(({ element, Component }) => mountReactIsland(element, Component));
};

const enhanceServerComponents = () => {
	Object.values(serverComponents).forEach(enhanceServerComponent => enhanceServerComponent());
};

const initializeComponents = () => {
	requestAnimationFrame(() => {
		mountClientIslands();
		enhanceServerComponents();
	});
};

const ready = (fn: () => void) => {
	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", fn, { once: true });
	} else {
		fn();
	}
};

ready(initializeComponents);
