<?php 
/**
 * Template Name: Developers
 * Developers Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_dev_hero_stats_developers', "50+ | API Endpoints\n5 | SDKs Available\n99.9% | Uptime SLA\n24/7 | API Support");
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
    'badge' => get_option('apex_dev_hero_badge_developers', 'Developers'),
    'heading' => get_option('apex_dev_hero_heading_developers', 'Build with Our APIs'),
    'description' => get_option('apex_dev_hero_description_developers', 'Integrate our powerful APIs to build custom solutions. Comprehensive documentation, SDKs, and developer tools to help you succeed.'),
    'stats' => $stats_array,
    'image' => get_option('apex_dev_hero_image_developers', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200')
]);
?>

<section class="apex-dev-apis">
    <div class="apex-dev-apis__container">
        <div class="apex-dev-apis__header">
            <h2 class="apex-dev-apis__heading"><?php echo esc_html(get_option('apex_dev_apis_heading_developers', 'Our APIs')); ?></h2>
            <p class="apex-dev-apis__description"><?php echo esc_html(get_option('apex_dev_apis_description_developers', 'RESTful APIs designed for developers')); ?></p>
        </div>
        
        <div class="apex-dev-apis__grid">
            <?php
            $api_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>'
            ];
            
            $apis = get_option('apex_dev_apis_items_developers', 
                "Core Banking API | Full access to core banking functionality including accounts, transactions, loans, and customer management.\n" .
                "Mobile Banking API | Build custom mobile apps with our comprehensive mobile banking API for iOS and Android.\n" .
                "Agent Banking API | Manage agent networks, process transactions, and monitor agent performance programmatically.\n" .
                "Authentication API | Secure authentication and authorization with OAuth 2.0 and JWT token support.\n" .
                "Webhooks API | Subscribe to real-time events and build automated workflows with our webhook system.\n" .
                "Reports API | Generate custom reports, export data, and access analytics programmatically."
            );
            
            $api_lines = explode("\n", $apis);
            $icon_index = 0;
            foreach ($api_lines as $api_line) {
                $parts = explode(' | ', $api_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $icon = isset($api_icons[$icon_index]) ? $api_icons[$icon_index] : '';
                    ?>
                    <div class="apex-dev-apis__item">
                        <div class="apex-dev-apis__item-icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
                    </div>
                    <?php
                    $icon_index++;
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-dev-sdks">
    <div class="apex-dev-sdks__container">
        <div class="apex-dev-sdks__header">
            <h2 class="apex-dev-sdks__heading"><?php echo esc_html(get_option('apex_dev_sdks_heading_developers', 'Official SDKs')); ?></h2>
            <p class="apex-dev-sdks__description"><?php echo esc_html(get_option('apex_dev_sdks_description_developers', 'Get started quickly with our official SDKs')); ?></p>
        </div>
        
        <div class="apex-dev-sdks__grid">
            <?php
            $sdks = get_option('apex_dev_sdks_items_developers', 
                "JavaScript SDK | For web applications and Node.js backend development | npm install @apex-softwares/sdk\n" .
                "Python SDK | For Python applications and Django integration | pip install apex-softwares-sdk\n" .
                "PHP SDK | For PHP applications and Laravel integration | composer require apex-softwares/sdk\n" .
                "Java SDK | For Java applications and Spring Boot integration | implementation 'com.apex:sdk'\n" .
                "Go SDK | For Go applications and microservices | go get github.com/apex-softwares/sdk"
            );
            
            $sdk_lines = explode("\n", $sdks);
            foreach ($sdk_lines as $sdk_line) {
                $parts = explode(' | ', $sdk_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $command = trim($parts[2]);
                    ?>
                    <div class="apex-dev-sdks__item">
                        <div class="apex-dev-sdks__item-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <code><?php echo esc_html($command); ?></code>
                        <a href="#" class="apex-dev-sdks__item-link">Get Started →</a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-dev-getting-started">
    <div class="apex-dev-getting-started__container">
        <div class="apex-dev-getting-started__header">
            <h2 class="apex-dev-getting-started__heading"><?php echo esc_html(get_option('apex_dev_quick_heading_developers', 'Quick Start')); ?></h2>
            <p class="apex-dev-getting-started__description"><?php echo esc_html(get_option('apex_dev_quick_description_developers', 'Get up and running in minutes')); ?></p>
        </div>
        
        <div class="apex-dev-getting-started__steps">
            <?php
            $steps = get_option('apex_dev_quick_steps_developers', 
                "Create an Account | Sign up for a developer account to get your API credentials\n" .
                "Get Your API Keys | Generate API keys from your developer dashboard\n" .
                "Install an SDK | Install our SDK for your preferred programming language\n" .
                "Make Your First Call | Start making API calls with our quick start examples"
            );
            
            $step_lines = explode("\n", $steps);
            $step_number = 1;
            foreach ($step_lines as $step_line) {
                $parts = explode(' | ', $step_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    ?>
                    <div class="apex-dev-getting-started__step">
                        <div class="apex-dev-getting-started__step-number"><?php echo $step_number; ?></div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                    $step_number++;
                }
            }
            ?>
        </div>
        
        <div class="apex-dev-getting-started__code">
            <pre><code><?php echo esc_html(get_option('apex_dev_quick_code_developers', "// Install SDK\nnpm install @apex-softwares/sdk\n\n// Initialize\nconst Apex = require('@apex-softwares/sdk');\nconst client = new Apex({\n  apiKey: 'your-api-key',\n  environment: 'sandbox'\n});\n\n// Make your first call\nconst accounts = await client.accounts.list();\nconsole.log(accounts);")); ?></code></pre>
        </div>
    </div>
</section>

<section class="apex-dev-support">
    <div class="apex-dev-support__container">
        <div class="apex-dev-support__header">
            <h2 class="apex-dev-support__heading"><?php echo esc_html(get_option('apex_dev_support_heading_developers', 'Developer Support')); ?></h2>
            <p class="apex-dev-support__description"><?php echo esc_html(get_option('apex_dev_support_description_developers', "We're here to help you succeed")); ?></p>
        </div>
        
        <div class="apex-dev-support__grid">
            <?php
            $support_items = get_option('apex_dev_support_items_developers', 
                "Documentation | Comprehensive API documentation with examples and use cases | Read Docs →\n" .
                "Community Forum | Connect with other developers and share solutions | Join Forum →\n" .
                "GitHub | Open source SDKs, examples, and integration templates | View on GitHub →\n" .
                "Contact Support | Direct access to our developer support team | Get Help →"
            );
            
            $support_lines = explode("\n", $support_items);
            foreach ($support_lines as $support_line) {
                $parts = explode(' | ', $support_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $link_text = trim($parts[2]);
                    ?>
                    <div class="apex-dev-support__item">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <a href="#" class="apex-dev-support__link"><?php echo esc_html($link_text); ?></a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
