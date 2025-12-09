import { Button } from "@/components/ui/button";
import { toast } from "sonner";

export function SonnerButtonIsland() {
	return (
		<div className="flex gap-2">
			<Button
				onClick={() => toast.success("Success!", { description: "Your action was completed successfully." })}
			>
				Success Toast
			</Button>
			<Button
				variant="destructive"
				onClick={() => toast.error("Error!", { description: "Something went wrong." })}
			>
				Error Toast
			</Button>
			<Button
				variant="outline"
				onClick={() => toast.info("Info", { description: "Here's some information." })}
			>
				Info Toast
			</Button>
		</div>
	);
}

