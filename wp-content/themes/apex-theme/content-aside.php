<article class="post post-aside bg-slate-50 rounded-2xl border-l-4 border-orange-500 overflow-hidden hover:bg-slate-100 transition-all duration-300">
	<div class="p-6">
		<!-- Aside Meta -->
		<p class="mini-meta text-xs text-slate-500 mb-3">
			<a href="<?php the_permalink(); ?>" class="inline-flex items-center hover:text-orange-500 transition-colors">
				<svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
				</svg>
				<?php the_author(); ?> @ <?php the_time('F j, Y'); ?>
			</a>
		</p>
		
		<!-- Aside Content -->
		<div class="prose prose-slate prose-sm max-w-none">
			<?php the_content(); ?>
		</div>
	</div>
</article>