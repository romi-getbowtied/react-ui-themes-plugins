import { createRoot, type Root } from "react-dom/client";
import "@/lib/portal-patch";

type ComponentRegistry = Record<string, React.ComponentType>;
type EnhancerRegistry = Record<string, () => void>;

const roots = new WeakMap<Element, Root>();

/**
 * Hydrates React islands and enhances server components
 * Shared logic for both frontend and backend bundles (DRY)
 */
export const hydrateIslands = (
	clientComponents: ComponentRegistry,
	serverComponents: EnhancerRegistry
) => {
	const init = () => {
		// Mount client-side React islands
		for (const [slug, Component] of Object.entries(clientComponents)) {
			for (const element of document.querySelectorAll(`[data-island="${slug}"]`)) {
				if (!roots.has(element)) {
					const root = createRoot(element);
					roots.set(element, root);
					root.render(<Component />);
				}
			}
		}

		// Enhance server-side components
		for (const enhance of Object.values(serverComponents)) enhance();
	};

	document.readyState === "loading"
		? document.addEventListener("DOMContentLoaded", init, { once: true })
		: init();
};

