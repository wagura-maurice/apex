<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-bold mb-4 text-slate-900"><?php the_title(); ?></h1>
        <div class="prose prose-slate max-w-none">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
