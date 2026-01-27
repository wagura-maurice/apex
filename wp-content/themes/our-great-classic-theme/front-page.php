<?php get_header(); ?>

<section class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
    <h1 class="text-3xl font-bold text-slate-900">Welcome</h1>
    <p class="mt-2 text-slate-600">
        This is <code class="px-1 py-0.5 rounded bg-slate-100 text-slate-700">front-page.php</code>.
        Edit it to build a custom homepage layout.
    </p>
</section>

<section class="mt-10">
    <h2 class="text-xl font-semibold text-slate-900 mb-4">Latest posts</h2>

    <?php
    $latest = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 5,
    ]);
    ?>

    <?php if ($latest->have_posts()) : ?>
        <div class="grid gap-4">
            <?php while ($latest->have_posts()) : $latest->the_post(); ?>
                <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-slate-500 mb-2"><?php echo esc_html(get_the_date()); ?></p>
                    <h3 class="text-lg font-semibold">
                        <a class="text-slate-900 hover:text-blue-600" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </article>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="text-slate-600">No posts yet.</p>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
