<?php
get_header(); ?>

<main class="flex-1">
	<!-- Single Post Content -->
	<section class="py-16 bg-slate-50">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="flex flex-col lg:flex-row gap-12">
				<!-- main-column -->
				<div class="main-column flex-1 max-w-3xl">
					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();

							if (get_post_format() == false) {
								get_template_part('content', 'single');
							} else {
								get_template_part('content', get_post_format());
							}

							// Comments
							if (comments_open() || get_comments_number()) :
								comments_template();
							endif;

						endwhile;
						
						// Post Navigation
						?>
						<nav class="mt-12 pt-8 border-t border-slate-200">
							<div class="flex flex-col sm:flex-row justify-between gap-4">
								<?php
								$prev_post = get_previous_post();
								$next_post = get_next_post();
								
								if ($prev_post) : ?>
									<a href="<?php echo get_permalink($prev_post); ?>" class="group flex items-center gap-3 p-4 rounded-xl bg-white border border-slate-200 hover:border-orange-300 hover:shadow-md transition-all flex-1">
										<svg class="w-5 h-5 text-slate-400 group-hover:text-orange-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
										</svg>
										<div class="min-w-0">
											<span class="text-xs text-slate-500 block">Previous</span>
											<span class="text-sm font-medium text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-1"><?php echo get_the_title($prev_post); ?></span>
										</div>
									</a>
								<?php endif;
								
								if ($next_post) : ?>
									<a href="<?php echo get_permalink($next_post); ?>" class="group flex items-center justify-end gap-3 p-4 rounded-xl bg-white border border-slate-200 hover:border-orange-300 hover:shadow-md transition-all flex-1 text-right">
										<div class="min-w-0">
											<span class="text-xs text-slate-500 block">Next</span>
											<span class="text-sm font-medium text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-1"><?php echo get_the_title($next_post); ?></span>
										</div>
										<svg class="w-5 h-5 text-slate-400 group-hover:text-orange-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
										</svg>
									</a>
								<?php endif; ?>
							</div>
						</nav>
						<?php
					else : ?>
						<div class="text-center py-16">
							<div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-6">
								<svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
								</svg>
							</div>
							<p class="text-slate-600">No content found</p>
						</div>
					<?php endif; ?>
				</div><!-- /main-column -->
				
				<?php get_sidebar(); ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>