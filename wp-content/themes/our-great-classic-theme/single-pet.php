<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-wide text-slate-500 mb-2"><?php echo esc_html__('Pet', 'our-wonderful-theme'); ?></p>
        <h1 class="text-3xl font-bold mb-4 text-slate-900"><?php the_title(); ?></h1>

        <?php if (has_post_thumbnail()) : ?>
            <div class="mb-6 overflow-hidden rounded-lg">
                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
            </div>
        <?php endif; ?>

        <div class="prose prose-slate max-w-none">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
