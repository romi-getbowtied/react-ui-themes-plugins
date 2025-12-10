import { createRoot, type Root } from "react-dom/client";
import "@/lib/portal-patch";
import { clientComponents, serverComponents } from "@config/components.registry";
import "./styles/theme.css";

const roots = new WeakMap<Element, Root>();

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
