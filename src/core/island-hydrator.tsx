import * as React from "react";
import { createRoot, type Root } from "react-dom/client";
import "@/lib/portal-patch";

const roots = new WeakMap<Element, Root>();

export const hydrateIslands = (
	client: Record<string, React.ComponentType>,
	server: Record<string, () => void>
) => {
	const init = () => {
		Object.entries(client).forEach(([slug, C]) =>
			document.querySelectorAll(`[data-island="${slug}"]`).forEach(el => {
				if (!roots.has(el)) {
					// Extract props from data attributes
					const props: Record<string, any> = {};
					
					// Check for data-props attribute (JSON)
					const propsData = el.getAttribute('data-props');
					if (propsData) {
						try {
							Object.assign(props, JSON.parse(propsData));
						} catch (e) {
							console.warn(`Failed to parse data-props for ${slug}:`, e);
						}
					}
					
					// Also check for individual data-* attributes (except data-island)
					Array.from(el.attributes).forEach(attr => {
						if (attr.name.startsWith('data-') && attr.name !== 'data-island' && attr.name !== 'data-props') {
							const key = attr.name.replace('data-', '').replace(/-([a-z])/g, (_, letter) => letter.toUpperCase());
							try {
								// Try to parse as JSON, fallback to string
								props[key] = JSON.parse(attr.value);
							} catch {
								props[key] = attr.value;
							}
						}
					});
					
					roots.set(el, createRoot(el)).get(el)!.render(<C {...props} />);
				}
			})
		);
		Object.values(server).forEach(fn => fn());
	};

	document.readyState === "loading" ? addEventListener("DOMContentLoaded", init, { once: true }) : init();
};
