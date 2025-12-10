<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GBT_Component_Hero_Parallax')) {
	class GBT_Component_Hero_Parallax {
		public static function get_products() {
	$default_products = [
		[
			'title' => 'Moonbeam',
			'link' => 'https://gomoonbeam.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/moonbeam.png',
		],
		[
			'title' => 'Cursor',
			'link' => 'https://cursor.so',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/cursor.png',
		],
		[
			'title' => 'Rogue',
			'link' => 'https://userogue.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/rogue.png',
		],
		[
			'title' => 'Editorially',
			'link' => 'https://editorially.org',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/editorially.png',
		],
		[
			'title' => 'Editrix AI',
			'link' => 'https://editrix.ai',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/editrix.png',
		],
		[
			'title' => 'Pixel Perfect',
			'link' => 'https://app.pixelperfect.quest',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/pixelperfect.png',
		],
		[
			'title' => 'Algochurn',
			'link' => 'https://algochurn.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/algochurn.png',
		],
		[
			'title' => 'Aceternity UI',
			'link' => 'https://ui.aceternity.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/aceternityui.png',
		],
		[
			'title' => 'Tailwind Master Kit',
			'link' => 'https://tailwindmasterkit.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/tailwindmasterkit.png',
		],
		[
			'title' => 'SmartBridge',
			'link' => 'https://smartbridgetech.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/smartbridge.png',
		],
		[
			'title' => 'Renderwork Studio',
			'link' => 'https://renderwork.studio',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/renderwork.png',
		],
		[
			'title' => 'Creme Digital',
			'link' => 'https://cremedigital.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/cremedigital.png',
		],
		[
			'title' => 'Golden Bells Academy',
			'link' => 'https://goldenbellsacademy.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/goldenbellsacademy.png',
		],
		[
			'title' => 'Invoker Labs',
			'link' => 'https://invoker.lol',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/invoker.png',
		],
		[
			'title' => 'E Free Invoice',
			'link' => 'https://efreeinvoice.com',
			'thumbnail' => 'https://aceternity.com/images/products/thumbnails/new/efreeinvoice.png',
		],
	];
	
	return apply_filters('gbt_hero_products', $default_products);
}

		public static function render($items_per_row = null) {
			$items_per_row = $items_per_row ?? apply_filters('gbt_hero_items_per_row', 5);
			$products = self::get_products();
	$rows = [];
			for ($i = 0; $i < count($products); $i += $items_per_row) {
		$rows[] = array_slice($products, $i, $items_per_row);
	}
			$section_height = max(300, count($rows) * 100);
	?>
	<section 
		class="hero-parallax-section py-40 overflow-hidden antialiased relative flex flex-col self-auto" 
		style="height: <?php echo esc_attr($section_height); ?>vh;"
		itemscope 
		itemtype="https://schema.org/ItemList"
		aria-label="<?php esc_attr_e('Featured Products', 'tailwind-scoped-theme'); ?>"
		data-total-rows="<?php echo esc_attr(count($rows)); ?>"
	>
		<header class="max-w-7xl relative mx-auto py-20 md:py-40 px-4 w-full left-0 top-0">
			<h1 class="text-2xl md:text-7xl font-bold text-foreground">
				<?php esc_html_e('The Ultimate', 'tailwind-scoped-theme'); ?> <br />
				<?php esc_html_e('development studio', 'tailwind-scoped-theme'); ?>
			</h1>
			<p class="max-w-2xl text-base md:text-xl mt-8 text-muted-foreground">
				<?php esc_html_e('We build beautiful products with the latest technologies and frameworks. We are a team of passionate developers and designers that love to build amazing products.', 'tailwind-scoped-theme'); ?>
			</p>
		</header>
		
		<div class="hero-parallax-container">
			<?php foreach ($rows as $row_index => $row_products) : 
				$row_number = $row_index + 1;
				$is_reverse = ($row_number % 2 === 1);
				$row_class = $is_reverse ? 'flex flex-row-reverse space-x-reverse space-x-20' : 'flex flex-row space-x-20';
			?>
				<div class="<?php echo esc_attr($row_class); ?> mb-20 hero-parallax-row" data-row="<?php echo esc_attr($row_number); ?>" data-direction="<?php echo $is_reverse ? 'reverse' : 'normal'; ?>">
					<?php foreach ($row_products as $product_index => $product) : 
						$loading = ($row_index === 0 && $product_index < 2) ? 'eager' : 'lazy';
					?>
						<article 
							class="group/product h-96 w-[30rem] relative shrink-0" 
							itemscope 
							itemtype="https://schema.org/Product"
							itemprop="itemListElement"
						>
							<a 
								href="<?php echo esc_url($product['link']); ?>" 
								class="block group-hover/product:shadow-2xl"
								itemprop="url"
								target="_blank"
								rel="noopener noreferrer"
							>
								<img
									src="<?php echo esc_url($product['thumbnail']); ?>"
									alt="<?php echo esc_attr($product['title']); ?>"
									height="600"
									width="600"
									class="object-cover object-top-left absolute h-full w-full inset-0"
									itemprop="image"
									loading="<?php echo esc_attr($loading); ?>"
								/>
							</a>
							<div class="absolute inset-0 h-full w-full opacity-0 group-hover/product:opacity-80 bg-black pointer-events-none transition-opacity"></div>
							<h2 
								class="absolute bottom-4 left-4 opacity-0 group-hover/product:opacity-100 text-white transition-opacity"
								itemprop="name"
							>
								<?php echo esc_html($product['title']); ?>
							</h2>
							<meta itemprop="description" content="<?php echo esc_attr($product['title']); ?>">
						</article>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
		}
}
}
