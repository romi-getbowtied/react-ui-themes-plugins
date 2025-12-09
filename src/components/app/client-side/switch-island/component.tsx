import * as React from "react";
import { Switch } from "@/components/ui/switch";
import { toast } from "sonner";

export function SwitchIsland() {
	const [enabled, setEnabled] = React.useState(false);
	
	return (
		<div className="flex items-center gap-4">
			<label htmlFor="switch-demo" className="text-sm font-medium">
				Enable notifications
			</label>
			<Switch
				id="switch-demo"
				checked={enabled}
				onCheckedChange={(checked) => {
					setEnabled(checked);
					toast.success(checked ? "Notifications enabled" : "Notifications disabled");
				}}
			/>
		</div>
	);
}

