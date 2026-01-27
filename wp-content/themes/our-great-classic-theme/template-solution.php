<?php
/**
 * Template Name: Solution Page
 * Description: Template for individual solution pages
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="hover:text-apex-orange transition-colors">Solutions</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium"><?php the_title(); ?></li>
        </ol>
    </div>
</nav>

<!-- Back to Overview Link -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="inline-flex items-center text-apex-orange font-medium hover:underline">
        ← Back to Solutions Overview
    </a>
</div>

<!-- Hero Section with Orange Wave Background -->
<section class="relative overflow-hidden bg-gradient-to-b from-apex-orange/10 to-white py-16">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxwYXRoIGQ9Ik0wLDUwTDI1LDcwTDUwLDQwTDc1LDgwTDEwMCwzMCIgc3Ryb2tlPSJyZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] bg-repeat-x bg-top bg-cover opacity-20"></div>
    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-apex-dark mb-4"><?php the_title(); ?></h1>
        <p class="text-xl text-apex-gray-600">
            <?php if (has_excerpt()) : ?>
                <?php echo get_the_excerpt(); ?>
            <?php else : ?>
                Comprehensive solution for modern financial institutions.
            <?php endif; ?>
        </p>
    </div>
</section>

<!-- Main Content -->
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="prose prose-lg max-w-none">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </div>
    
    <div class="mt-12 pt-8 border-t border-apex-gray-200">
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="flex-1 inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-6 py-3 text-base font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
                Request Demo
            </a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="flex-1 inline-flex items-center justify-center rounded-lg border border-apex-orange bg-white px-6 py-3 text-base font-bold text-apex-orange hover:bg-apex-orange hover:text-white transition-all duration-200">
                Contact Sales
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>