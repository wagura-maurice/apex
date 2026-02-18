<?php
/**
 * Compliance & Certifications Component
 * Security certifications and regulatory compliance showcase
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_Compliance_Component {
    
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
                'apex-compliance-component',
                get_template_directory_uri() . '/components/compliance/compliance.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-compliance-component',
                get_template_directory_uri() . '/components/compliance/compliance.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Security & Compliance',
            'heading' => 'Enterprise-Grade Security You Can Trust',
            'description' => 'ApexCore meets the highest standards of security, privacy, and regulatory compliance required by financial institutions worldwide.',
            'certifications' => [
                [
                    'name' => 'PCI DSS Level 1',
                    'description' => 'Payment Card Industry Data Security Standard - highest level of certification for payment processing.',
                    'icon' => 'credit-card',
                    'status' => 'Certified'
                ],
                [
                    'name' => 'ISO 27001',
                    'description' => 'International standard for information security management systems (ISMS).',
                    'icon' => 'shield',
                    'status' => 'Certified'
                ],
                [
                    'name' => 'SOC 2 Type II',
                    'description' => 'Service Organization Control report on security, availability, and confidentiality.',
                    'icon' => 'check-circle',
                    'status' => 'Audited'
                ],
                [
                    'name' => 'GDPR Compliant',
                    'description' => 'Full compliance with EU General Data Protection Regulation requirements.',
                    'icon' => 'lock',
                    'status' => 'Compliant'
                ]
            ],
            'security_features' => [
                [
                    'title' => 'End-to-End Encryption',
                    'description' => 'AES-256 encryption for data at rest and TLS 1.3 for data in transit.',
                    'icon' => 'lock'
                ],
                [
                    'title' => 'Multi-Factor Authentication',
                    'description' => 'Biometric, OTP, and hardware token support for secure access.',
                    'icon' => 'fingerprint'
                ],
                [
                    'title' => 'Real-time Threat Detection',
                    'description' => 'AI-powered monitoring for fraud detection and security threats.',
                    'icon' => 'eye'
                ],
                [
                    'title' => 'Audit Logging',
                    'description' => 'Comprehensive audit trails for all system activities and transactions.',
                    'icon' => 'file-text'
                ],
                [
                    'title' => 'Role-Based Access Control',
                    'description' => 'Granular permissions with principle of least privilege enforcement.',
                    'icon' => 'users'
                ],
                [
                    'title' => 'Disaster Recovery',
                    'description' => 'Automated backups with 99.99% uptime SLA and geo-redundancy.',
                    'icon' => 'refresh'
                ]
            ],
            'cta' => [
                'text' => 'Download Security Whitepaper',
                'url' => home_url('/insights/whitepapers-reports')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'credit-card' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            'lock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
            'fingerprint' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12C2 6.5 6.5 2 12 2a10 10 0 0 1 8 4"/><path d="M5 19.5C5.5 18 6 15 6 12c0-.7.12-1.37.34-2"/><path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/><path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/><path d="M8.65 22c.21-.66.45-1.32.57-2"/><path d="M14 13.12c0 2.38 0 6.38-1 8.88"/></svg>',
            'eye' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
            'file-text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'refresh' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>',
            'download' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>'
        ];
        ?>
        <section class="apex-compliance" data-compliance-section>
            <div class="apex-compliance__container">
                <!-- Header -->
                <div class="apex-compliance__header" data-animate="fade-up">
                    <span class="apex-compliance__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-compliance__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-compliance__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Certifications -->
                <div class="apex-compliance__certifications" data-animate="fade-up">
                    <?php foreach ($args['certifications'] as $index => $cert) : ?>
                    <div class="apex-compliance__cert-card" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-compliance__cert-icon">
                            <?php echo $icons[$cert['icon']] ?? ''; ?>
                        </div>
                        <div class="apex-compliance__cert-content">
                            <div class="apex-compliance__cert-header">
                                <h3 class="apex-compliance__cert-name"><?php echo esc_html($cert['name']); ?></h3>
                                <span class="apex-compliance__cert-status"><?php echo esc_html($cert['status']); ?></span>
                            </div>
                            <p class="apex-compliance__cert-desc"><?php echo esc_html($cert['description']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Security Features -->
                <div class="apex-compliance__features" data-animate="fade-up">
                    <h3 class="apex-compliance__features-title">Security Features</h3>
                    <div class="apex-compliance__features-grid">
                        <?php foreach ($args['security_features'] as $index => $feature) : ?>
                        <div class="apex-compliance__feature" data-delay="<?php echo $index * 50; ?>">
                            <div class="apex-compliance__feature-icon">
                                <?php echo $icons[$feature['icon']] ?? ''; ?>
                            </div>
                            <h4 class="apex-compliance__feature-title"><?php echo esc_html($feature['title']); ?></h4>
                            <p class="apex-compliance__feature-desc"><?php echo esc_html($feature['description']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- CTA -->
                <div class="apex-compliance__cta" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-compliance__cta-btn">
                        <?php echo $icons['download']; ?>
                        <?php echo esc_html($args['cta']['text']); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_Compliance_Component::get_instance();

// Helper function
function apex_render_compliance($args = []) {
    Apex_Compliance_Component::get_instance()->render($args);
}
