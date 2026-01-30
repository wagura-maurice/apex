<?php
/**
 * Testimonials Component
 * Client feedback carousel section
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_Testimonials_Component {
    
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
                'apex-testimonials-component',
                get_template_directory_uri() . '/components/testimonials/testimonials.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-testimonials-component',
                get_template_directory_uri() . '/components/testimonials/testimonials.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Client Success Stories',
            'heading' => 'Trusted by Leading Financial Institutions',
            'description' => 'See what our clients say about transforming their operations with ApexCore.',
            'testimonials' => [
                [
                    'quote' => 'ApexCore has revolutionized our operations. We\'ve seen a 40% increase in efficiency and our customers love the new mobile banking experience.',
                    'author' => 'James Mwangi',
                    'position' => 'CEO',
                    'company' => 'Unity SACCO',
                    'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
                    'rating' => 5
                ],
                [
                    'quote' => 'The implementation was smooth and the support team is exceptional. We went live in just 12 weeks with zero downtime.',
                    'author' => 'Sarah Ochieng',
                    'position' => 'CTO',
                    'company' => 'Premier MFI',
                    'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
                    'rating' => 5
                ],
                [
                    'quote' => 'The agent banking module has helped us reach rural communities we couldn\'t serve before. Our customer base has grown by 60%.',
                    'author' => 'David Kimani',
                    'position' => 'Operations Director',
                    'company' => 'Heritage Bank',
                    'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
                    'rating' => 5
                ],
                [
                    'quote' => 'Real-time reporting and analytics have transformed how we make decisions. We now have complete visibility into our operations.',
                    'author' => 'Grace Wanjiku',
                    'position' => 'Finance Manager',
                    'company' => 'Faulu Microfinance',
                    'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150',
                    'rating' => 5
                ]
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-testimonials" data-testimonials-section>
            <div class="apex-testimonials__container">
                <!-- Header -->
                <div class="apex-testimonials__header" data-animate="fade-up">
                    <span class="apex-testimonials__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-testimonials__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-testimonials__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Testimonials Carousel -->
                <div class="apex-testimonials__carousel" data-testimonials-carousel>
                    <div class="apex-testimonials__track">
                        <?php foreach ($args['testimonials'] as $index => $testimonial) : ?>
                        <div class="apex-testimonials__slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-slide="<?php echo $index; ?>">
                            <div class="apex-testimonials__card">
                                <!-- Quote Icon -->
                                <div class="apex-testimonials__quote-icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                </div>
                                
                                <!-- Rating -->
                                <div class="apex-testimonials__rating">
                                    <?php for ($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    <?php endfor; ?>
                                </div>
                                
                                <!-- Quote -->
                                <blockquote class="apex-testimonials__quote">
                                    "<?php echo esc_html($testimonial['quote']); ?>"
                                </blockquote>
                                
                                <!-- Author -->
                                <div class="apex-testimonials__author">
                                    <img src="<?php echo esc_url($testimonial['image']); ?>" alt="<?php echo esc_attr($testimonial['author']); ?>" class="apex-testimonials__author-image" loading="lazy">
                                    <div class="apex-testimonials__author-info">
                                        <span class="apex-testimonials__author-name"><?php echo esc_html($testimonial['author']); ?></span>
                                        <span class="apex-testimonials__author-role"><?php echo esc_html($testimonial['position']); ?>, <?php echo esc_html($testimonial['company']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="apex-testimonials__nav">
                        <button type="button" class="apex-testimonials__nav-btn" data-testimonials-prev aria-label="Previous testimonial">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <div class="apex-testimonials__indicators">
                            <?php foreach ($args['testimonials'] as $index => $testimonial) : ?>
                            <button type="button" class="apex-testimonials__indicator <?php echo $index === 0 ? 'is-active' : ''; ?>" data-indicator="<?php echo $index; ?>" aria-label="Testimonial <?php echo $index + 1; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="apex-testimonials__nav-btn" data-testimonials-next aria-label="Next testimonial">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_Testimonials_Component::get_instance();

// Helper function
function apex_render_testimonials($args = []) {
    Apex_Testimonials_Component::get_instance()->render($args);
}
