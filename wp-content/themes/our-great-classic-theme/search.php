<?php get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">Search Results</li>
        </ol>
    </div>
</nav>

<!-- Search Results Content -->
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-apex-dark mb-2">Search Results</h1>
        <p class="text-apex-gray-600">
            <?php if (have_posts()) : ?>
                <?php printf(__('Results for "%s"', 'our-wonderful-theme'), get_search_query()); ?>
            <?php else : ?>
                <?php printf(__('No results for "%s"', 'our-wonderful-theme'), get_search_query()); ?>
            <?php endif; ?>
        </p>
    </div>

    <?php if (have_posts()) : ?>
        <div class="space-y-8">
            <?php while (have_posts()) : the_post(); ?>
                <article class="border-b border-apex-gray-200 pb-8 last:border-0">
                    <h2 class="text-xl font-bold text-apex-dark mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-apex-orange transition-colors"><?php the_title(); ?></a>
                    </h2>
                    <p class="text-sm text-apex-gray-500 mb-3">
                        <?php echo esc_html(get_the_date()); ?> • 
                        <?php if (get_post_type() === 'page') : ?>
                            Page
                        <?php elseif (get_post_type() === 'post') : ?>
                            Article
                        <?php else : ?>
                            <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?>
                        <?php endif; ?>
                    </p>
                    <div class="text-apex-gray-600">
                        <?php if (has_excerpt()) : ?>
                            <?php echo wp_kses_post(get_the_excerpt()); ?>
                        <?php else : ?>
                            <?php echo wp_kses_post(wp_trim_words(get_the_content(), 30)); ?>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="mt-10">
            <?php the_posts_pagination([
                'mid_size' => 2,
                'prev_text' => __('« Previous', 'our-wonderful-theme'),
                'next_text' => __('Next »', 'our-wonderful-theme'),
            ]); ?>
        </div>
    <?php else : ?>
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-apex-orange/10 mb-6">
                <svg class="w-8 h-8 text-apex-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-apex-dark mb-2">No Results Found</h2>
            <p class="text-apex-gray-600 mb-6">
                Sorry, we couldn't find any content matching your search term.
            </p>
            <div class="max-w-md mx-auto">
                <form role="search" method="get" class="relative" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" 
                           name="s" 
                           value="<?php echo get_search_query(); ?>" 
                           placeholder="Try searching again..." 
                           class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 pl-12 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-apex-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Related Content Section -->
<?php if (!have_posts()) : ?>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold text-center text-apex-dark mb-8">Popular Pages</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="<?php echo esc_url(home_url('/platform/apexcore')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">ApexCore Platform</h3>
            <p class="text-apex-gray-600 text-sm">Web-based core banking solution</p>
        </a>
        <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">Solutions</h3>
            <p class="text-apex-gray-600 text-sm">Comprehensive financial solutions</p>
        </a>
        <a href="<?php echo esc_url(home_url('/industry/overview')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">Industries</h3>
            <p class="text-apex-gray-600 text-sm">Solutions by industry</p>
        </a>
        <a href="<?php echo esc_url(home_url('/insights/blog')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">Insights</h3>
            <p class="text-apex-gray-600 text-sm">Industry news and updates</p>
        </a>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>