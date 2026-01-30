<?php 
/**
 * Template Name: Solutions Core Banking
 * Core Banking & Microfinance Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Core Banking & Microfinance',
    'heading' => 'The Foundation of Your Digital Banking',
    'description' => 'A modern, cloud-native core banking system designed for African financial institutions. Handle millions of transactions with enterprise-grade reliability and flexibility.',
    'stats' => [
        ['value' => '100+', 'label' => 'Institutions'],
        ['value' => '10M+', 'label' => 'Accounts'],
        ['value' => '99.99%', 'label' => 'Uptime'],
        ['value' => '<100ms', 'label' => 'Response Time']
    ],
    'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Everything You Need in a Core Banking System</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <h3>Account Management</h3>
                <p>Flexible account structures supporting savings, current, fixed deposits, and custom account types with configurable interest calculations.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Transaction Processing</h3>
                <p>Real-time transaction processing with support for deposits, withdrawals, transfers, and complex multi-leg transactions.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Loan Management</h3>
                <p>Complete loan lifecycle management from origination to settlement with support for multiple loan products and repayment schedules.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>End-of-Day Processing</h3>
                <p>Automated EOD processing for interest accrual, fee charges, and account maintenance with detailed audit trails.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Customer Management</h3>
                <p>360-degree customer view with KYC management, document storage, and relationship tracking.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Security & Compliance</h3>
                <p>Role-based access control, maker-checker workflows, and comprehensive audit logging for regulatory compliance.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-solution-specs">
    <div class="apex-solution-specs__container">
        <div class="apex-solution-specs__content">
            <span class="apex-solution-specs__badge">Technical Specifications</span>
            <h2 class="apex-solution-specs__heading">Built for Scale and Performance</h2>
            
            <div class="apex-solution-specs__list">
                <div class="apex-solution-specs__item">
                    <h4>Architecture</h4>
                    <p>Cloud-native microservices architecture with horizontal scaling capabilities</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Database</h4>
                    <p>PostgreSQL with read replicas for high availability and performance</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>API</h4>
                    <p>RESTful APIs with OpenAPI documentation for easy integration</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Security</h4>
                    <p>TLS 1.3, AES-256 encryption, OAuth 2.0, and PCI-DSS compliance</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Deployment</h4>
                    <p>On-premise, private cloud, or fully managed SaaS options available</p>
                </div>
            </div>
        </div>
        <div class="apex-solution-specs__image">
            <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600" alt="Server Infrastructure" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
