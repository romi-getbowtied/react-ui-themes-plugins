declare const REGISTRY: string;

import { hydrateIslands } from "@/core/island-hydrator";
import "./styles/theme.css";

import(REGISTRY).then(r => hydrateIslands(r.clientComponents, r.serverComponents));
