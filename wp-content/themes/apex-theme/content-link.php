<article class="post post-link bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300">
	<a href="<?php echo get_the_content(); ?>" class="block p-6 text-white" target="_blank" rel="noopener">
		<span class="mini-meta block text-sm text-orange-100 mb-2">
			<span class="inline-flex items-center">
				<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
				</svg>
				<?php the_author(); ?> @ <?php the_time('F j, Y'); ?>
			</span>
		</span>
		<span class="post-link-text block text-xl font-bold flex items-center gap-2">
			<?php the_title(); ?>
			<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
			</svg>
		</span>
	</a>
</article>