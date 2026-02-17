<?php 
/**
 * Template Name: Careers
 * Careers Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_careers_hero_stats_careers', "50+ | Team Members\n15+ | Countries\n4.5/5 | Glassdoor Rating\n100% | Remote Options");
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
    'badge' => get_option('apex_careers_hero_badge_careers', 'Join Our Team'),
    'heading' => get_option('apex_careers_hero_heading_careers', 'Build the Future of African Fintech'),
    'description' => get_option('apex_careers_hero_description_careers', "Join a team of passionate innovators transforming financial services across Africa. We're looking for talented individuals who want to make an impact."),
    'stats' => $stats_array,
    'image' => get_option('apex_careers_hero_image_careers', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200')
]);
?>

<section class="apex-careers-why">
    <div class="apex-careers-why__container">
        <div class="apex-careers-why__header">
            <h2 class="apex-careers-why__heading"><?php echo esc_html(get_option('apex_careers_why_heading_careers', 'Why Work at Apex?')); ?></h2>
            <p class="apex-careers-why__description"><?php echo esc_html(get_option('apex_careers_why_description_careers', "We're not just building software—we're building the future of financial services in Africa.")); ?></p>
        </div>
        
        <div class="apex-careers-why__grid">
            <?php
            // Icon mapping for benefits
            $benefit_icons = [
                'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
                'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'check-shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
                'heart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
                'star' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
                'award' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
                'briefcase' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'
            ];
            
            $benefits = get_option('apex_careers_why_items_careers', 
                "Impactful Work | Build solutions that help millions access financial services and improve lives across Africa. | shield\n" .
                "Global Impact | Work with clients across 15+ African countries and see your work make a real difference. | globe\n" .
                "Growth & Learning | Continuous learning opportunities, mentorship, and career growth paths. | users\n" .
                "Competitive Benefits | Competitive salary, equity, health insurance, and flexible work arrangements. | check-shield"
            );
            
            $benefit_lines = explode("\n", $benefits);
            foreach ($benefit_lines as $benefit_line) {
                $parts = explode(' | ', $benefit_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $icon_key = trim($parts[2]);
                    $icon = isset($benefit_icons[$icon_key]) ? $benefit_icons[$icon_key] : '';
                    ?>
                    <div class="apex-careers-why__item">
                        <div class="apex-careers-why__icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-careers-openings">
    <div class="apex-careers-openings__container">
        <div class="apex-careers-openings__header">
            <h2 class="apex-careers-openings__heading"><?php echo esc_html(get_option('apex_careers_openings_heading_careers', 'Open Positions')); ?></h2>
            <p class="apex-careers-openings__description"><?php echo esc_html(get_option('apex_careers_openings_description_careers', 'Find your next opportunity')); ?></p>
        </div>
        
        <div class="apex-careers-openings__list">
            <?php
            $jobs = get_option('apex_careers_openings_items_careers', 
                "Senior Full-Stack Developer | Nairobi, Kenya (Remote) | Full-time | We're looking for an experienced developer to help build our next-generation core banking platform. | PHP, React, PostgreSQL\n" .
                "Mobile Developer (iOS/Android) | Lagos, Nigeria (Remote) | Full-time | Build beautiful mobile banking experiences that work even in low-connectivity areas. | React Native, TypeScript, Mobile\n" .
                "Product Manager | Nairobi, Kenya | Full-time | Drive product strategy and work with cross-functional teams to deliver exceptional fintech products. | Product, Strategy, Agile\n" .
                "DevOps Engineer | Remote | Full-time | Build and maintain our cloud infrastructure ensuring 99.99% uptime for critical banking systems. | AWS, Kubernetes, CI/CD"
            );
            
            $job_lines = explode("\n", $jobs);
            foreach ($job_lines as $job_line) {
                $parts = explode(' | ', $job_line);
                if (count($parts) >= 5) {
                    $title = trim($parts[0]);
                    $location = trim($parts[1]);
                    $type = trim($parts[2]);
                    $description = trim($parts[3]);
                    $tags = array_map('trim', explode(',', $parts[4]));
                    ?>
                    <div class="apex-careers-openings__item">
                        <div class="apex-careers-openings__item-content">
                            <h3><?php echo esc_html($title); ?></h3>
                            <div class="apex-careers-openings__meta">
                                <span class="apex-careers-openings__location"><?php echo esc_html($location); ?></span>
                                <span class="apex-careers-openings__type"><?php echo esc_html($type); ?></span>
                            </div>
                            <p><?php echo esc_html($description); ?></p>
                            <div class="apex-careers-openings__tags">
                                <?php foreach ($tags as $tag): ?>
                                    <span><?php echo esc_html($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <a href="#" class="apex-careers-openings__apply">Apply Now →</a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-careers-culture">
    <div class="apex-careers-culture__container">
        <div class="apex-careers-culture__header">
            <h2 class="apex-careers-culture__heading"><?php echo esc_html(get_option('apex_careers_culture_heading_careers', 'Our Culture')); ?></h2>
            <p class="apex-careers-culture__description"><?php echo esc_html(get_option('apex_careers_culture_description_careers', 'We believe in creating an environment where everyone can thrive')); ?></p>
        </div>
        
        <div class="apex-careers-culture__grid">
            <?php
            $culture_values = get_option('apex_careers_culture_items_careers', 
                "Diversity & Inclusion | We celebrate diverse backgrounds and perspectives. Our team represents 10+ African countries.\n" .
                "Work-Life Balance | Flexible hours, remote work options, and generous time off policies.\n" .
                "Continuous Learning | Learning budget, conference attendance, and internal knowledge sharing sessions.\n" .
                "Transparency | Open communication, regular town halls, and access to leadership."
            );
            
            $culture_lines = explode("\n", $culture_values);
            foreach ($culture_lines as $culture_line) {
                $parts = explode(' | ', $culture_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    ?>
                    <div class="apex-careers-culture__item">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
