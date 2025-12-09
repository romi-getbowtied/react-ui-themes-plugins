<?php
/**
 * Bento Grid Enhanced Component
 * 
 * @package Tailwind_Scoped_Theme
 */

if (!defined('ABSPATH')) exit;


/**
 * Get bento grid items data
 * Can be filtered using 'tw_bento_grid_items' filter
 * 
 * @return array Items array with title, description, header (image URL), icon (class name), and className
 */
function tw_get_bento_grid_items() {
	$default_items = [
		[
			'title' => 'The Dawn of Innovation',
			'description' => 'Explore the birth of groundbreaking ideas and inventions.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'clipboard-copy',
			'className' => '',
		],
		[
			'title' => 'The Digital Revolution',
			'description' => 'Dive into the transformative power of technology.',
			'header' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop',
			'icon' => 'file-broken',
			'className' => '',
		],
		[
			'title' => 'The Art of Design',
			'description' => 'Discover the beauty of thoughtful and functional design.',
			'header' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
			'icon' => 'signature',
			'className' => '',
		],
		[
			'title' => 'The Power of Communication',
			'description' => 'Understand the impact of effective communication in our lives.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'table-column',
			'className' => 'md:col-span-2',
		],
		[
			'title' => 'The Pursuit of Knowledge',
			'description' => 'Join the quest for understanding and enlightenment.',
			'header' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop',
			'icon' => 'arrow-wave-right-up',
			'className' => '',
		],
		[
			'title' => 'The Joy of Creation',
			'description' => 'Experience the thrill of bringing ideas to life.',
			'header' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
			'icon' => 'box-align-top-left',
			'className' => '',
		],
		[
			'title' => 'The Spirit of Adventure',
			'description' => 'Embark on exciting journeys and thrilling discoveries.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'box-align-right-filled',
			'className' => 'md:col-span-2',
		],
        [
			'title' => 'The Dawn of Innovation',
			'description' => 'Explore the birth of groundbreaking ideas and inventions.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'clipboard-copy',
			'className' => '',
		],
		[
			'title' => 'The Digital Revolution',
			'description' => 'Dive into the transformative power of technology.',
			'header' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop',
			'icon' => 'file-broken',
			'className' => '',
		],
		[
			'title' => 'The Art of Design',
			'description' => 'Discover the beauty of thoughtful and functional design.',
			'header' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
			'icon' => 'signature',
			'className' => '',
		],
		[
			'title' => 'The Power of Communication',
			'description' => 'Understand the impact of effective communication in our lives.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'table-column',
			'className' => 'md:col-span-2',
		],
		[
			'title' => 'The Pursuit of Knowledge',
			'description' => 'Join the quest for understanding and enlightenment.',
			'header' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop',
			'icon' => 'arrow-wave-right-up',
			'className' => '',
		],
		[
			'title' => 'The Joy of Creation',
			'description' => 'Experience the thrill of bringing ideas to life.',
			'header' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
			'icon' => 'box-align-top-left',
			'className' => '',
		],
		[
			'title' => 'The Spirit of Adventure',
			'description' => 'Embark on exciting journeys and thrilling discoveries.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'box-align-right-filled',
			'className' => 'md:col-span-2',
		],
        [
			'title' => 'The Dawn of Innovation',
			'description' => 'Explore the birth of groundbreaking ideas and inventions.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'clipboard-copy',
			'className' => '',
		],
		[
			'title' => 'The Digital Revolution',
			'description' => 'Dive into the transformative power of technology.',
			'header' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop',
			'icon' => 'file-broken',
			'className' => '',
		],
		[
			'title' => 'The Art of Design',
			'description' => 'Discover the beauty of thoughtful and functional design.',
			'header' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
			'icon' => 'signature',
			'className' => '',
		],
		[
			'title' => 'The Power of Communication',
			'description' => 'Understand the impact of effective communication in our lives.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'table-column',
			'className' => 'md:col-span-2',
		],
		[
			'title' => 'The Pursuit of Knowledge',
			'description' => 'Join the quest for understanding and enlightenment.',
			'header' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop',
			'icon' => 'arrow-wave-right-up',
			'className' => '',
		],
		[
			'title' => 'The Joy of Creation',
			'description' => 'Experience the thrill of bringing ideas to life.',
			'header' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
			'icon' => 'box-align-top-left',
			'className' => '',
		],
		[
			'title' => 'The Spirit of Adventure',
			'description' => 'Embark on exciting journeys and thrilling discoveries.',
			'header' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
			'icon' => 'box-align-right-filled',
			'className' => 'md:col-span-2',
		],
	];
	
	// Allow filtering of items
	return apply_filters('tw_bento_grid_items', $default_items);
}

/**
 * Get icon SVG based on icon name
 * 
 * @param string $icon_name Icon identifier
 * @return string SVG markup
 */
function tw_get_bento_icon($icon_name) {
	$icons = [
		'clipboard-copy' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/><path d="M16 4h2a2 2 0 0 1 2 2v4"/><path d="M21 14v1a2 2 0 0 1-2 2h-1"/></svg>',
		'file-broken' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>',
		'signature' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 24v-4H4a2 2 0 0 1 0-4h2"/><path d="M4 20h16"/><path d="M6 12V8"/><path d="M18 8v4"/><path d="M8 8h8"/></svg>',
		'table-column' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="M9 9h12"/><path d="M9 15h12"/></svg>',
		'arrow-wave-right-up' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 16h4"/><path d="M3 12c0-1 1-2 2-2h4c1 0 2 1 2 2s-1 2-2 2H5c-1 0-2 1-2 2s1 2 2 2h4c1 0 2 1 2 2s-1 2-2 2H5c-1 0-2 1-2 2s1 2 2 2h4c1 0 2 1 2 2"/><path d="M21 6l-5-5"/><path d="M21 6l-5 5"/><path d="M21 6h-5"/><path d="M21 6v5"/></svg>',
		'box-align-top-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3v18"/><path d="M3 9h18"/><rect width="18" height="18" x="3" y="3" rx="2"/></svg>',
		'box-align-right-filled' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 21H3v-6h12v6z"/><path d="M21 3H9v6h12V3z"/><path d="M21 15H9v6h12v-6z"/><path d="M15 3H3v6h12V3z"/></svg>',
	];
	
	return isset($icons[$icon_name]) ? $icons[$icon_name] : '';
}

/**
 * Render SEO-friendly bento grid section
 * 
 * @param array|null $items Optional array of items. If null, uses filtered default items.
 * @param string $className Optional additional classes for the grid container
 * @return void
 */
function tw_render_bento_grid($items = null, $className = '') {
	if ($items === null) {
		$items = tw_get_bento_grid_items();
	}
	
	$grid_classes = 'mx-auto grid max-w-7xl grid-cols-1 gap-4 md:auto-rows-[18rem] md:grid-cols-3';
	if (!empty($className)) {
		$grid_classes .= ' ' . esc_attr($className);
	}
	?>
	<section 
		class="bento-grid-section py-12"
		itemscope 
		itemtype="https://schema.org/ItemList"
		aria-label="<?php esc_attr_e('Featured Content Grid', 'tailwind-scoped-theme'); ?>"
	>
		<?php if (!empty($items)) : ?>
			<meta itemprop="numberOfItems" content="<?php echo esc_attr(count($items)); ?>">
		<?php endif; ?>
		
		<div class="<?php echo esc_attr($grid_classes); ?>">
			<?php foreach ($items as $index => $item) : 
				$item_classes = 'group/bento shadow-input row-span-1 flex flex-col justify-between space-y-4 rounded-xl border border-neutral-200 bg-white p-4 transition duration-200 hover:shadow-xl dark:border-white/[0.2] dark:bg-black dark:shadow-none';
				if (!empty($item['className'])) {
					$item_classes .= ' ' . esc_attr($item['className']);
				}
				
				// Eager load first 2 images, lazy load the rest
				$loading = ($index < 2) ? 'eager' : 'lazy';
				$position = $index + 1;
			?>
				<article 
					class="<?php echo esc_attr($item_classes); ?>"
					itemscope 
					itemtype="https://schema.org/CreativeWork"
					itemprop="itemListElement"
					itemid="#bento-item-<?php echo esc_attr($position); ?>"
				>
					<meta itemprop="position" content="<?php echo esc_attr($position); ?>">
					
					<?php if (!empty($item['header'])) : ?>
						<div class="flex h-full min-h-[6rem] w-full flex-col overflow-hidden rounded-xl bg-gradient-to-br from-neutral-200 dark:from-neutral-900 dark:to-neutral-800 to-neutral-100">
							<img
								src="<?php echo esc_url($item['header']); ?>"
								alt="<?php echo esc_attr($item['title']); ?>"
								class="h-full w-full object-cover"
								loading="<?php echo esc_attr($loading); ?>"
								itemprop="image"
								width="800"
								height="600"
								decoding="async"
							/>
						</div>
					<?php endif; ?>
					
					<div class="transition duration-200 group-hover/bento:translate-x-2">
						<?php if (!empty($item['icon'])) : ?>
							<div class="h-4 w-4 text-neutral-500 dark:text-neutral-400" aria-hidden="true">
								<?php echo tw_get_bento_icon($item['icon']); ?>
							</div>
						<?php endif; ?>
						
						<h3 class="mt-2 mb-2 font-sans font-bold text-neutral-600 dark:text-neutral-200" itemprop="name">
							<?php echo esc_html($item['title']); ?>
						</h3>
						
						<div class="font-sans text-xs font-normal text-neutral-600 dark:text-neutral-300" itemprop="description">
							<?php echo esc_html($item['description']); ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

