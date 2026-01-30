<?php
get_header(); ?>

<main class="flex-1">
	<!-- Archive Hero Section -->
	<section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-16 overflow-hidden">
		<div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\" fill=\"rgba(255,255,255,0.03)\"%3E%3C/path%3E%3C/svg%3E')] opacity-50"></div>
		<div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
			<h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
				<?php
				if ( is_category() ) {
					single_cat_title();
				} elseif ( is_tag() ) {
					single_tag_title();
				} elseif ( is_author() ) {
					the_post();
					echo 'Author Archives: ' . get_the_author();
					rewind_posts();
				} elseif ( is_day() ) {
					echo 'Daily Archives: ' . get_the_date();
				} elseif ( is_month() ) {
					echo 'Monthly Archives: ' . get_the_date('F Y');
				} elseif ( is_year() ) {
					echo 'Yearly Archives: ' . get_the_date('Y');
				} else {
					echo 'Archives';
				}
				?>
			</h1>
			<?php if (is_category() && category_description()) : ?>
				<p class="text-lg text-slate-300 max-w-2xl mx-auto"><?php echo category_description(); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Archive Content -->
	<section class="py-16 bg-slate-50">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="flex flex-col lg:flex-row gap-12">
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
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
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