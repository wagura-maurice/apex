<?php
/**
 * Solutions Detail Component
 * Enhanced product showcase with technical specs, metrics, and comparisons
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_SolutionsDetail_Component {
    
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
                'apex-solutions-detail-component',
                get_template_directory_uri() . '/components/solutions-detail/solutions-detail.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-solutions-detail-component',
                get_template_directory_uri() . '/components/solutions-detail/solutions-detail.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Enterprise Solutions',
            'heading' => 'Technical Specifications & Capabilities',
            'description' => 'Industry-leading performance metrics and enterprise-grade specifications designed for mission-critical financial operations.',
            'solutions' => [
                [
                    'id' => 'core-banking',
                    'title' => 'Core Banking Platform',
                    'tagline' => 'Multi-tenant, cloud-native architecture',
                    'icon' => 'database',
                    'specs' => [
                        ['label' => 'Transaction Throughput', 'value' => '10,000+ TPS', 'icon' => 'zap'],
                        ['label' => 'System Uptime SLA', 'value' => '99.99%', 'icon' => 'shield'],
                        ['label' => 'Data Encryption', 'value' => 'AES-256', 'icon' => 'lock'],
                        ['label' => 'API Response Time', 'value' => '<50ms', 'icon' => 'clock'],
                        ['label' => 'Concurrent Users', 'value' => '100,000+', 'icon' => 'users'],
                        ['label' => 'Data Retention', 'value' => '10+ Years', 'icon' => 'archive']
                    ],
                    'features' => [
                        'Real-time transaction processing',
                        'Multi-currency support (150+ currencies)',
                        'Automated reconciliation engine',
                        'Configurable workflow automation',
                        'Advanced fraud detection algorithms',
                        'Regulatory compliance automation'
                    ],
                    'integrations' => ['SWIFT', 'VISA', 'Mastercard', 'M-Pesa', 'Airtel Money'],
                    'compliance' => ['PCI-DSS', 'ISO 27001', 'SOC 2 Type II', 'GDPR']
                ],
                [
                    'id' => 'mobile-banking',
                    'title' => 'Mobile Banking Suite',
                    'tagline' => 'Native iOS & Android applications',
                    'icon' => 'smartphone',
                    'specs' => [
                        ['label' => 'App Load Time', 'value' => '<2 sec', 'icon' => 'zap'],
                        ['label' => 'Offline Capability', 'value' => 'Full Support', 'icon' => 'wifi-off'],
                        ['label' => 'Biometric Auth', 'value' => 'Face/Touch ID', 'icon' => 'fingerprint'],
                        ['label' => 'Push Latency', 'value' => '<1 sec', 'icon' => 'bell'],
                        ['label' => 'App Size', 'value' => '<25 MB', 'icon' => 'smartphone'],
                        ['label' => 'Battery Impact', 'value' => 'Minimal', 'icon' => 'battery']
                    ],
                    'features' => [
                        'Biometric authentication (Face ID, Touch ID)',
                        'Real-time balance & transaction alerts',
                        'QR code payments & transfers',
                        'Bill payment & airtime purchase',
                        'Loan application & tracking',
                        'Branch & ATM locator with maps'
                    ],
                    'integrations' => ['Apple Pay', 'Google Pay', 'Samsung Pay', 'USSD Fallback'],
                    'compliance' => ['OWASP MASVS', 'App Store Guidelines', 'Play Store Policies']
                ],
                [
                    'id' => 'agent-banking',
                    'title' => 'Agent Banking Network',
                    'tagline' => 'Extend reach to unbanked populations',
                    'icon' => 'users',
                    'specs' => [
                        ['label' => 'Offline Sync', 'value' => '72 Hours', 'icon' => 'refresh'],
                        ['label' => 'Transaction Limit', 'value' => 'Configurable', 'icon' => 'sliders'],
                        ['label' => 'Agent Onboarding', 'value' => '<24 Hours', 'icon' => 'user-plus'],
                        ['label' => 'Commission Calc', 'value' => 'Real-time', 'icon' => 'calculator'],
                        ['label' => 'Float Management', 'value' => 'Automated', 'icon' => 'trending-up'],
                        ['label' => 'KYC Verification', 'value' => 'Instant', 'icon' => 'check-circle']
                    ],
                    'features' => [
                        'Offline-first transaction processing',
                        'Automated float management',
                        'Real-time commission calculation',
                        'Customer onboarding with eKYC',
                        'Cash-in/cash-out operations',
                        'Agent performance analytics'
                    ],
                    'integrations' => ['Biometric Devices', 'POS Terminals', 'Receipt Printers'],
                    'compliance' => ['Central Bank Guidelines', 'AML/CFT', 'Agent Banking Regulations']
                ]
            ],
            'comparison' => [
                'title' => 'Platform Comparison',
                'features' => [
                    ['name' => 'Multi-tenant Architecture', 'apex' => true, 'competitor_a' => true, 'competitor_b' => false],
                    ['name' => 'Real-time Processing', 'apex' => true, 'competitor_a' => true, 'competitor_b' => true],
                    ['name' => 'Offline Capability', 'apex' => true, 'competitor_a' => false, 'competitor_b' => false],
                    ['name' => 'Open API Architecture', 'apex' => true, 'competitor_a' => true, 'competitor_b' => false],
                    ['name' => 'No-code Workflow Builder', 'apex' => true, 'competitor_a' => false, 'competitor_b' => false],
                    ['name' => 'Built-in Analytics', 'apex' => true, 'competitor_a' => true, 'competitor_b' => true],
                    ['name' => 'White-label Mobile Apps', 'apex' => true, 'competitor_a' => false, 'competitor_b' => true],
                    ['name' => 'Agent Banking Module', 'apex' => true, 'competitor_a' => false, 'competitor_b' => false],
                    ['name' => '24/7 Local Support', 'apex' => true, 'competitor_a' => false, 'competitor_b' => false],
                    ['name' => 'Flexible Pricing', 'apex' => true, 'competitor_a' => false, 'competitor_b' => true]
                ]
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = $this->get_icons();
        ?>
        <section class="apex-solutions-detail" data-solutions-detail-section>
            <div class="apex-solutions-detail__container">
                <!-- Header -->
                <div class="apex-solutions-detail__header" data-animate="fade-up">
                    <span class="apex-solutions-detail__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-solutions-detail__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-solutions-detail__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Solution Tabs -->
                <div class="apex-solutions-detail__tabs" data-animate="fade-up">
                    <?php foreach ($args['solutions'] as $index => $solution) : ?>
                    <button type="button" class="apex-solutions-detail__tab <?php echo $index === 0 ? 'is-active' : ''; ?>" data-tab="<?php echo esc_attr($solution['id']); ?>">
                        <span class="apex-solutions-detail__tab-icon"><?php echo $icons[$solution['icon']] ?? ''; ?></span>
                        <span class="apex-solutions-detail__tab-text"><?php echo esc_html($solution['title']); ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Solution Panels -->
                <div class="apex-solutions-detail__panels">
                    <?php foreach ($args['solutions'] as $index => $solution) : ?>
                    <div class="apex-solutions-detail__panel <?php echo $index === 0 ? 'is-active' : ''; ?>" data-panel="<?php echo esc_attr($solution['id']); ?>">
                        <!-- Panel Header -->
                        <div class="apex-solutions-detail__panel-header">
                            <div class="apex-solutions-detail__panel-icon"><?php echo $icons[$solution['icon']] ?? ''; ?></div>
                            <div class="apex-solutions-detail__panel-info">
                                <h3 class="apex-solutions-detail__panel-title"><?php echo esc_html($solution['title']); ?></h3>
                                <p class="apex-solutions-detail__panel-tagline"><?php echo esc_html($solution['tagline']); ?></p>
                            </div>
                        </div>
                        
                        <!-- Technical Specifications Grid -->
                        <div class="apex-solutions-detail__specs">
                            <h4 class="apex-solutions-detail__section-title">Technical Specifications</h4>
                            <div class="apex-solutions-detail__specs-grid">
                                <?php foreach ($solution['specs'] as $spec) : ?>
                                <div class="apex-solutions-detail__spec-card">
                                    <div class="apex-solutions-detail__spec-icon"><?php echo $icons[$spec['icon']] ?? ''; ?></div>
                                    <div class="apex-solutions-detail__spec-value"><?php echo esc_html($spec['value']); ?></div>
                                    <div class="apex-solutions-detail__spec-label"><?php echo esc_html($spec['label']); ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Features & Integrations -->
                        <div class="apex-solutions-detail__features-row">
                            <!-- Key Features -->
                            <div class="apex-solutions-detail__features">
                                <h4 class="apex-solutions-detail__section-title">Key Features</h4>
                                <ul class="apex-solutions-detail__features-list">
                                    <?php foreach ($solution['features'] as $feature) : ?>
                                    <li class="apex-solutions-detail__feature-item">
                                        <span class="apex-solutions-detail__feature-check"><?php echo $icons['check']; ?></span>
                                        <?php echo esc_html($feature); ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <!-- Integrations & Compliance -->
                            <div class="apex-solutions-detail__meta">
                                <div class="apex-solutions-detail__integrations">
                                    <h4 class="apex-solutions-detail__section-title">Integrations</h4>
                                    <div class="apex-solutions-detail__tags">
                                        <?php foreach ($solution['integrations'] as $integration) : ?>
                                        <span class="apex-solutions-detail__tag apex-solutions-detail__tag--integration"><?php echo esc_html($integration); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="apex-solutions-detail__compliance">
                                    <h4 class="apex-solutions-detail__section-title">Compliance</h4>
                                    <div class="apex-solutions-detail__tags">
                                        <?php foreach ($solution['compliance'] as $cert) : ?>
                                        <span class="apex-solutions-detail__tag apex-solutions-detail__tag--compliance"><?php echo esc_html($cert); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA -->
                        <div class="apex-solutions-detail__panel-cta">
                            <a href="<?php echo esc_url(home_url('/solutions/' . $solution['id'])); ?>" class="apex-solutions-detail__btn-primary">
                                View Full Documentation
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                            <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="apex-solutions-detail__btn-secondary">
                                Request Demo
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Comparison Table -->
                <div class="apex-solutions-detail__comparison" data-animate="fade-up">
                    <h3 class="apex-solutions-detail__comparison-title"><?php echo esc_html($args['comparison']['title']); ?></h3>
                    <div class="apex-solutions-detail__comparison-wrapper">
                        <table class="apex-solutions-detail__comparison-table">
                            <thead>
                                <tr>
                                    <th>Feature</th>
                                    <th class="apex-solutions-detail__highlight">ApexCore</th>
                                    <th>Competitor A</th>
                                    <th>Competitor B</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($args['comparison']['features'] as $feature) : ?>
                                <tr>
                                    <td><?php echo esc_html($feature['name']); ?></td>
                                    <td class="apex-solutions-detail__highlight">
                                        <?php if ($feature['apex']) : ?>
                                        <span class="apex-solutions-detail__check"><?php echo $icons['check-circle']; ?></span>
                                        <?php else : ?>
                                        <span class="apex-solutions-detail__cross"><?php echo $icons['x-circle']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($feature['competitor_a']) : ?>
                                        <span class="apex-solutions-detail__check-muted"><?php echo $icons['check-circle']; ?></span>
                                        <?php else : ?>
                                        <span class="apex-solutions-detail__cross"><?php echo $icons['x-circle']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($feature['competitor_b']) : ?>
                                        <span class="apex-solutions-detail__check-muted"><?php echo $icons['check-circle']; ?></span>
                                        <?php else : ?>
                                        <span class="apex-solutions-detail__cross"><?php echo $icons['x-circle']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    
    private function get_icons() {
        return [
            'database' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>',
            'smartphone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'zap' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'lock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
            'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            'archive' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>',
            'wifi-off' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="1" y1="1" x2="23" y2="23"/><path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"/><path d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"/><path d="M10.71 5.05A16 16 0 0 1 22.58 9"/><path d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>',
            'fingerprint' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/><path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/><path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/><path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/><path d="M8.65 22c.21-.66.45-1.32.57-2"/><path d="M14 13.12c0 2.38 0 6.38-1 8.88"/><path d="M2 16h.01"/><path d="M21.8 16c.2-2 .131-5.354 0-6"/><path d="M9 6.8a6 6 0 0 1 9 5.2c0 .47 0 1.17-.02 2"/></svg>',
            'bell' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
            'battery' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="6" width="18" height="12" rx="2" ry="2"/><line x1="23" y1="13" x2="23" y2="11"/></svg>',
            'refresh' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>',
            'sliders' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>',
            'user-plus' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>',
            'calculator' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="16" y1="14" x2="16" y2="18"/><line x1="16" y1="10" x2="16" y2="10.01"/><line x1="12" y1="10" x2="12" y2="10.01"/><line x1="8" y1="10" x2="8" y2="10.01"/><line x1="12" y1="14" x2="12" y2="14.01"/><line x1="8" y1="14" x2="8" y2="14.01"/><line x1="12" y1="18" x2="12" y2="18.01"/><line x1="8" y1="18" x2="8" y2="18.01"/></svg>',
            'trending-up' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
            'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            'check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
            'x-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>'
        ];
    }
}

// Initialize component
Apex_SolutionsDetail_Component::get_instance();

// Helper function
function apex_render_solutions_detail($args = []) {
    Apex_SolutionsDetail_Component::get_instance()->render($args);
}
