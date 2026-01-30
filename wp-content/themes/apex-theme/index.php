<?php
get_header(); ?>

<main class="flex-1">
	<!-- Blog/Index Content -->
	<section class="py-16 bg-slate-50 px-4">
		<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
			<div class="flex flex-col lg:flex-row gap-8">
				<!-- main-column -->
				<div class="main-column flex-1">
					<?php if (have_posts()) : ?>
						<div class="grid gap-6">
							<?php
							while (have_posts()) : the_post();
								get_template_part('content', get_post_format());
							endwhile;
							?>
						</div>
						
						<!-- Pagination -->
						<div class="mt-12 flex justify-center">
							<?php
							the_posts_pagination([
								'mid_size' => 2,
								'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
								'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
							]);
							?>
						</div>
					<?php else : ?>
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