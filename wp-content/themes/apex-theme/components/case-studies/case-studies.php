<?php
/**
 * Case Studies Component
 * Detailed client success stories with metrics
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_CaseStudies_Component {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }
    
    public function enqueue_assets() {
        if (is_front_page()) {
            wp_enqueue_style(
                'apex-case-studies-component',
                get_template_directory_uri() . '/components/case-studies/case-studies.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-case-studies-component',
                get_template_directory_uri() . '/components/case-studies/case-studies.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Case Studies',
            'heading' => 'Real Results from Real Clients',
            'description' => 'Discover how financial institutions across Africa have transformed their operations with ApexCore.',
            'cases' => [
                [
                    'id' => 'unity-sacco',
                    'client' => 'Unity SACCO',
                    'industry' => 'SACCO / Credit Union',
                    'location' => 'Kenya',
                    'logo' => 'https://via.placeholder.com/120x60?text=Unity+SACCO',
                    'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800',
                    'challenge' => 'Legacy systems causing 48-hour delays in loan processing, high operational costs, and inability to offer mobile banking services to members.',
                    'solution' => 'Full ApexCore implementation including core banking, mobile app, and agent banking network across 15 branches.',
                    'results' => [
                        ['metric' => '85%', 'label' => 'Faster Loan Processing'],
                        ['metric' => '40%', 'label' => 'Cost Reduction'],
                        ['metric' => '3x', 'label' => 'Member Growth'],
                        ['metric' => '99.9%', 'label' => 'System Uptime']
                    ],
                    'quote' => 'ApexCore transformed our operations completely. What used to take 2 days now happens in minutes.',
                    'author' => 'James Mwangi',
                    'role' => 'CEO, Unity SACCO',
                    'timeline' => '12 weeks implementation',
                    'featured' => true
                ],
                [
                    'id' => 'premier-mfi',
                    'client' => 'Premier Microfinance',
                    'industry' => 'Microfinance Institution',
                    'location' => 'Uganda',
                    'logo' => 'https://via.placeholder.com/120x60?text=Premier+MFI',
                    'image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=800',
                    'challenge' => 'Manual processes limiting growth, no real-time visibility into operations, and compliance reporting taking weeks to prepare.',
                    'solution' => 'ApexCore with automated workflows, real-time analytics dashboard, and regulatory reporting automation.',
                    'results' => [
                        ['metric' => '60%', 'label' => 'Efficiency Gain'],
                        ['metric' => '95%', 'label' => 'Report Automation'],
                        ['metric' => '50K+', 'label' => 'New Customers'],
                        ['metric' => '24hrs', 'label' => 'Compliance Reports']
                    ],
                    'quote' => 'The analytics capabilities alone have revolutionized how we make decisions.',
                    'author' => 'Sarah Ochieng',
                    'role' => 'CTO, Premier MFI',
                    'timeline' => '16 weeks implementation',
                    'featured' => false
                ],
                [
                    'id' => 'heritage-bank',
                    'client' => 'Heritage Community Bank',
                    'industry' => 'Community Bank',
                    'location' => 'Tanzania',
                    'logo' => 'https://via.placeholder.com/120x60?text=Heritage+Bank',
                    'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800',
                    'challenge' => 'Unable to reach rural communities, high cost of branch expansion, and limited digital channel offerings.',
                    'solution' => 'Agent banking network with 500+ agents, mobile banking app, and USSD banking for feature phones.',
                    'results' => [
                        ['metric' => '500+', 'label' => 'Active Agents'],
                        ['metric' => '200%', 'label' => 'Customer Reach'],
                        ['metric' => '$2M', 'label' => 'Saved on Branches'],
                        ['metric' => '70%', 'label' => 'Rural Penetration']
                    ],
                    'quote' => 'We now serve communities that were previously unbanked, all without building new branches.',
                    'author' => 'David Kimani',
                    'role' => 'Operations Director',
                    'timeline' => '20 weeks implementation',
                    'featured' => false
                ]
            ],
            'cta' => [
                'text' => 'View All Case Studies',
                'url' => home_url('/case-studies')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-case-studies" data-case-studies-section>
            <div class="apex-case-studies__container">
                <!-- Header -->
                <div class="apex-case-studies__header" data-animate="fade-up">
                    <span class="apex-case-studies__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-case-studies__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-case-studies__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Featured Case -->
                <?php 
                $featured = array_filter($args['cases'], function($case) { return $case['featured']; });
                $featured = reset($featured);
                if ($featured) : 
                ?>
                <div class="apex-case-studies__featured" data-animate="fade-up">
                    <div class="apex-case-studies__featured-image">
                        <img src="<?php echo esc_url($featured['image']); ?>" alt="<?php echo esc_attr($featured['client']); ?>" loading="lazy">
                        <div class="apex-case-studies__featured-overlay"></div>
                    </div>
                    <div class="apex-case-studies__featured-content">
                        <div class="apex-case-studies__featured-meta">
                            <span class="apex-case-studies__industry"><?php echo esc_html($featured['industry']); ?></span>
                            <span class="apex-case-studies__location"><?php echo esc_html($featured['location']); ?></span>
                        </div>
                        <h3 class="apex-case-studies__featured-title"><?php echo esc_html($featured['client']); ?></h3>
                        
                        <div class="apex-case-studies__featured-details">
                            <div class="apex-case-studies__detail-block">
                                <h4>Challenge</h4>
                                <p><?php echo esc_html($featured['challenge']); ?></p>
                            </div>
                            <div class="apex-case-studies__detail-block">
                                <h4>Solution</h4>
                                <p><?php echo esc_html($featured['solution']); ?></p>
                            </div>
                        </div>
                        
                        <div class="apex-case-studies__featured-results">
                            <?php foreach ($featured['results'] as $result) : ?>
                            <div class="apex-case-studies__result">
                                <span class="apex-case-studies__result-metric"><?php echo esc_html($result['metric']); ?></span>
                                <span class="apex-case-studies__result-label"><?php echo esc_html($result['label']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <blockquote class="apex-case-studies__quote">
                            <p>"<?php echo esc_html($featured['quote']); ?>"</p>
                            <cite>
                                <strong><?php echo esc_html($featured['author']); ?></strong>
                                <span><?php echo esc_html($featured['role']); ?></span>
                            </cite>
                        </blockquote>
                        
                        <a href="<?php echo esc_url(home_url('/case-studies/' . $featured['id'])); ?>" class="apex-case-studies__read-more">
                            Read Full Case Study
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Other Cases Grid -->
                <div class="apex-case-studies__grid">
                    <?php 
                    $other_cases = array_filter($args['cases'], function($case) { return !$case['featured']; });
                    foreach ($other_cases as $index => $case) : 
                    ?>
                    <div class="apex-case-studies__card" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-case-studies__card-image">
                            <img src="<?php echo esc_url($case['image']); ?>" alt="<?php echo esc_attr($case['client']); ?>" loading="lazy">
                        </div>
                        <div class="apex-case-studies__card-content">
                            <div class="apex-case-studies__card-meta">
                                <span class="apex-case-studies__industry"><?php echo esc_html($case['industry']); ?></span>
                            </div>
                            <h3 class="apex-case-studies__card-title"><?php echo esc_html($case['client']); ?></h3>
                            <p class="apex-case-studies__card-challenge"><?php echo esc_html(wp_trim_words($case['challenge'], 20)); ?></p>
                            
                            <div class="apex-case-studies__card-results">
                                <?php foreach (array_slice($case['results'], 0, 2) as $result) : ?>
                                <div class="apex-case-studies__card-result">
                                    <span class="apex-case-studies__result-metric"><?php echo esc_html($result['metric']); ?></span>
                                    <span class="apex-case-studies__result-label"><?php echo esc_html($result['label']); ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <a href="<?php echo esc_url(home_url('/case-studies/' . $case['id'])); ?>" class="apex-case-studies__card-link">
                                View Case Study
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- CTA -->
                <div class="apex-case-studies__cta" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-case-studies__cta-btn">
                        <?php echo esc_html($args['cta']['text']); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_CaseStudies_Component::get_instance();

// Helper function
function apex_render_case_studies($args = []) {
    Apex_CaseStudies_Component::get_instance()->render($args);
}
