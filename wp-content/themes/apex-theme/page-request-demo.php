<?php 
/**
 * Template Name: Request Demo
 * Request Demo Page Template
 * 
 * @package ApexTheme
 */

get_header(); 

// Get hero section data from fallback form options
$hero_badge = get_option('apex_hero_badge_request-demo', 'Request Demo');
$hero_heading = get_option('apex_hero_heading_request-demo', 'See Our Platform in Action');
$hero_description = get_option('apex_hero_description_request-demo', 'Schedule a personalized demo of our fintech solutions and discover how we can help transform your financial institution.');
$hero_image = get_option('apex_hero_image_request-demo', 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200');
$hero_stats_raw = get_option('apex_hero_stats_request-demo', "500+ Demos Scheduled\n98% Satisfaction\n7 Days Avg. Implementation\n24/7 Support");

// Parse stats from "Value Label" format (one per line)
$hero_stats = [];
if (!empty($hero_stats_raw)) {
    $lines = array_filter(array_map('trim', explode("\n", $hero_stats_raw)));
    foreach ($lines as $line) {
        if (preg_match('/^(\S+)\s+(.+)$/', $line, $m)) {
            $hero_stats[] = ['value' => $m[1], 'label' => $m[2]];
        }
    }
}
if (empty($hero_stats)) {
    $hero_stats = [
        ['value' => '500+', 'label' => 'Demos Scheduled'],
        ['value' => '98%', 'label' => 'Satisfaction'],
        ['value' => '7 Days', 'label' => 'Avg. Implementation'],
        ['value' => '24/7', 'label' => 'Support']
    ];
}

// Page Hero
apex_render_about_hero([
    'badge' => $hero_badge,
    'heading' => $hero_heading,
    'description' => $hero_description,
    'stats' => $hero_stats,
    'image' => $hero_image
]);
?>

<section class="apex-request-demo">
    <div class="apex-request-demo__container">
        <div class="apex-request-demo__content">
            <div class="apex-request-demo__header">
                <?php
                // Get form section data
                $form_heading = get_option('apex_demo_form_heading_request-demo', 'Request Your Personalized Demo');
                $form_description = get_option('apex_demo_form_description_request-demo', 'Fill out the form below and our team will contact you within 24 hours to schedule your demo.');
                ?>
                <h2 class="apex-request-demo__heading"><?php echo esc_html($form_heading); ?></h2>
                <p class="apex-request-demo__description"><?php echo esc_html($form_description); ?></p>
            </div>
            
            <!-- Notification Area -->
            <div id="demo-notification" class="apex-request-demo__notification" style="display: none;">
                <div class="notification-content">
                    <span class="notification-icon"></span>
                    <span class="notification-message"></span>
                    <button type="button" class="notification-close" onclick="hideDemoNotification()">&times;</button>
                </div>
            </div>

            <form class="apex-request-demo__form" action="#" method="POST" enctype="multipart/form-data">
                <?php wp_nonce_field('apex_demo_request_form', 'apex_demo_nonce'); ?>
                <div class="apex-request-demo__form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" required placeholder="John">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" required placeholder="Doe">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="email">Work Email *</label>
                    <input type="email" id="email" name="email" required placeholder="john@company.com">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" required placeholder="+254 700 000 000">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="company">Company Name *</label>
                    <input type="text" id="company" name="company" required placeholder="Your Company">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="job_title">Job Title *</label>
                    <input type="text" id="job_title" name="job_title" required placeholder="CEO, IT Manager, etc.">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="institution_type">Institution Type *</label>
                    <select id="institution_type" name="institution_type" required>
                        <option value="">Select your institution type</option>
                        <option value="mfi">Microfinance Institution (MFI)</option>
                        <option value="sacco">SACCO / Credit Union</option>
                        <option value="bank">Commercial Bank</option>
                        <option value="government">Government Agency</option>
                        <option value="ngo">NGO / Development Organization</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="country">Country *</label>
                    <select id="country" name="country" required>
                        <option value="">Select your country</option>
                        <option value="ke">Kenya</option>
                        <option value="ug">Uganda</option>
                        <option value="tz">Tanzania</option>
                        <option value="ng">Nigeria</option>
                        <option value="gh">Ghana</option>
                        <option value="rw">Rwanda</option>
                        <option value="za">South Africa</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="solutions">Solutions of Interest *</label>
                    <div class="apex-request-demo__checkboxes">
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="core-banking">
                            <span>Core Banking & Microfinance</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="mobile-wallet">
                            <span>Mobile Wallet App</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="agency-banking">
                            <span>Agency & Branch Banking</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="internet-banking">
                            <span>Internet & Mobile Banking</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="loan-origination">
                            <span>Loan Origination & Workflows</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="digital-field-agent">
                            <span>Digital Field Agent</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="enterprise-integration">
                            <span>Enterprise Integration</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="payment-switch">
                            <span>Payment Switch & General Ledger</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="reporting-analytics">
                            <span>Reporting & Analytics</span>
                        </label>
                    </div>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="message">Tell us about your needs</label>
                    <textarea id="message" name="message" rows="4" placeholder="Describe your current challenges and what you're looking for..."></textarea>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="attachment">Attach Relevant Documents (Optional)</label>
                    <div class="apex-request-demo__dropzone" id="dropzone">
                        <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg" class="apex-request-demo__dropzone-input">
                        <div class="apex-request-demo__dropzone-content">
                            <div class="apex-request-demo__dropzone-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <p class="apex-request-demo__dropzone-text">
                                <span class="apex-request-demo__dropzone-cta">Click to upload</span> or drag and drop
                            </p>
                            <p class="apex-request-demo__dropzone-hint">PDF, Word, Excel, PowerPoint, Images (max 5MB)</p>
                        </div>
                        <div class="apex-request-demo__dropzone-preview" id="dropzone-preview" style="display: none;">
                            <div class="apex-request-demo__dropzone-file">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <span id="file-name"></span>
                                <button type="button" class="apex-request-demo__dropzone-remove" id="remove-file">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label class="apex-request-demo__checkbox">
                        <input type="checkbox" name="privacy" required>
                        <span>I agree to the <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a> and consent to being contacted.</span>
                    </label>
                </div>
                
                <button type="submit" class="apex-request-demo__submit">
                    <span>Request Demo</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>
        </div>
        
        <div class="apex-request-demo__sidebar">
            <?php
            // Get "What to Expect" data
            $what_to_expect_title = get_option('apex_demo_expect_title_request-demo', 'What to Expect');
            $what_to_expect_description = get_option('apex_demo_expect_description_request-demo', 'Learn what happens during your personalized demo session.');
            $what_to_expect_raw = get_option('apex_demo_expect_items_request-demo', "30-45 minute personalized demo\nDedicated product expert\nCustomized to your needs\nQ&A and discussion\nPricing and licensing information");
            $what_to_expect_items = array_filter(array_map('trim', explode("\n", $what_to_expect_raw)));
            ?>
            <div class="apex-request-demo__info">
                <h3><?php echo esc_html($what_to_expect_title); ?></h3>
                <p><?php echo esc_html($what_to_expect_description); ?></p>
                <ul>
                    <?php foreach ($what_to_expect_items as $item_text): ?>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                            <span><?php echo esc_html($item_text); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <!-- Privacy Policy Link -->
                <div class="apex-request-demo__materials-link">
                    <a href="http://apex.devops/privacy-policy" class="apex-request-demo__view-all-link" target="_blank">
                        <span>Privacy Policy</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17L17 7M17 7H7M17 7V17"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <?php
            // Get "Need Help" data
            $need_help_title = get_option('apex_demo_help_title_request-demo', 'Need Help?');
            $need_help_description = get_option('apex_demo_help_description_request-demo', 'Our team is ready to assist you.');
            $phone_number = get_option('apex_demo_phone_request-demo', '+254 700 000 000');
            $email_address = get_option('apex_demo_email_request-demo', 'sales@apex-softwares.com');
            ?>
            <div class="apex-request-demo__contact">
                <h3><?php echo esc_html($need_help_title); ?></h3>
                <p><?php echo esc_html($need_help_description); ?></p>
                <a href="tel:<?php echo esc_attr(str_replace([' ', '-'], '', $phone_number)); ?>" class="apex-request-demo__contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <?php echo esc_html($phone_number); ?>
                </a>
                <a href="mailto:<?php echo esc_attr($email_address); ?>" class="apex-request-demo__contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                    <?php echo esc_html($email_address); ?>
                </a>
            </div>
            
            <?php
            // Get Training Materials data
            $training_title = get_option('apex_demo_materials_title_request-demo', 'Training Materials');
            $training_description = get_option('apex_demo_materials_description_request-demo', 'Download our product presentations and documentation.');
            $training_materials_raw = get_option('apex_demo_materials_items_request-demo', "Product Overview Presentation | # | PDF • 2.5 MB\nTechnical Documentation | # | PDF • 5.1 MB\nImplementation Guide | # | PDF • 3.8 MB\nPricing & Licensing | # | PDF • 1.2 MB");
            
            // Helper function to get file type icon based on URL extension or size/description text
            function get_file_type_icon($file_url, $size_text = '') {
                // Try to detect type from URL extension first
                $type = '';
                if (!empty($file_url) && $file_url !== '#') {
                    $type = strtolower(pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION));
                }
                
                // Fallback: detect type from the size/description text (e.g. "PDF • 2.5 MB", "CSV • 1.8 MB")
                if (empty($type) && !empty($size_text)) {
                    $size_upper = strtoupper(trim($size_text));
                    $known_types = ['PDF','CSV','DOC','DOCX','XLS','XLSX','PPT','PPTX','JPG','JPEG','PNG','GIF','WEBP','SVG','ZIP','RAR','7Z','TXT','MP4','MP3'];
                    foreach ($known_types as $kt) {
                        if (strpos($size_upper, $kt) !== false) {
                            $type = strtolower($kt);
                            break;
                        }
                    }
                }

                // Map type to icon SVG
                $icons = [
                    'pdf' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FEE2E2" stroke="#EF4444" stroke-width="1.5"/><path d="M24 2v10h10" fill="#FECACA" stroke="#EF4444" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#EF4444" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#EF4444"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">PDF</text></svg>',

                    'doc' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#DBEAFE" stroke="#3B82F6" stroke-width="1.5"/><path d="M24 2v10h10" fill="#BFDBFE" stroke="#3B82F6" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#3B82F6" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#3B82F6"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">DOC</text></svg>',

                    'docx' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#DBEAFE" stroke="#3B82F6" stroke-width="1.5"/><path d="M24 2v10h10" fill="#BFDBFE" stroke="#3B82F6" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#3B82F6" stroke-width="1.5"/><rect x="6" y="22" width="28" height="12" rx="2" fill="#3B82F6"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">DOCX</text></svg>',

                    'xls' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/><path d="M24 2v10h10" fill="#A7F3D0" stroke="#10B981" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#10B981" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#10B981"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">XLS</text></svg>',

                    'xlsx' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/><path d="M24 2v10h10" fill="#A7F3D0" stroke="#10B981" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#10B981" stroke-width="1.5"/><rect x="6" y="22" width="28" height="12" rx="2" fill="#10B981"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">XLSX</text></svg>',

                    'csv' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#D1FAE5" stroke="#059669" stroke-width="1.5"/><path d="M24 2v10h10" fill="#A7F3D0" stroke="#059669" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#059669" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#059669"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">CSV</text></svg>',

                    'ppt' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FFE4E6" stroke="#F97316" stroke-width="1.5"/><path d="M24 2v10h10" fill="#FED7AA" stroke="#F97316" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#F97316" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#F97316"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">PPT</text></svg>',

                    'pptx' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FFE4E6" stroke="#F97316" stroke-width="1.5"/><path d="M24 2v10h10" fill="#FED7AA" stroke="#F97316" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#F97316" stroke-width="1.5"/><rect x="6" y="22" width="28" height="12" rx="2" fill="#F97316"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">PPTX</text></svg>',

                    'jpg' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#EDE9FE" stroke="#8B5CF6" stroke-width="1.5"/><circle cx="15" cy="14" r="3" fill="#C4B5FD" stroke="#8B5CF6" stroke-width="1"/><path d="M4 28l8-8 6 6 4-4 12 10" fill="#C4B5FD" stroke="#8B5CF6" stroke-width="1"/><rect x="8" y="26" width="24" height="10" rx="2" fill="#8B5CF6"/><text x="20" y="34" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">JPG</text></svg>',

                    'jpeg' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#EDE9FE" stroke="#8B5CF6" stroke-width="1.5"/><circle cx="15" cy="14" r="3" fill="#C4B5FD" stroke="#8B5CF6" stroke-width="1"/><path d="M4 28l8-8 6 6 4-4 12 10" fill="#C4B5FD" stroke="#8B5CF6" stroke-width="1"/><rect x="6" y="26" width="28" height="10" rx="2" fill="#8B5CF6"/><text x="20" y="34" text-anchor="middle" fill="white" font-size="6" font-weight="700" font-family="Arial,sans-serif">JPEG</text></svg>',

                    'png' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#EDE9FE" stroke="#7C3AED" stroke-width="1.5"/><circle cx="15" cy="14" r="3" fill="#C4B5FD" stroke="#7C3AED" stroke-width="1"/><path d="M4 28l8-8 6 6 4-4 12 10" fill="#C4B5FD" stroke="#7C3AED" stroke-width="1"/><rect x="8" y="26" width="24" height="10" rx="2" fill="#7C3AED"/><text x="20" y="34" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">PNG</text></svg>',

                    'gif' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#EDE9FE" stroke="#A855F7" stroke-width="1.5"/><circle cx="15" cy="14" r="3" fill="#C4B5FD" stroke="#A855F7" stroke-width="1"/><path d="M4 28l8-8 6 6 4-4 12 10" fill="#C4B5FD" stroke="#A855F7" stroke-width="1"/><rect x="8" y="26" width="24" height="10" rx="2" fill="#A855F7"/><text x="20" y="34" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">GIF</text></svg>',

                    'webp' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#EDE9FE" stroke="#6D28D9" stroke-width="1.5"/><circle cx="15" cy="14" r="3" fill="#C4B5FD" stroke="#6D28D9" stroke-width="1"/><path d="M4 28l8-8 6 6 4-4 12 10" fill="#C4B5FD" stroke="#6D28D9" stroke-width="1"/><rect x="6" y="26" width="28" height="10" rx="2" fill="#6D28D9"/><text x="20" y="34" text-anchor="middle" fill="white" font-size="6" font-weight="700" font-family="Arial,sans-serif">WEBP</text></svg>',

                    'svg' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FEF3C7" stroke="#F59E0B" stroke-width="1.5"/><circle cx="15" cy="14" r="3" fill="#FDE68A" stroke="#F59E0B" stroke-width="1"/><path d="M4 28l8-8 6 6 4-4 12 10" fill="#FDE68A" stroke="#F59E0B" stroke-width="1"/><rect x="8" y="26" width="24" height="10" rx="2" fill="#F59E0B"/><text x="20" y="34" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">SVG</text></svg>',

                    'zip' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#F3F4F6" stroke="#6B7280" stroke-width="1.5"/><path d="M24 2v10h10" fill="#E5E7EB" stroke="#6B7280" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#6B7280" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#6B7280"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">ZIP</text></svg>',

                    'rar' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#F3F4F6" stroke="#6B7280" stroke-width="1.5"/><path d="M24 2v10h10" fill="#E5E7EB" stroke="#6B7280" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#6B7280" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#6B7280"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">RAR</text></svg>',

                    'txt' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#F3F4F6" stroke="#9CA3AF" stroke-width="1.5"/><path d="M24 2v10h10" fill="#E5E7EB" stroke="#9CA3AF" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#9CA3AF" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#9CA3AF"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="8" font-weight="700" font-family="Arial,sans-serif">TXT</text></svg>',

                    'mp4' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FCE7F3" stroke="#EC4899" stroke-width="1.5"/><path d="M24 2v10h10" fill="#FBCFE8" stroke="#EC4899" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#EC4899" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#EC4899"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">MP4</text></svg>',

                    'mp3' => '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FEF3C7" stroke="#D97706" stroke-width="1.5"/><path d="M24 2v10h10" fill="#FDE68A" stroke="#D97706" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#D97706" stroke-width="1.5"/><rect x="8" y="22" width="24" height="12" rx="2" fill="#D97706"/><text x="20" y="31.5" text-anchor="middle" fill="white" font-size="7" font-weight="700" font-family="Arial,sans-serif">MP3</text></svg>',
                ];

                if (!empty($type) && isset($icons[$type])) {
                    return $icons[$type];
                }

                // Default generic file icon
                return '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="2" width="32" height="36" rx="3" fill="#FFF7ED" stroke="#F97316" stroke-width="1.5"/><path d="M24 2v10h10" fill="#FFEDD5" stroke="#F97316" stroke-width="1.5"/><path d="M24 2L34 12" stroke="#F97316" stroke-width="1.5"/><line x1="10" y1="18" x2="24" y2="18" stroke="#F97316" stroke-width="1.5"/><line x1="10" y1="23" x2="30" y2="23" stroke="#F97316" stroke-width="1.5"/><line x1="10" y1="28" x2="26" y2="28" stroke="#F97316" stroke-width="1.5"/></svg>';
            }

            // Parse materials from "Title | URL | Size" format
            $training_materials = [];
            if (!empty($training_materials_raw)) {
                $lines = array_filter(array_map('trim', explode("\n", $training_materials_raw)));
                foreach ($lines as $line) {
                    $parts = array_map('trim', explode('|', $line));
                    if (count($parts) >= 3) {
                        $training_materials[] = [
                            'title' => $parts[0],
                            'file' => $parts[1],
                            'size' => $parts[2]
                        ];
                    }
                }
            }
            ?>
            <div class="apex-request-demo__downloads">
                <h3><?php echo esc_html($training_title); ?></h3>
                <p><?php echo esc_html($training_description); ?></p>
                <div class="apex-request-demo__downloads-list">
                    <?php foreach ($training_materials as $material): ?>
                        <a href="<?php echo esc_url($material['file']); ?>" class="apex-request-demo__download-item" <?php echo ($material['file'] !== '#') ? 'target="_blank"' : ''; ?>>
                            <div class="apex-request-demo__download-icon">
                                <?php echo get_file_type_icon($material['file'], $material['size']); ?>
                            </div>
                            <div class="apex-request-demo__download-content">
                                <h4><?php echo esc_html($material['title']); ?></h4>
                                <span><?php echo esc_html($material['size']); ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <!-- Whitepapers Link -->
                <div class="apex-request-demo__materials-link">
                    <a href="http://apex.devops/insights/whitepapers-reports" class="apex-request-demo__view-all-link" target="_blank">
                        <span>View All Whitepapers & Reports</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17L17 7M17 7H7M17 7V17"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <?php
            // Get Webinars data
            $webinars_title = get_option('apex_demo_webinars_title_request-demo', 'Upcoming Webinars');
            $webinars_description = get_option('apex_demo_webinars_description_request-demo', 'Join our live demo sessions and Q&A.');
            $webinars_raw = get_option('apex_demo_webinars_items_request-demo', "15 | Feb | Core Banking Demo | 10:00 AM EAT | #\n22 | Feb | Mobile Banking Demo | 2:00 PM EAT | #\n01 | Mar | Agent Banking Demo | 10:00 AM EAT | #");
            
            // Parse webinars from "Day | Month | Title | Time | Link" format
            $webinar_sessions = [];
            if (!empty($webinars_raw)) {
                $lines = array_filter(array_map('trim', explode("\n", $webinars_raw)));
                foreach ($lines as $line) {
                    $parts = array_map('trim', explode('|', $line));
                    if (count($parts) >= 5) {
                        $webinar_sessions[] = [
                            'day' => $parts[0],
                            'month' => $parts[1],
                            'title' => $parts[2],
                            'time' => $parts[3],
                            'link' => $parts[4]
                        ];
                    }
                }
            }
            ?>
            <div class="apex-request-demo__webinars">
                <h3><?php echo esc_html($webinars_title); ?></h3>
                <p><?php echo esc_html($webinars_description); ?></p>
                <div class="apex-request-demo__webinars-list">
                    <?php foreach ($webinar_sessions as $session): ?>
                        <div class="apex-request-demo__webinar">
                            <div class="apex-request-demo__webinar-date">
                                <span class="apex-request-demo__webinar-day"><?php echo esc_html($session['day']); ?></span>
                                <span class="apex-request-demo__webinar-month"><?php echo esc_html($session['month']); ?></span>
                            </div>
                            <div class="apex-request-demo__webinar-content">
                                <h4><?php echo esc_html($session['title']); ?></h4>
                                <span><?php echo esc_html($session['time']); ?></span>
                                <a href="<?php echo esc_url($session['link']); ?>" class="apex-request-demo__webinar-cta" <?php echo ($session['link'] !== '#') ? 'target="_blank"' : ''; ?>>Register →</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Webinars Link -->
                <div class="apex-request-demo__materials-link">
                    <a href="http://apex.devops/insights/webinars" class="apex-request-demo__view-all-link" target="_blank">
                        <span>View All Webinars</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17L17 7M17 7H7M17 7V17"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Demo Form Notification Styles -->
<style>
.apex-request-demo__notification {
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
    animation: demoSlideDown 0.3s ease-out;
}
.apex-request-demo__notification.success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}
.apex-request-demo__notification.error {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
    color: white;
}
.apex-request-demo__notification .notification-content {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    gap: 10px;
}
.apex-request-demo__notification .notification-icon {
    font-size: 18px;
    flex-shrink: 0;
}
.apex-request-demo__notification.success .notification-icon::before {
    content: "\2713";
    font-weight: bold;
}
.apex-request-demo__notification.error .notification-icon::before {
    content: "\2715";
    font-weight: bold;
}
.apex-request-demo__notification .notification-message {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
}
.apex-request-demo__notification .notification-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
    flex-shrink: 0;
}
.apex-request-demo__notification .notification-close:hover {
    background: rgba(255, 255, 255, 0.3);
}
@keyframes demoSlideDown {
    from { opacity: 0; transform: translateY(-10px); max-height: 0; }
    to { opacity: 1; transform: translateY(0); max-height: 100px; }
}
.apex-request-demo__form.loading .apex-request-demo__submit {
    opacity: 0.7;
    pointer-events: none;
}
.apex-request-demo__form.loading .apex-request-demo__submit svg {
    animation: demoSpin 1s linear infinite;
}
@keyframes demoSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Whitepapers Link Styles */
.apex-request-demo__materials-link {
    margin-top: 20px;
    text-align: right;
}
.apex-request-demo__view-all-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #FF6200;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}
.apex-request-demo__view-all-link:hover {
    color: #ea580c;
    transform: translateX(2px);
}
.apex-request-demo__view-all-link svg {
    width: 16px;
    height: 16px;
    transition: transform 0.2s ease;
}
.apex-request-demo__view-all-link:hover svg {
    transform: scale(1.1);
}

/* What to Expect description styling */
.apex-request-demo__info p {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0 0 1.5rem 0;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const demoForm = document.querySelector('.apex-request-demo__form');
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('attachment');
    const dropzoneContent = document.querySelector('.apex-request-demo__dropzone-content');
    const dropzonePreview = document.getElementById('dropzone-preview');
    const fileNameEl = document.getElementById('file-name');
    const removeBtn = document.getElementById('remove-file');

    // --- File Upload / Dropzone ---
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    const ALLOWED_EXTENSIONS = ['pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg'];

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function(e) { e.preventDefault(); e.stopPropagation(); }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function() { dropzone.classList.add('dragover'); }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function() { dropzone.classList.remove('dragover'); }, false);
    });

    dropzone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            if (validateFile(files[0])) {
                fileInput.files = files;
                showFilePreview(files[0]);
            }
        }
    }, false);

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            if (validateFile(this.files[0])) {
                showFilePreview(this.files[0]);
            } else {
                this.value = '';
            }
        }
    });

    function validateFile(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        if (!ALLOWED_EXTENSIONS.includes(ext)) {
            showDemoNotification('error', 'Invalid file type. Allowed: PDF, Word, Excel, PowerPoint, PNG, JPG.');
            return false;
        }
        if (file.size > MAX_FILE_SIZE) {
            showDemoNotification('error', 'File is too large. Maximum size is 5MB.');
            return false;
        }
        return true;
    }

    function showFilePreview(file) {
        dropzoneContent.style.display = 'none';
        dropzonePreview.style.display = 'flex';
        fileNameEl.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
    }

    removeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileInput.value = '';
        dropzoneContent.style.display = 'block';
        dropzonePreview.style.display = 'none';
    });

    // --- Form Submission via AJAX ---
    if (demoForm) {
        demoForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Client-side validation for solutions checkboxes
            const solutionsChecked = demoForm.querySelectorAll('input[name="solutions[]"]:checked');
            if (solutionsChecked.length === 0) {
                showDemoNotification('error', 'Please select at least one solution of interest.');
                return;
            }

            // Re-validate file if one is attached
            if (fileInput.files.length > 0 && !validateFile(fileInput.files[0])) {
                return;
            }

            // Show loading state
            demoForm.classList.add('loading');
            const submitBtn = demoForm.querySelector('.apex-request-demo__submit');
            const originalBtnHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Submitting...</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>';

            // Build FormData (includes file automatically)
            const formData = new FormData(demoForm);
            formData.append('action', 'apex_demo_request_submit');

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                demoForm.classList.remove('loading');
                submitBtn.innerHTML = originalBtnHTML;

                if (data.success) {
                    showDemoNotification('success', data.data.message);
                    demoForm.reset();
                    // Reset file preview
                    dropzoneContent.style.display = 'block';
                    dropzonePreview.style.display = 'none';
                    // Scroll to notification
                    document.getElementById('demo-notification').scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    showDemoNotification('error', data.data.message || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                demoForm.classList.remove('loading');
                submitBtn.innerHTML = originalBtnHTML;
                showDemoNotification('error', 'An error occurred. Please try again.');
                console.error('Demo request submission error:', error);
            });
        });
    }
});

function showDemoNotification(type, message) {
    const notification = document.getElementById('demo-notification');
    const messageEl = notification.querySelector('.notification-message');
    notification.classList.remove('success', 'error');
    notification.classList.add(type);
    messageEl.textContent = message;
    notification.style.display = 'block';

    if (type === 'success') {
        setTimeout(hideDemoNotification, 8000);
    }
}

function hideDemoNotification() {
    const notification = document.getElementById('demo-notification');
    notification.style.display = 'none';
}
</script>

<?php get_footer(); ?>
