<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GBT_Component_Expandable_Card_Demo')) {
	class GBT_Component_Expandable_Card_Demo {
		/**
		 * Render expandable card demo component
		 * 
		 * Supports any number of cards - dynamically renders all items in the array
		 * 
		 * @param array $cards Array of card data (supports 0 to unlimited cards)
		 * @param array $props Optional props array with width and height in pixels
		 * @return void
		 */
		public static function render($cards = [], $props = []) {
		// Default props (56px = h-14 w-14)
		$defaultProps = [
			'thumbnailWidth' => 56,
			'thumbnailHeight' => 56
		];
		$props = array_merge($defaultProps, $props);
		
		// Handle proportionality: if only thumbnailWidth or thumbnailHeight is provided, use it for both (square)
		if (isset($props['thumbnailWidth']) && !isset($props['thumbnailHeight'])) {
			$props['thumbnailHeight'] = $props['thumbnailWidth'];
		} elseif (isset($props['thumbnailHeight']) && !isset($props['thumbnailWidth'])) {
			$props['thumbnailWidth'] = $props['thumbnailHeight'];
		}
		
		$imageWidth = intval($props['thumbnailWidth']);
		$imageHeight = intval($props['thumbnailHeight']);
		
		if (empty($cards)) {
			return;
		}
		?>
			<div 
				data-expandable-card-container="<?php echo esc_attr('expandable-card-' . uniqid()); ?>"
				data-props="<?php echo UI_Tools::data_props($props); ?>"
			>
				<ul class="max-w-2xl mx-auto w-full gap-4">
					<?php foreach ($cards as $index => $card): ?>
						<div
							data-card-index="<?php echo esc_attr($index); ?>"
							data-card-title="<?php echo esc_attr($card['title']); ?>"
							data-card-description="<?php echo esc_attr($card['description']); ?>"
							data-card-src="<?php echo esc_url($card['src']); ?>"
							data-card-cta-text="<?php echo esc_attr($card['ctaText']); ?>"
							data-card-cta-link="<?php echo esc_url($card['ctaLink']); ?>"
							data-card-content="<?php echo esc_attr($card['content']); ?>"
							class="p-4 flex flex-row justify-between items-center hover:bg-neutral-50 dark:hover:bg-neutral-800 rounded-xl cursor-pointer"
						>
							<div class="flex gap-4 flex-row items-center">
								<div class="flex items-center shrink-0">
									<div
										role="img"
										aria-label="<?php echo esc_attr($card['title']); ?>"
										style="width: <?php echo esc_attr($imageWidth); ?>px; height: <?php echo esc_attr($imageHeight); ?>px; aspect-ratio: <?php echo esc_attr($imageWidth); ?> / <?php echo esc_attr($imageHeight); ?>; background-image: url('<?php echo esc_url($card['src']); ?>');"
										class="rounded-lg bg-cover bg-top shrink-0"
									></div>
								</div>
								<div class="flex flex-col justify-center shrink">
									<h3 class="font-bold mt-2 mb-2 text-neutral-800 dark:text-neutral-200 text-left">
										<?php echo esc_html($card['title']); ?>
									</h3>
									<p class="mt-0 mb-2 text-neutral-600 dark:text-neutral-400 text-left">
										<?php echo esc_html($card['description']); ?>
									</p>
								</div>
							</div>
							<button class="px-4 py-2 text-sm rounded-full font-bold bg-gray-100 hover:bg-green-500 hover:text-white text-black mt-0">
								<?php echo esc_html($card['ctaText']); ?>
							</button>
						</div>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php
		}
	}
}

