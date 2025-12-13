import { hydrateIslands } from "@/core/island-hydrator";
import * as registry from "@config/components/ui/registry.backend";

hydrateIslands(registry.clientComponents, registry.serverComponents);

