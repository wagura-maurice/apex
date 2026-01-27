<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <div class="grid gap-6">
        <?php while (have_posts()) : the_post(); ?>
            <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs uppercase tracking-wide text-slate-500 mb-2"><?php echo esc_html(get_the_date()); ?></p>
                <h2 class="text-xl font-semibold mb-2">
                    <a href="<?php the_permalink(); ?>" class="text-slate-900 hover:text-blue-600"><?php the_title(); ?></a>
                </h2>
                <div class="prose prose-slate max-w-none text-sm mb-4">
                    <?php the_excerpt(); ?>
                </div>
                <a class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700" href="<?php the_permalink(); ?>">
                    Read more
                    <span aria-hidden="true">→</span>
                </a>
            </article>
        <?php endwhile; ?>
    </div>
    <div class="mt-8">
        <?php the_posts_pagination([
            'mid_size' => 2,
            'prev_text' => __('« Previous', 'our-wonderful-theme'),
            'next_text' => __('Next »', 'our-wonderful-theme'),
        ]); ?>
    </div>
<?php else : ?>
    <p class="text-slate-600">No posts found.</p>
<?php endif; ?>

<?php get_footer(); ?>
