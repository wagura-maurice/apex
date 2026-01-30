<!-- side-column -->
<aside class="side-column w-full lg:w-80 flex-shrink-0">
	<?php if (is_active_sidebar('sidebar1')) : ?>
		<div class="sticky top-28 space-y-6">
			<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 [&_.widget]:mb-6 [&_.widget:last-child]:mb-0 [&_.widget-title]:text-lg [&_.widget-title]:font-bold [&_.widget-title]:text-slate-900 [&_.widget-title]:mb-4 [&_.widget-title]:pb-2 [&_.widget-title]:border-b [&_.widget-title]:border-slate-100 [&_ul]:space-y-2 [&_ul_li]:text-sm [&_ul_li]:text-slate-600 [&_ul_li_a]:hover:text-orange-500 [&_ul_li_a]:transition-colors">
				<?php dynamic_sidebar('sidebar1'); ?>
			</div>
		</div>
	<?php else : ?>
		<!-- Default sidebar content when no widgets -->
		<div class="sticky top-28 space-y-6">
			<!-- Search Widget -->
			<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
				<h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Search</h3>
				<?php get_search_form(); ?>
			</div>
			
			<!-- Categories Widget -->
			<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
				<h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Categories</h3>
				<ul class="space-y-2">
					<?php
					$categories = get_categories(['orderby' => 'count', 'order' => 'DESC', 'number' => 10]);
					foreach ($categories as $cat) :
					?>
						<li class="flex items-center justify-between text-sm">
							<a href="<?php echo get_category_link($cat->term_id); ?>" class="text-slate-600 hover:text-orange-500 transition-colors"><?php echo $cat->name; ?></a>
							<span class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full"><?php echo $cat->count; ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			
			<!-- Recent Posts Widget -->
			<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
				<h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Recent Posts</h3>
				<ul class="space-y-4">
					<?php
					$recent_posts = wp_get_recent_posts(['numberposts' => 5, 'post_status' => 'publish']);
					foreach ($recent_posts as $post) :
					?>
						<li>
							<a href="<?php echo get_permalink($post['ID']); ?>" class="block group">
								<span class="text-sm font-medium text-slate-700 group-hover:text-orange-500 transition-colors line-clamp-2"><?php echo $post['post_title']; ?></span>
								<span class="text-xs text-slate-400 mt-1 block"><?php echo get_the_date('M j, Y', $post['ID']); ?></span>
							</a>
						</li>
					<?php endforeach; wp_reset_query(); ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>
</aside><!-- /side-column -->