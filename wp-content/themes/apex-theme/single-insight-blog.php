<?php
/*
Template Name: Single Insight Blog Post
* Template for displaying single posts in the insights blog section.
* Allows customized layout for blog posts under /insights/blog/.
*/

if (!is_admin() && is_single() && get_post_type() == 'post') {
    $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (strpos($current_path, '/insights/blog/') !== 0) {
        $new_url = home_url('/insights/blog/' . get_post_field('post_name', get_the_ID()) . '/');
        wp_redirect($new_url, 301);
        exit;
    }
}

get_header(); ?>

<main class="flex-1">
	<!-- Single Insight Blog Post Content -->
	<section class="py-16 bg-slate-50">
		<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
			<div class="flex flex-col lg:flex-row gap-8">
				<!-- main-column -->
				<div class="main-column flex-1">
					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();

							if (get_post_format() == false) {
								get_template_part('content', 'single');
							} else {
								get_template_part('content', get_post_format());
							}

							// Comments
							if (comments_open() || get_comments_number() > 0) {
								comments_template();
							} elseif (comments_open()) {
								// Show styled placeholder when no comments but open
								echo '<section class="mt-12 pt-8 border-t border-slate-200">';
								echo '<div class="bg-slate-50 rounded-xl p-8 text-center">';
								echo '<div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">';
								echo '<svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
								echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>';
								echo '</svg>';
								echo '</div>';
								echo '<h3 class="text-xl font-semibold text-slate-900 mb-2">No Comments Yet</h3>';
								echo '<p class="text-slate-600 mb-6">Be the first to share your thoughts on this post. Your comment could start an interesting discussion!</p>';
								echo '<div class="inline-block">';
								comment_form(array(
									'title_reply' => 'Leave a Comment',
									'comment_notes_before' => '',
									'comment_notes_after' => '',
									'class_submit' => 'px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition-colors'
								));
								echo '</div>';
								echo '</div>';
								echo '</section>';
							}

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
