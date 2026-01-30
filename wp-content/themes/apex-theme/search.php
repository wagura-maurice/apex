<?php
/**
 * Search Results Template
 * Displays search results with Apex theme styling
 */

get_header(); ?>

<main class="flex-1">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-16 overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\" fill=\"rgba(255,255,255,0.03)\"%3E%3C/path%3E%3C/svg%3E')] opacity-50"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                Search Results
            </h1>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-8">
                <?php if (have_posts()) : ?>
                    Results for: <span class="text-orange-400 font-semibold">"<?php the_search_query(); ?>"</span>
                <?php else : ?>
                    No results found for: <span class="text-orange-400 font-semibold">"<?php the_search_query(); ?>"</span>
                <?php endif; ?>
            </p>
            
            <!-- Search Form in Hero -->
            <div class="max-w-xl mx-auto">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2">
                    <input type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="Search again..." class="flex-1 rounded-xl border-0 px-5 py-4 text-slate-900 shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <button type="submit" class="rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 text-white font-semibold hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="py-16 bg-slate-50 px-4">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <?php if (have_posts()) : ?>
                <div class="mb-8">
                    <p class="text-slate-600">
                        Found <span class="font-semibold text-slate-900"><?php echo $wp_query->found_posts; ?></span> result<?php echo $wp_query->found_posts !== 1 ? 's' : ''; ?>
                    </p>
                </div>
                
                <div class="grid gap-6">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg hover:border-orange-200 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="flex-shrink-0">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-24 h-24 object-cover rounded-xl']); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                            <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                        </span>
                                        <span class="text-xs text-slate-400"><?php echo get_the_date(); ?></span>
                                    </div>
                                    
                                    <h2 class="text-xl font-bold text-slate-900 mb-2 hover:text-orange-600 transition-colors">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <p class="text-slate-600 text-sm line-clamp-2 mb-3">
                                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                    </p>
                                    
                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors">
                                        Read more
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <?php
                    the_posts_pagination([
                        'mid_size' => 2,
                        'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
                        'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                        'class' => 'apex-pagination',
                    ]);
                    ?>
                </div>
                
            <?php else : ?>
                <!-- No Results -->
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-4">No results found</h2>
                    <p class="text-slate-600 max-w-md mx-auto mb-8">
                        We couldn't find anything matching your search. Try different keywords or browse our solutions.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg">
                            Explore Solutions
                        </a>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center px-6 py-3 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition-all">
                            Back to Home
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>