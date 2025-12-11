<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GBT_Component_Expandable_Card_Demo')) {
	class GBT_Component_Expandable_Card_Demo {
		/**
		 * Render expandable card demo component
		 * 
		 * @param array $cards Array of card data
		 * @return void
		 */
		public static function render($cards = []) {
			$default_cards = [
				[
					'title' => 'Summertime Sadness',
					'description' => 'Lana Del Rey',
					'src' => 'https://assets.aceternity.com/demos/lana-del-rey.jpeg',
					'ctaText' => 'Play',
					'ctaLink' => 'https://ui.aceternity.com/templates',
					'content' => 'Lana Del Rey, an iconic American singer-songwriter, is celebrated for her melancholic and cinematic music style. Born Elizabeth Woolridge Grant in New York City, she has captivated audiences worldwide with her haunting voice and introspective lyrics.',
				],
				[
					'title' => 'Mitran Di Chhatri',
					'description' => 'Babbu Maan',
					'src' => 'https://assets.aceternity.com/demos/babbu-maan.jpeg',
					'ctaText' => 'Play',
					'ctaLink' => 'https://ui.aceternity.com/templates',
					'content' => 'Babu Maan, a legendary Punjabi singer, is renowned for his soulful voice and profound lyrics that resonate deeply with his audience. Born in the village of Khant Maanpur in Punjab, India, he has become a cultural icon in the Punjabi music industry.',
				],
				[
					'title' => 'For Whom The Bell Tolls',
					'description' => 'Metallica',
					'src' => 'https://assets.aceternity.com/demos/metallica.jpeg',
					'ctaText' => 'Play',
					'ctaLink' => 'https://ui.aceternity.com/templates',
					'content' => 'Metallica, an iconic American heavy metal band, is renowned for their powerful sound and intense performances that resonate deeply with their audience. Formed in Los Angeles, California, they have become a cultural icon in the heavy metal music industry.',
				],
			];

			$cards = !empty($cards) ? $cards : $default_cards;
			$id = 'expandable-card-' . uniqid();
			?>
			<div data-expandable-card-container="<?php echo esc_attr($id); ?>">
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
							class="p-4 flex flex-col md:flex-row justify-between items-center hover:bg-neutral-50 dark:hover:bg-neutral-800 rounded-xl cursor-pointer"
						>
							<div class="flex gap-4 flex-col md:flex-row">
								<div>
									<img
										width="100"
										height="100"
										src="<?php echo esc_url($card['src']); ?>"
										alt="<?php echo esc_attr($card['title']); ?>"
										class="h-40 w-40 md:h-14 md:w-14 rounded-lg object-cover object-top"
									/>
								</div>
								<div class="">
									<h3 class="font-medium text-neutral-800 dark:text-neutral-200 text-center md:text-left">
										<?php echo esc_html($card['title']); ?>
									</h3>
									<p class="text-neutral-600 dark:text-neutral-400 text-center md:text-left">
										<?php echo esc_html($card['description']); ?>
									</p>
								</div>
							</div>
							<button class="px-4 py-2 text-sm rounded-full font-bold bg-gray-100 hover:bg-green-500 hover:text-white text-black mt-4 md:mt-0">
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

