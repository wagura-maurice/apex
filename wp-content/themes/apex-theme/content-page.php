<article class="page bg-white">
	<!-- Page Header -->
	<header class="mb-8">
		<h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900"><?php the_title(); ?></h1>
	</header>

	<!-- Page Content -->
	<div class="prose prose-lg prose-slate max-w-none prose-headings:text-slate-900 prose-a:text-orange-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl">
		<?php the_content(); ?>
	</div>
</article>