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
					let props = {};
					const propsData = el.getAttribute('data-props');
					if (propsData) {
						try {
							props = JSON.parse(propsData);
						} catch (e) {
							console.warn(`Failed to parse data-props for ${slug}:`, e);
						}
					}
					
					const htmlEl = el as HTMLElement;
					const root = createRoot(el);
					roots.set(el, root);
					root.render(<C {...props} />);
					
					// Remove height after React renders
					if (htmlEl.style.height) {
						setTimeout(() => {
							requestAnimationFrame(() => {
								requestAnimationFrame(() => {
									htmlEl.style.height = '';
								});
							});
						}, 500);
					}
				}
			})
		);
		Object.values(server).forEach(fn => fn());
	};

	document.readyState === "loading" ? addEventListener("DOMContentLoaded", init, { once: true }) : init();
};
