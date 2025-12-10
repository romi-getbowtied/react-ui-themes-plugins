/**
 * Backend (Admin) Bundle Entry Point
 * Loaded only in WordPress admin area
 */
import { hydrateIslands } from "@/core/island-hydrator";
import { clientComponents, serverComponents } from "@config/components.registry.backend";
import "./styles/theme.css";

hydrateIslands(clientComponents, serverComponents);

