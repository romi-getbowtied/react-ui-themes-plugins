<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('TW_Apple_Cards_Carousel')) {
	class TW_Apple_Cards_Carousel {
		public static function get_items($items = null) {
			if ($items !== null) return $items;
			$filtered = apply_filters('tw_apple_cards_carousel_items', null);
			if ($filtered !== null) return $filtered;
			
			return [
				['category' => 'Artificial Intelligence', 'title' => 'You can do more with AI.', 'src' => 'https://images.unsplash.com/photo-1593508512255-86ab42a8e620?q=80&w=3556&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'url' => '#'],
				['category' => 'Productivity', 'title' => 'Enhance your productivity.', 'src' => 'https://images.unsplash.com/photo-1531554694128-c4c6665f59c2?q=80&w=3387&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'url' => '#'],
				['category' => 'Product', 'title' => 'Launching the new Apple Vision Pro.', 'src' => 'https://images.unsplash.com/photo-1713869791518-a770879e60dc?q=80&w=2333&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'url' => '#'],
				['category' => 'Product', 'title' => 'Maps for your iPhone 15 Pro Max.', 'src' => 'https://images.unsplash.com/photo-1599202860130-f600f4948364?q=80&w=2515&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'url' => '#'],
				['category' => 'iOS', 'title' => 'Photography just got better.', 'src' => 'https://images.unsplash.com/photo-1602081957921-9137a5d6eaee?q=80&w=2793&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'url' => '#'],
				['category' => 'Hiring', 'title' => 'Hiring for a Staff Software Engineer', 'src' => 'https://images.unsplash.com/photo-1511984804822-e16ba72f5848?q=80&w=2048&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'url' => '#'],
			];
		}

		public static function render($items = null, $heading = 'Get to know your iSad.', $className = '') {
			$items = self::get_items($items);
			if (empty($items)) return;
			?>
			<section class="apple-cards-carousel-section w-full h-full py-20 <?php echo esc_attr($className); ?>">
				<?php if ($heading) : ?>
					<h2 class="max-w-7xl pl-4 mx-auto text-xl md:text-5xl font-bold text-neutral-800 dark:text-neutral-200 font-sans"><?php echo esc_html($heading); ?></h2>
				<?php endif; ?>
				
				<div class="apple-cards-carousel relative w-full">
					<div class="flex w-full overflow-x-scroll overscroll-x-auto scroll-smooth py-10 [scrollbar-width:none] [overscroll-behavior-x:contain] md:py-20">
						<div class="absolute right-0 z-[1000] h-auto w-[5%] overflow-hidden bg-gradient-to-l"></div>
						<div class="flex flex-row justify-start gap-4 pl-4 mx-auto max-w-7xl">
							<?php foreach ($items as $index => $item) : ?>
								<article class="rounded-3xl last:pr-[5%] md:last:pr-[33%] will-change-transform [contain:layout_style_paint] [backface-visibility:hidden] [transform:translateZ(0)]">
									<a href="<?php echo esc_url($item['url'] ?? '#'); ?>" class="group relative z-10 flex h-80 w-56 flex-col items-start justify-start overflow-hidden rounded-3xl bg-gray-100 md:h-[40rem] md:w-96 dark:bg-neutral-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary will-change-transform [backface-visibility:hidden] [transform:translateZ(0)] transition-all duration-300 ease-out hover:scale-[1.02] hover:shadow-xl">
										<div class="pointer-events-none absolute inset-x-0 top-0 z-30 h-full bg-gradient-to-b from-black/50 via-transparent to-transparent transition-opacity duration-300 ease-out group-hover:opacity-75"></div>
										<div class="relative z-40 p-8 transition-transform duration-300 ease-out group-hover:-translate-y-0.5">
											<p class="text-left font-sans text-sm font-medium text-white md:text-base"><?php echo esc_html($item['category']); ?></p>
											<h3 class="mt-2 max-w-xs text-left font-sans text-xl font-semibold [text-wrap:balance] text-white md:text-3xl"><?php echo esc_html($item['title']); ?></h3>
										</div>
										<img src="<?php echo esc_url($item['src']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="absolute inset-0 z-10 h-full w-full object-cover will-change-transform [backface-visibility:hidden] [transform:translateZ(0)] transition-transform duration-500 ease-out group-hover:scale-105" loading="<?php echo $index < 2 ? 'eager' : 'lazy'; ?>" />
									</a>
								</article>
							<?php endforeach; ?>
						</div>
					</div>
					
					<div class="mr-10 flex justify-end gap-2">
						<button type="button" class="carousel-prev relative z-40 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 disabled:opacity-50 hover:bg-gray-200 will-change-transform [backface-visibility:hidden] [transform:translateZ(0)] transition-all duration-200 ease-out hover:scale-110 active:scale-95" aria-label="<?php esc_attr_e('Previous', 'tailwind-scoped-theme'); ?>" disabled>
							<svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
						</button>
						<button type="button" class="carousel-next relative z-40 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 disabled:opacity-50 hover:bg-gray-200 will-change-transform [backface-visibility:hidden] [transform:translateZ(0)] transition-all duration-200 ease-out hover:scale-110 active:scale-95" aria-label="<?php esc_attr_e('Next', 'tailwind-scoped-theme'); ?>">
							<svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
						</button>
					</div>
				</div>
			</section>
			<?php
		}
	}
}
