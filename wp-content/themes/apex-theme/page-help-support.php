<?php 
/**
 * Template Name: Help & Support
 * Help & Support Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_support_hero_stats_help-support', "24/7 | Support Available\n<2hrs | Response Time\n99.9% | Satisfaction\n15+ | Countries");
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
    'badge' => get_option('apex_support_hero_badge_help-support', 'Help & Support'),
    'heading' => get_option('apex_support_hero_heading_help-support', "We're Here to Help"),
    'description' => get_option('apex_support_hero_description_help-support', 'Get the support you need with our comprehensive help resources and dedicated support team available 24/7.'),
    'stats' => $stats_array,
    'image' => get_option('apex_support_hero_image_help-support', 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200')
]);
?>

<section class="apex-support-channels">
    <div class="apex-support-channels__container">
        <div class="apex-support-channels__header">
            <h2 class="apex-support-channels__heading"><?php echo esc_html(get_option('apex_support_channels_heading_help-support', 'How Can We Help?')); ?></h2>
            <p class="apex-support-channels__description"><?php echo esc_html(get_option('apex_support_channels_description_help-support', 'Choose the support channel that works best for you')); ?></p>
        </div>
        
        <div class="apex-support-channels__grid">
            <?php
            // Icon mapping for support channels
            $channel_icons = [
                'book' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                'help-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>',
                'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
                'code' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
                'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>',
                'message-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
                'file-text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>'
            ];
            
            $channels = get_option('apex_support_channels_items_help-support', 
                "Knowledge Base | Find answers in our comprehensive documentation and guides. | Browse Articles → | #knowledge-base | book\n" .
                "FAQ | Quick answers to common questions about our products and services. | View FAQ → | #faq | help-circle\n" .
                "Contact Support | Get personalized help from our support team via phone, email, or chat. | Contact Us → | #contact | phone\n" .
                "Developer Resources | API documentation, SDKs, and integration guides for developers. | Explore APIs → | #developers | code"
            );
            
            $channel_lines = explode("\n", $channels);
            foreach ($channel_lines as $channel_line) {
                $parts = explode(' | ', $channel_line);
                if (count($parts) >= 5) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $link_text = trim($parts[2]);
                    $url = trim($parts[3]);
                    $icon_key = trim($parts[4]);
                    $icon = isset($channel_icons[$icon_key]) ? $channel_icons[$icon_key] : '';
                    ?>
                    <a href="<?php echo esc_url($url); ?>" class="apex-support-channels__card">
                        <div class="apex-support-channels__card-icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <span class="apex-support-channels__card-link"><?php echo esc_html($link_text); ?></span>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-support-contact" id="contact">
    <div class="apex-support-contact__container">
        <div class="apex-support-contact__header">
            <h2 class="apex-support-contact__heading"><?php echo esc_html(get_option('apex_support_contact_heading_help-support', 'Contact Our Support Team')); ?></h2>
            <p class="apex-support-contact__description"><?php echo esc_html(get_option('apex_support_contact_description_help-support', "We're here to help you succeed")); ?></p>
        </div>
        
        <div class="apex-support-contact__grid">
            <?php
            // Icon mapping for contact methods
            $contact_icons = [
                'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
                'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>',
                'message-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>'
            ];
            
            $contacts = get_option('apex_support_contact_items_help-support', 
                "Phone Support | Speak directly with our support team | +254 700 000 000 | 24/7 for critical issues | phone | tel\n" .
                "Email Support | Send us your questions and we'll respond within 2 hours | support@apex-softwares.com | Response time: <2 hours | mail | mailto\n" .
                "Live Chat | Chat with our support team in real-time | Start Live Chat | Available 24/7 | message-circle | button"
            );
            
            $contact_lines = explode("\n", $contacts);
            foreach ($contact_lines as $contact_line) {
                $parts = explode(' | ', $contact_line);
                if (count($parts) >= 6) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $contact_value = trim($parts[2]);
                    $hours = trim($parts[3]);
                    $icon_key = trim($parts[4]);
                    $type = trim($parts[5]);
                    $icon = isset($contact_icons[$icon_key]) ? $contact_icons[$icon_key] : '';
                    ?>
                    <div class="apex-support-contact__item">
                        <div class="apex-support-contact__icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <?php if ($type === 'tel'): ?>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $contact_value)); ?>" class="apex-support-contact__link"><?php echo esc_html($contact_value); ?></a>
                        <?php elseif ($type === 'mailto'): ?>
                            <a href="mailto:<?php echo esc_attr($contact_value); ?>" class="apex-support-contact__link"><?php echo esc_html($contact_value); ?></a>
                        <?php else: ?>
                            <button class="apex-support-contact__link"><?php echo esc_html($contact_value); ?></button>
                        <?php endif; ?>
                        <span class="apex-support-contact__hours"><?php echo esc_html($hours); ?></span>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-support-resources">
    <div class="apex-support-resources__container">
        <div class="apex-support-resources__header">
            <h2 class="apex-support-resources__heading"><?php echo esc_html(get_option('apex_support_resources_heading_help-support', 'Popular Resources')); ?></h2>
            <p class="apex-support-resources__description"><?php echo esc_html(get_option('apex_support_resources_description_help-support', 'Quick access to our most helpful resources')); ?></p>
        </div>
        
        <div class="apex-support-resources__grid">
            <?php
            $resources = get_option('apex_support_resources_items_help-support', 
                "Getting Started Guide | Learn the basics of using our platform with our step-by-step guide. | Read Guide →\n" .
                "Video Tutorials | Watch our video tutorials to learn how to use specific features. | Watch Videos →\n" .
                "System Status | Check the current status of all our services and any ongoing incidents. | Check Status →\n" .
                "Release Notes | Stay updated with the latest features and improvements. | View Updates →"
            );
            
            $resource_lines = explode("\n", $resources);
            foreach ($resource_lines as $resource_line) {
                $parts = explode(' | ', $resource_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $link_text = trim($parts[2]);
                    ?>
                    <a href="#" class="apex-support-resources__item">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <span><?php echo esc_html($link_text); ?></span>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
