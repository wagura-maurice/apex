<article class="post post-gallery bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg hover:border-orange-200 transition-all duration-300">
	<div class="p-6">
		<!-- Gallery Header -->
		<div class="flex items-center gap-2 mb-3">
			<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
				<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
				</svg>
				Gallery
			</span>
		</div>
		
		<!-- Title -->
		<h2 class="text-xl font-bold text-slate-900 mb-4">
			<a href="<?php the_permalink(); ?>" class="hover:text-orange-600 transition-colors"><?php the_title(); ?></a>
		</h2>
		
		<!-- Gallery Content -->
		<div class="prose prose-slate max-w-none [&_.gallery]:grid [&_.gallery]:gap-2 [&_.gallery]:grid-cols-2 [&_.gallery]:sm:grid-cols-3 [&_.gallery_img]:rounded-lg [&_.gallery_img]:shadow-sm">
			<?php the_content(); ?>
		</div>
	</div>
</article>