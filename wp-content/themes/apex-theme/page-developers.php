<?php 
/**
 * Template Name: Developers
 * Developers Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Developers',
    'heading' => 'Build with Our APIs',
    'description' => 'Integrate our powerful APIs to build custom solutions. Comprehensive documentation, SDKs, and developer tools to help you succeed.',
    'stats' => [
        ['value' => '50+', 'label' => 'API Endpoints'],
        ['value' => '5', 'label' => 'SDKs Available'],
        ['value' => '99.9%', 'label' => 'Uptime SLA'],
        ['value' => '24/7', 'label' => 'API Support']
    ],
    'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200'
]);
?>

<section class="apex-dev-apis">
    <div class="apex-dev-apis__container">
        <div class="apex-dev-apis__header">
            <h2 class="apex-dev-apis__heading">Our APIs</h2>
            <p class="apex-dev-apis__description">RESTful APIs designed for developers</p>
        </div>
        
        <div class="apex-dev-apis__grid">
            <div class="apex-dev-apis__item">
                <div class="apex-dev-apis__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <h3>Core Banking API</h3>
                <p>Full access to core banking functionality including accounts, transactions, loans, and customer management.</p>
                <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
            </div>
            
            <div class="apex-dev-apis__item">
                <div class="apex-dev-apis__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                </div>
                <h3>Mobile Banking API</h3>
                <p>Build custom mobile apps with our comprehensive mobile banking API for iOS and Android.</p>
                <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
            </div>
            
            <div class="apex-dev-apis__item">
                <div class="apex-dev-apis__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Agent Banking API</h3>
                <p>Manage agent networks, process transactions, and monitor agent performance programmatically.</p>
                <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
            </div>
            
            <div class="apex-dev-apis__item">
                <div class="apex-dev-apis__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Authentication API</h3>
                <p>Secure authentication and authorization with OAuth 2.0 and JWT token support.</p>
                <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
            </div>
            
            <div class="apex-dev-apis__item">
                <div class="apex-dev-apis__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <h3>Webhooks API</h3>
                <p>Subscribe to real-time events and build automated workflows with our webhook system.</p>
                <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
            </div>
            
            <div class="apex-dev-apis__item">
                <div class="apex-dev-apis__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Reports API</h3>
                <p>Generate custom reports, export data, and access analytics programmatically.</p>
                <a href="#" class="apex-dev-apis__item-link">View Documentation →</a>
            </div>
        </div>
    </div>
</section>

<section class="apex-dev-sdks">
    <div class="apex-dev-sdks__container">
        <div class="apex-dev-sdks__header">
            <h2 class="apex-dev-sdks__heading">Official SDKs</h2>
            <p class="apex-dev-sdks__description">Get started quickly with our official SDKs</p>
        </div>
        
        <div class="apex-dev-sdks__grid">
            <div class="apex-dev-sdks__item">
                <div class="apex-dev-sdks__item-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <h3>JavaScript SDK</h3>
                <p>For web applications and Node.js backend development</p>
                <code>npm install @apex-softwares/sdk</code>
                <a href="#" class="apex-dev-sdks__item-link">Get Started →</a>
            </div>
            
            <div class="apex-dev-sdks__item">
                <div class="apex-dev-sdks__item-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <h3>Python SDK</h3>
                <p>For Python applications and Django integration</p>
                <code>pip install apex-softwares-sdk</code>
                <a href="#" class="apex-dev-sdks__item-link">Get Started →</a>
            </div>
            
            <div class="apex-dev-sdks__item">
                <div class="apex-dev-sdks__item-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <h3>PHP SDK</h3>
                <p>For PHP applications and Laravel integration</p>
                <code>composer require apex-softwares/sdk</code>
                <a href="#" class="apex-dev-sdks__item-link">Get Started →</a>
            </div>
            
            <div class="apex-dev-sdks__item">
                <div class="apex-dev-sdks__item-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <h3>Java SDK</h3>
                <p>For Java applications and Spring Boot integration</p>
                <code>implementation 'com.apex:sdk'</code>
                <a href="#" class="apex-dev-sdks__item-link">Get Started →</a>
            </div>
            
            <div class="apex-dev-sdks__item">
                <div class="apex-dev-sdks__item-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <h3>Go SDK</h3>
                <p>For Go applications and microservices</p>
                <code>go get github.com/apex-softwares/sdk</code>
                <a href="#" class="apex-dev-sdks__item-link">Get Started →</a>
            </div>
        </div>
    </div>
</section>

<section class="apex-dev-getting-started">
    <div class="apex-dev-getting-started__container">
        <div class="apex-dev-getting-started__header">
            <h2 class="apex-dev-getting-started__heading">Quick Start</h2>
            <p class="apex-dev-getting-started__description">Get up and running in minutes</p>
        </div>
        
        <div class="apex-dev-getting-started__steps">
            <div class="apex-dev-getting-started__step">
                <div class="apex-dev-getting-started__step-number">1</div>
                <h3>Create an Account</h3>
                <p>Sign up for a developer account to get your API credentials</p>
            </div>
            
            <div class="apex-dev-getting-started__step">
                <div class="apex-dev-getting-started__step-number">2</div>
                <h3>Get Your API Keys</h3>
                <p>Generate API keys from your developer dashboard</p>
            </div>
            
            <div class="apex-dev-getting-started__step">
                <div class="apex-dev-getting-started__step-number">3</div>
                <h3>Install an SDK</h3>
                <p>Install our SDK for your preferred programming language</p>
            </div>
            
            <div class="apex-dev-getting-started__step">
                <div class="apex-dev-getting-started__step-number">4</div>
                <h3>Make Your First Call</h3>
                <p>Start making API calls with our quick start examples</p>
            </div>
        </div>
        
        <div class="apex-dev-getting-started__code">
            <pre><code>// Install SDK
npm install @apex-softwares/sdk

// Initialize
const Apex = require('@apex-softwares/sdk');
const client = new Apex({
  apiKey: 'your-api-key',
  environment: 'sandbox'
});

// Make your first call
const accounts = await client.accounts.list();
console.log(accounts);</code></pre>
        </div>
    </div>
</section>

<section class="apex-dev-support">
    <div class="apex-dev-support__container">
        <div class="apex-dev-support__header">
            <h2 class="apex-dev-support__heading">Developer Support</h2>
            <p class="apex-dev-support__description">We're here to help you succeed</p>
        </div>
        
        <div class="apex-dev-support__grid">
            <div class="apex-dev-support__item">
                <h3>Documentation</h3>
                <p>Comprehensive API documentation with examples and use cases</p>
                <a href="#" class="apex-dev-support__link">Read Docs →</a>
            </div>
            
            <div class="apex-dev-support__item">
                <h3>Community Forum</h3>
                <p>Connect with other developers and share solutions</p>
                <a href="#" class="apex-dev-support__link">Join Forum →</a>
            </div>
            
            <div class="apex-dev-support__item">
                <h3>GitHub</h3>
                <p>Open source SDKs, examples, and integration templates</p>
                <a href="#" class="apex-dev-support__link">View on GitHub →</a>
            </div>
            
            <div class="apex-dev-support__item">
                <h3>Contact Support</h3>
                <p>Direct access to our developer support team</p>
                <a href="#" class="apex-dev-support__link">Get Help →</a>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>
