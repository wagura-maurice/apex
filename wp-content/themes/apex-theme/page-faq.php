<?php 
/**
 * Template Name: FAQ
 * FAQ Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_faq_hero_stats_faq', "50+ | Questions Answered\n24/7 | Support Available\n5min | Avg. Read Time\n100% | Coverage");
$stats_array = [];
foreach (explode("\n", $hero_stats) as $stat_line) {
    $parts = explode(' | ', $stat_line);
    if (count($parts) >= 2) {
        $stats_array[] = [
            'value' => trim($parts[0]),
            'label' => trim($parts[1])
        ];
    }
}

apex_render_about_hero([
    'badge' => get_option('apex_faq_hero_badge_faq', 'FAQ'),
    'heading' => get_option('apex_faq_hero_heading_faq', 'Frequently Asked Questions'),
    'description' => get_option('apex_faq_hero_description_faq', 'Find answers to common questions about our products, services, and company.'),
    'stats' => $stats_array,
    'image' => get_option('apex_faq_hero_image_faq', 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200')
]);
?>

<section class="apex-faq-content">
    <div class="apex-faq-content__container">
        <div class="apex-faq-content__sidebar">
            <h3>Categories</h3>
            <nav class="apex-faq-content__nav">
                <a href="#general" class="apex-faq-content__nav-link active">General</a>
                <a href="#products" class="apex-faq-content__nav-link">Products & Services</a>
                <a href="#pricing" class="apex-faq-content__nav-link">Pricing</a>
                <a href="#technical" class="apex-faq-content__nav-link">Technical Support</a>
                <a href="#security" class="apex-faq-content__nav-link">Security</a>
                <a href="#billing" class="apex-faq-content__nav-link">Billing</a>
            </nav>
        </div>
        
        <div class="apex-faq-content__main">
            <?php
            // Helper function to render FAQ section
            function render_faq_section($section_id, $section_title, $option_key) {
                $items = get_option($option_key, '');
                if (empty($items)) return;
                
                $lines = explode("\n", $items);
                ?>
                <section id="<?php echo esc_attr($section_id); ?>" class="apex-faq-content__section">
                    <h2><?php echo esc_html($section_title); ?></h2>
                    <?php
                    foreach ($lines as $line) {
                        $parts = explode(' | ', $line);
                        if (count($parts) >= 2) {
                            $question = trim($parts[0]);
                            $answer = trim($parts[1]);
                            ?>
                            <div class="apex-faq-content__item">
                                <h3><?php echo esc_html($question); ?></h3>
                                <p><?php echo esc_html($answer); ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </section>
                <?php
            }
            
            render_faq_section('general', 'General Questions', 'apex_faq_general_items_faq');
            render_faq_section('products', 'Products & Services', 'apex_faq_products_items_faq');
            render_faq_section('pricing', 'Pricing', 'apex_faq_pricing_items_faq');
            render_faq_section('technical', 'Technical Support', 'apex_faq_technical_items_faq');
            render_faq_section('security', 'Security', 'apex_faq_security_items_faq');
            render_faq_section('billing', 'Billing', 'apex_faq_billing_items_faq');
            ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
