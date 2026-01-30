<?php
/*
Template Name: Special Layout
*/

get_header();
?>

<main class="flex-1">
	<!-- Special Template Content -->
	<section class="py-16 bg-slate-50">
		<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
			<?php
			if (have_posts()) :
				while (have_posts()) : the_post(); ?>
				
				<article class="post page bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
					<!-- Page Header -->
					<header class="p-8 pb-0">
						<h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900"><?php the_title(); ?></h1>
					</header>
					
					<!-- info-box -->
					<div class="info-box mx-8 mt-8 p-6 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border border-orange-200">
						<div class="flex items-start gap-4">
							<div class="flex-shrink-0">
								<div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
									<svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
									</svg>
								</div>
							</div>
							<div>
								<h4 class="text-lg font-bold text-slate-900 mb-2">Disclaimer Title</h4>
								<p class="text-sm text-slate-600 leading-relaxed">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim venia.</p>
							</div>
						</div>
					</div><!-- /info-box -->
					
					<!-- Page Content -->
					<div class="p-8">
						<div class="prose prose-lg prose-slate max-w-none prose-headings:text-slate-900 prose-a:text-orange-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl">
							<?php the_content(); ?>
						</div>
					</div>
				</article>
				
				<?php endwhile;
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
		</div>
	</section>
</main>

<?php get_footer(); ?>