<?php 
/**
 * Template Name: Privacy Policy
 * Privacy Policy Page Template
 * 
 * @package ApexTheme
 */

get_header();

// Load the privacy policy page by slug
$privacy_page = get_page_by_path('privacy-policy');

if (!$privacy_page) {
    // Try finding by title as fallback
    $pages = get_posts(array(
        'post_type' => 'page',
        'title' => 'Privacy Policy',
        'posts_per_page' => 1
    ));
    if (!empty($pages)) {
        $privacy_page = $pages[0];
    }
}
?>

<section class="apex-legal-page">
    <div class="apex-legal-page__container">
        <div class="apex-legal-page__header">
            <span class="apex-legal-page__badge">Legal</span>
            <h1 class="apex-legal-page__heading"><?php echo $privacy_page ? esc_html($privacy_page->post_title) : 'Privacy Policy'; ?></h1>
            <p class="apex-legal-page__description">Last updated: <?php echo $privacy_page ? date('F Y', strtotime($privacy_page->post_modified)) : 'January 2027'; ?></p>
        </div>
        
        <div class="apex-legal-page__content">
            <?php 
            if ($privacy_page && $privacy_page->post_type === 'page') {
                echo apply_filters('the_content', $privacy_page->post_content);
            } else {
                echo '<p style="color:red;font-weight:bold;">Error: Privacy Policy page not found. Please create a page with slug "privacy-policy".</p>';
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
