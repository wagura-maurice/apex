<?php 
/**
 * Template Name: Terms & Conditions
 * Terms & Conditions Page Template
 * 
 * @package ApexTheme
 */

get_header();

// Load the terms-and-conditions page by slug
$terms_page = get_page_by_path('terms-and-conditions');

if (!$terms_page) {
    // Try finding by title as fallback
    $pages = get_posts(array(
        'post_type' => 'page',
        'title' => 'Terms & Conditions',
        'posts_per_page' => 1
    ));
    if (!empty($pages)) {
        $terms_page = $pages[0];
    }
}
?>

<section class="apex-legal-page">
    <div class="apex-legal-page__container">
        <div class="apex-legal-page__header">
            <span class="apex-legal-page__badge">Legal</span>
            <h1 class="apex-legal-page__heading"><?php echo $terms_page ? esc_html($terms_page->post_title) : 'Terms & Conditions'; ?></h1>
            <p class="apex-legal-page__description">Last updated: <?php echo $terms_page ? date('F Y', strtotime($terms_page->post_modified)) : 'January 2027'; ?></p>
        </div>
        
        <div class="apex-legal-page__content">
            <?php 
            if ($terms_page && $terms_page->post_type === 'page') {
                echo apply_filters('the_content', $terms_page->post_content);
            } else {
                echo '<p style="color:red;font-weight:bold;">Error: Terms & Conditions page not found. Please create a page with slug "terms-and-conditions".</p>';
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
