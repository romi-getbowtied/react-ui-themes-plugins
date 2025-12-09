import ReactDOM from "react-dom";
import { ReactNode, Key } from "react";

/**
 * Global Portal Patch
 * 
 * Intercepts React's createPortal to force portals (like Radix UI primitives)
 * to render inside our scoped container (#tw-theme-app) instead of document.body.
 * 
 * This ensures all portaled content inherits our scoped Tailwind styles (important: "#tw-theme-app").
 */

const originalCreatePortal = ReactDOM.createPortal;

ReactDOM.createPortal = (children: ReactNode, container: Element | DocumentFragment, key?: Key | null) => {
  // Find our app's root container
  const root = document.getElementById("tw-theme-app");
  
  // If the portal is targeting body (default for Radix) and our root exists, redirect to our root
  // Otherwise, behave normally
  return originalCreatePortal(children, (container === document.body && root) ? root : container, key);
};

