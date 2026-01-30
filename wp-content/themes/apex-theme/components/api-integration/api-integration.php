<?php
/**
 * API Integration Component
 * Showcase API connectivity and integration capabilities
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_APIIntegration_Component {
    
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
                'apex-api-integration-component',
                get_template_directory_uri() . '/components/api-integration/api-integration.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-api-integration-component',
                get_template_directory_uri() . '/components/api-integration/api-integration.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Developer Platform',
            'heading' => 'Powerful API & Integration Capabilities',
            'description' => 'Build custom solutions with our comprehensive REST APIs, webhooks, and SDKs. Connect ApexCore to your existing systems seamlessly.',
            'features' => [
                [
                    'icon' => 'code',
                    'title' => 'RESTful APIs',
                    'description' => 'Modern REST architecture with JSON responses, OAuth 2.0 authentication, and comprehensive endpoint coverage.'
                ],
                [
                    'icon' => 'webhook',
                    'title' => 'Real-time Webhooks',
                    'description' => 'Subscribe to events and receive instant notifications for transactions, account changes, and system alerts.'
                ],
                [
                    'icon' => 'sdk',
                    'title' => 'SDKs & Libraries',
                    'description' => 'Official SDKs for Python, Java, Node.js, PHP, and .NET with comprehensive documentation and examples.'
                ],
                [
                    'icon' => 'sandbox',
                    'title' => 'Sandbox Environment',
                    'description' => 'Full-featured test environment with mock data for development and integration testing.'
                ]
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/v2/accounts', 'description' => 'List all accounts'],
                ['method' => 'POST', 'path' => '/api/v2/transactions', 'description' => 'Create transaction'],
                ['method' => 'GET', 'path' => '/api/v2/customers/{id}', 'description' => 'Get customer details'],
                ['method' => 'PUT', 'path' => '/api/v2/loans/{id}/approve', 'description' => 'Approve loan application'],
                ['method' => 'GET', 'path' => '/api/v2/reports/balance', 'description' => 'Generate balance report']
            ],
            'stats' => [
                ['value' => '200+', 'label' => 'API Endpoints'],
                ['value' => '<50ms', 'label' => 'Avg Response'],
                ['value' => '99.99%', 'label' => 'API Uptime'],
                ['value' => '50M+', 'label' => 'Daily Calls']
            ],
            'cta' => [
                'primary' => [
                    'text' => 'View API Documentation',
                    'url' => home_url('/developers/api-docs')
                ],
                'secondary' => [
                    'text' => 'Get API Keys',
                    'url' => home_url('/developers/register')
                ]
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'code' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
            'webhook' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 16.98h-5.99c-1.1 0-1.95.94-2.48 1.9A4 4 0 0 1 2 17c.01-.7.2-1.4.57-2"/><path d="m6 17 3.13-5.78c.53-.97.1-2.18-.5-3.1a4 4 0 1 1 6.89-4.06"/><path d="m12 6 3.13 5.73C15.66 12.7 16.9 13 18 13a4 4 0 0 1 0 8H12"/></svg>',
            'sdk' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
            'sandbox' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
            'terminal' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>'
        ];
        ?>
        <section class="apex-api-integration" data-api-integration-section>
            <div class="apex-api-integration__container">
                <div class="apex-api-integration__grid">
                    <!-- Left Column - Info -->
                    <div class="apex-api-integration__info" data-animate="fade-right">
                        <span class="apex-api-integration__badge"><?php echo esc_html($args['badge']); ?></span>
                        <h2 class="apex-api-integration__heading"><?php echo esc_html($args['heading']); ?></h2>
                        <p class="apex-api-integration__description"><?php echo esc_html($args['description']); ?></p>
                        
                        <!-- Features -->
                        <div class="apex-api-integration__features">
                            <?php foreach ($args['features'] as $feature) : ?>
                            <div class="apex-api-integration__feature">
                                <div class="apex-api-integration__feature-icon">
                                    <?php echo $icons[$feature['icon']] ?? ''; ?>
                                </div>
                                <div class="apex-api-integration__feature-content">
                                    <h4 class="apex-api-integration__feature-title"><?php echo esc_html($feature['title']); ?></h4>
                                    <p class="apex-api-integration__feature-desc"><?php echo esc_html($feature['description']); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Stats -->
                        <div class="apex-api-integration__stats">
                            <?php foreach ($args['stats'] as $stat) : ?>
                            <div class="apex-api-integration__stat">
                                <span class="apex-api-integration__stat-value"><?php echo esc_html($stat['value']); ?></span>
                                <span class="apex-api-integration__stat-label"><?php echo esc_html($stat['label']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- CTAs -->
                        <div class="apex-api-integration__ctas">
                            <a href="<?php echo esc_url($args['cta']['primary']['url']); ?>" class="apex-api-integration__btn-primary">
                                <?php echo esc_html($args['cta']['primary']['text']); ?>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="<?php echo esc_url($args['cta']['secondary']['url']); ?>" class="apex-api-integration__btn-secondary">
                                <?php echo esc_html($args['cta']['secondary']['text']); ?>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right Column - Code Preview -->
                    <div class="apex-api-integration__preview" data-animate="fade-left">
                        <div class="apex-api-integration__terminal">
                            <div class="apex-api-integration__terminal-header">
                                <div class="apex-api-integration__terminal-dots">
                                    <span></span><span></span><span></span>
                                </div>
                                <span class="apex-api-integration__terminal-title">API Explorer</span>
                            </div>
                            <div class="apex-api-integration__terminal-body">
                                <div class="apex-api-integration__endpoints">
                                    <?php foreach ($args['endpoints'] as $endpoint) : ?>
                                    <div class="apex-api-integration__endpoint">
                                        <span class="apex-api-integration__method apex-api-integration__method--<?php echo strtolower($endpoint['method']); ?>">
                                            <?php echo esc_html($endpoint['method']); ?>
                                        </span>
                                        <code class="apex-api-integration__path"><?php echo esc_html($endpoint['path']); ?></code>
                                        <span class="apex-api-integration__endpoint-desc"><?php echo esc_html($endpoint['description']); ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="apex-api-integration__code-sample">
                                    <div class="apex-api-integration__code-header">
                                        <span>Example Request</span>
                                        <button type="button" class="apex-api-integration__copy-btn" data-copy-code>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                    <pre class="apex-api-integration__code"><code>curl -X GET "https://api.apexcore.io/v2/accounts" \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json"</code></pre>
                                </div>
                                
                                <div class="apex-api-integration__code-sample">
                                    <div class="apex-api-integration__code-header">
                                        <span>Response</span>
                                    </div>
                                    <pre class="apex-api-integration__code apex-api-integration__code--response"><code>{
  "data": [
    {
      "id": "acc_123456",
      "type": "savings",
      "balance": 150000.00,
      "currency": "KES",
      "status": "active"
    }
  ],
  "meta": { "total": 1, "page": 1 }
}</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_APIIntegration_Component::get_instance();

// Helper function
function apex_render_api_integration($args = []) {
    Apex_APIIntegration_Component::get_instance()->render($args);
}
