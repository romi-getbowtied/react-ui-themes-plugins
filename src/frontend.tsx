/**
 * Frontend (Public) Bundle Entry Point
 * Loaded only on public-facing WordPress pages
 */
import { hydrateIslands } from "@/core/island-hydrator";
import { clientComponents, serverComponents } from "@config/components.registry.frontend";
import "./styles/theme.css";

hydrateIslands(clientComponents, serverComponents);

