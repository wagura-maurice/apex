<?php
/**
 * ROI Calculator Component
 * Interactive calculator for estimating return on investment
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_ROICalculator_Component {
    
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
                'apex-roi-calculator-component',
                get_template_directory_uri() . '/components/roi-calculator/roi-calculator.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-roi-calculator-component',
                get_template_directory_uri() . '/components/roi-calculator/roi-calculator.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'ROI Calculator',
            'heading' => 'Calculate Your Return on Investment',
            'description' => 'See how ApexCore can transform your financial institution\'s efficiency and profitability.',
            'metrics' => [
                [
                    'id' => 'customers',
                    'label' => 'Number of Customers',
                    'min' => 1000,
                    'max' => 500000,
                    'default' => 50000,
                    'step' => 1000,
                    'format' => 'number'
                ],
                [
                    'id' => 'transactions',
                    'label' => 'Monthly Transactions',
                    'min' => 10000,
                    'max' => 5000000,
                    'default' => 500000,
                    'step' => 10000,
                    'format' => 'number'
                ],
                [
                    'id' => 'branches',
                    'label' => 'Number of Branches',
                    'min' => 1,
                    'max' => 500,
                    'default' => 25,
                    'step' => 1,
                    'format' => 'number'
                ],
                [
                    'id' => 'staff',
                    'label' => 'Operations Staff',
                    'min' => 10,
                    'max' => 2000,
                    'default' => 150,
                    'step' => 5,
                    'format' => 'number'
                ]
            ],
            'results' => [
                [
                    'id' => 'efficiency',
                    'label' => 'Operational Efficiency Gain',
                    'icon' => 'trending-up',
                    'suffix' => '%',
                    'color' => 'blue'
                ],
                [
                    'id' => 'cost-savings',
                    'label' => 'Annual Cost Savings',
                    'icon' => 'dollar',
                    'prefix' => '$',
                    'color' => 'green'
                ],
                [
                    'id' => 'time-saved',
                    'label' => 'Hours Saved Monthly',
                    'icon' => 'clock',
                    'suffix' => ' hrs',
                    'color' => 'orange'
                ],
                [
                    'id' => 'payback',
                    'label' => 'Payback Period',
                    'icon' => 'calendar',
                    'suffix' => ' months',
                    'color' => 'purple'
                ]
            ],
            'cta' => [
                'text' => 'Get Detailed Analysis',
                'url' => home_url('/contact')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'trending-up' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
            'dollar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            'calendar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            'calculator' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="16" y1="14" x2="16" y2="18"/><line x1="16" y1="10" x2="16" y2="10.01"/><line x1="12" y1="10" x2="12" y2="10.01"/><line x1="8" y1="10" x2="8" y2="10.01"/><line x1="12" y1="14" x2="12" y2="14.01"/><line x1="8" y1="14" x2="8" y2="14.01"/><line x1="12" y1="18" x2="12" y2="18.01"/><line x1="8" y1="18" x2="8" y2="18.01"/></svg>'
        ];
        ?>
        <section class="apex-roi-calculator" data-roi-calculator-section>
            <div class="apex-roi-calculator__container">
                <div class="apex-roi-calculator__grid">
                    <!-- Left Column - Inputs -->
                    <div class="apex-roi-calculator__inputs" data-animate="fade-right">
                        <div class="apex-roi-calculator__header">
                            <span class="apex-roi-calculator__badge"><?php echo esc_html($args['badge']); ?></span>
                            <h2 class="apex-roi-calculator__heading"><?php echo esc_html($args['heading']); ?></h2>
                            <p class="apex-roi-calculator__description"><?php echo esc_html($args['description']); ?></p>
                        </div>
                        
                        <div class="apex-roi-calculator__form">
                            <?php foreach ($args['metrics'] as $metric) : ?>
                            <div class="apex-roi-calculator__field">
                                <label class="apex-roi-calculator__label" for="roi-<?php echo esc_attr($metric['id']); ?>">
                                    <?php echo esc_html($metric['label']); ?>
                                </label>
                                <div class="apex-roi-calculator__input-group">
                                    <input 
                                        type="range" 
                                        id="roi-<?php echo esc_attr($metric['id']); ?>"
                                        class="apex-roi-calculator__slider"
                                        min="<?php echo esc_attr($metric['min']); ?>"
                                        max="<?php echo esc_attr($metric['max']); ?>"
                                        value="<?php echo esc_attr($metric['default']); ?>"
                                        step="<?php echo esc_attr($metric['step']); ?>"
                                        data-metric="<?php echo esc_attr($metric['id']); ?>"
                                    >
                                    <span class="apex-roi-calculator__value" data-value-for="<?php echo esc_attr($metric['id']); ?>">
                                        <?php echo number_format($metric['default']); ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Right Column - Results -->
                    <div class="apex-roi-calculator__results" data-animate="fade-left">
                        <div class="apex-roi-calculator__results-header">
                            <div class="apex-roi-calculator__results-icon">
                                <?php echo $icons['calculator']; ?>
                            </div>
                            <h3 class="apex-roi-calculator__results-title">Estimated Results</h3>
                            <p class="apex-roi-calculator__results-subtitle">Based on your inputs</p>
                        </div>
                        
                        <div class="apex-roi-calculator__results-grid">
                            <?php foreach ($args['results'] as $result) : ?>
                            <div class="apex-roi-calculator__result-card apex-roi-calculator__result-card--<?php echo esc_attr($result['color']); ?>">
                                <div class="apex-roi-calculator__result-icon">
                                    <?php echo $icons[$result['icon']] ?? ''; ?>
                                </div>
                                <div class="apex-roi-calculator__result-value" data-result="<?php echo esc_attr($result['id']); ?>">
                                    <?php echo isset($result['prefix']) ? esc_html($result['prefix']) : ''; ?>
                                    <span class="apex-roi-calculator__result-number">0</span>
                                    <?php echo isset($result['suffix']) ? esc_html($result['suffix']) : ''; ?>
                                </div>
                                <div class="apex-roi-calculator__result-label"><?php echo esc_html($result['label']); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="apex-roi-calculator__results-cta">
                            <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-roi-calculator__cta-btn">
                                <?php echo esc_html($args['cta']['text']); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <p class="apex-roi-calculator__disclaimer">* Estimates based on industry averages. Actual results may vary.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_ROICalculator_Component::get_instance();

// Helper function
function apex_render_roi_calculator($args = []) {
    Apex_ROICalculator_Component::get_instance()->render($args);
}
