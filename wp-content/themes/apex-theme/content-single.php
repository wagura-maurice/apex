<article class="post bg-white rounded-2xl shadow-md p-6 sm:p-10 lg:p-12 border border-slate-200">
	<!-- Post Header -->
	<header class="mb-8">
		<h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-4"><?php the_title(); ?></h1>

		<div class="post-info flex flex-wrap items-center gap-3 text-sm text-slate-500">
			<span class="inline-flex items-center">
				<svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
				</svg>
				<?php the_time('F j, Y g:i a'); ?>
			</span>
			<span class="text-slate-300">•</span>
			<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="inline-flex items-center hover:text-orange-500 transition-colors">
				<svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
				</svg>
				<?php the_author(); ?>
			</a>
			<?php
			$categories = get_the_category();
			$separator = " ";
			$output = '';

			if ($categories) {
				echo '<span class="text-slate-300">•</span>';
				echo '<span class="inline-flex items-center gap-2">';
				foreach ($categories as $category) {
					$output .= '<a href="' . get_category_link($category->term_id) . '" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700 hover:bg-orange-200 transition-colors">' . $category->cat_name . '</a>' . $separator;
				}
				echo trim($output, $separator);
				echo '</span>';
			}
			?>
		</div>
	</header>

	<!-- Featured Image -->
	<?php if (has_post_thumbnail()) : 
		$content = get_post_field('post_content', get_the_ID());
		$featured_image_id = get_post_thumbnail_id();
		if (strpos($content, 'wp-image-' . $featured_image_id) === false) : ?>
			<div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
				<?php the_post_thumbnail('banner-image', ['class' => 'w-full h-auto']); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<!-- Post Content -->
	<div class="prose prose-lg prose-slate max-w-none prose-headings:text-slate-900 prose-a:text-orange-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl prose-blockquote:border-orange-500">
		<?php the_content(); ?>
	</div>
</article>