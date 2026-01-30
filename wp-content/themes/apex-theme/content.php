<article class="post bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg hover:border-orange-200 transition-all duration-300 <?php if ( has_post_thumbnail() ) { ?>has-thumbnail <?php } ?>">
	<div class="flex flex-col sm:flex-row">
		<?php if ( has_post_thumbnail() ) : ?>
			<!-- post-thumbnail -->
			<div class="post-thumbnail flex-shrink-0 sm:w-48 md:w-56">
				<a href="<?php the_permalink(); ?>" class="block aspect-video sm:aspect-square overflow-hidden">
					<?php the_post_thumbnail('small-thumbnail', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
				</a>
			</div><!-- /post-thumbnail -->
		<?php endif; ?>

		<div class="flex-1 p-5 sm:p-6">
			<!-- Post Meta -->
			<div class="post-info flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-3">
				<span class="inline-flex items-center">
					<svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
					</svg>
					<?php the_time('F j, Y'); ?>
				</span>
				<span class="text-slate-300">•</span>
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="hover:text-orange-500 transition-colors"><?php the_author(); ?></a>
				<?php
				$categories = get_the_category();
				$separator = ", ";
				$output = '';

				if ($categories) {
					echo '<span class="text-slate-300">•</span>';
					foreach ($categories as $category) {
						$output .= '<a href="' . get_category_link($category->term_id) . '" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700 hover:bg-orange-200 transition-colors">' . $category->cat_name . '</a>' . $separator;
					}
					echo trim($output, $separator);
				}
				?>
			</div>

			<!-- Title -->
			<h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-3 line-clamp-2">
				<a href="<?php the_permalink(); ?>" class="hover:text-orange-600 transition-colors"><?php the_title(); ?></a>
			</h2>

			<!-- Content/Excerpt -->
			<?php if ( is_search() OR is_archive() ) { ?>
				<p class="text-slate-600 text-sm line-clamp-3 mb-4">
					<?php echo get_the_excerpt(); ?>
				</p>
				<a href="<?php the_permalink(); ?>" class="inline-flex items-center text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors">
					Read more
					<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
					</svg>
				</a>
			<?php } else {
				if ($post->post_excerpt) { ?>
					<p class="text-slate-600 text-sm line-clamp-3 mb-4">
						<?php echo get_the_excerpt(); ?>
					</p>
					<a href="<?php the_permalink(); ?>" class="inline-flex items-center text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors">
						Read more
						<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
						</svg>
					</a>
				<?php } else { ?>
					<div class="prose prose-slate prose-sm max-w-none">
						<?php the_content(); ?>
					</div>
				<?php }
			} ?>
		</div>
	</div>
</article>