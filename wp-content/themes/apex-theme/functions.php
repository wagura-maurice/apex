<?php

/**
 * Load modular component system
 */
require_once get_template_directory() . '/components/component-loader.php';

/**
 * Load ACF field definitions
 */
require_once get_template_directory() . '/inc/acf-about-us-overview.php';

/**
 * Configure Mailtrap for email delivery in development
 */
function apex_mailtrap_config($phpmailer) {
    // Debug: Log that Mailtrap config is being applied
    error_log('Apex Mailtrap: Applying SMTP configuration');

    // Force SMTP mode and clear any existing mailer settings
    $phpmailer->isSMTP();
    $phpmailer->Mailer = 'smtp';

    // Mailtrap SMTP settings
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'be6e87f82be3a7';
    $phpmailer->Password = '2b1dadf3db173f';
    $phpmailer->SMTPSecure = ''; // No encryption for Mailtrap sandbox

    // Force authentication
    $phpmailer->SMTPAuth = true;

    // Enable SMTP debugging
    $phpmailer->SMTPDebug = 2;
    $phpmailer->Debugoutput = function($str, $level) {
        error_log("Apex Mailtrap SMTP Debug [{$level}]: {$str}");
    };

    // Clear any sendmail path that might be set
    ini_set('sendmail_path', '');

    error_log('Apex Mailtrap: SMTP configuration applied - Host: ' . $phpmailer->Host . ', Port: ' . $phpmailer->Port . ', Secure: ' . $phpmailer->SMTPSecure);
}
add_action('phpmailer_init', 'apex_mailtrap_config', 999); // High priority to override other configs

/**
 * Handle contact form submission
 */
function apex_handle_contact_form_submission() {
    // Debug: Log all requests to contact page
    $current_url = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($current_url, 'contact') !== false) {
        error_log('Apex Contact Form: Contact page accessed - Method: ' . $_SERVER['REQUEST_METHOD']);
        error_log('Apex Contact Form: POST data: ' . print_r($_POST, true));
    }
    
    // Check if it's a POST request and our form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'])) {

        // Debug: Log that we reached the handler
        error_log('Apex Contact Form: Form submission detected - PROCESSING');

        // Verify nonce for security
        if (!isset($_POST['apex_contact_nonce']) || !wp_verify_nonce($_POST['apex_contact_nonce'], 'apex_contact_form')) {
            error_log('Apex Contact Form: Nonce verification failed');
            wp_die('Security check failed!');
        }

        // Sanitize and validate form data
        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name = sanitize_text_field($_POST['last_name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $company = sanitize_text_field($_POST['company'] ?? '');
        $institution_type = sanitize_text_field($_POST['institution_type'] ?? '');
        $interest = sanitize_text_field($_POST['interest'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');
        $consent = isset($_POST['consent']) ? true : false;

        error_log("Apex Contact Form: Processing submission from {$first_name} {$last_name} <{$email}>");

        // Basic validation
        if (empty($first_name) || empty($last_name) || empty($email) || empty($message) || !$consent) {
            error_log('Apex Contact Form: Validation failed - missing required fields');
            wp_redirect(home_url('/contact?error=missing_fields'));
            exit;
        }

        if (!is_email($email)) {
            error_log('Apex Contact Form: Invalid email address: ' . $email);
            wp_redirect(home_url('/contact?error=invalid_email'));
            exit;
        }

        // Send email using direct PHPMailer to bypass MailHog
        error_log('Apex Contact Form: Attempting to send email via direct PHPMailer');
        
        $email_sent = apex_send_email_direct([
            'to' => 'info@apex-softwares.com',
            'subject' => 'New Contact Form Submission from ' . $first_name . ' ' . $last_name,
            'html_content' => apex_create_contact_email_html([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'company' => $company,
                'institution_type' => $institution_type,
                'interest' => $interest,
                'message' => $message,
                'submission_date' => current_time('F j, Y, g:i a')
            ])
        ]);

        error_log('Apex Contact Form: Direct email sending result: ' . ($email_sent ? 'SUCCESS' : 'FAILED'));

        if ($email_sent) {
            error_log('Apex Contact Form: Email sent successfully');
            wp_redirect(home_url('/contact?success=1'));
        } else {
            error_log('Apex Contact Form: Email sending failed');
            wp_redirect(home_url('/contact?error=send_failed'));
        }
        exit;
    }
}
add_action('init', 'apex_handle_contact_form_submission');

// Include PHPMailer classes at global scope
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Send email using direct PHPMailer to bypass MailHog
 */
function apex_send_email_direct($args) {
    // Include PHPMailer directly
    require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
    require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
    require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // No debug output in production
        $mail->isSMTP();
        $mail->Mailer = 'smtp';
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'be6e87f82be3a7';
        $mail->Password   = '2b1dadf3db173f';
        $mail->SMTPSecure = ''; // No encryption for Mailtrap
        $mail->Port       = 2525;

        // Clear any sendmail path
        ini_set('sendmail_path', '');

        // Recipients
        $mail->setFrom('contact@apex-softwares.com', 'Apex Contact Form');
        $mail->addAddress($args['to'], 'Apex Softwares');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $args['subject'];
        $mail->Body    = $args['html_content'];
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $args['html_content']));

        error_log('Apex Direct Email: Attempting to send email to ' . $args['to']);

        $result = $mail->send();

        if ($result) {
            error_log('Apex Direct Email: Email sent successfully');
            return true;
        } else {
            error_log('Apex Direct Email: Email sending failed - ' . $mail->ErrorInfo);
            return false;
        }

    } catch (Exception $e) {
        error_log('Apex Direct Email: Exception - ' . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Create HTML email template for contact form submissions
 */
function apex_create_contact_email_html($data) {
    $institution_types = [
        'sacco' => 'SACCO / Credit Union',
        'mfi' => 'Microfinance Institution',
        'bank' => 'Commercial Bank',
        'fintech' => 'Fintech Company',
        'ngo' => 'NGO / Development Organization',
        'government' => 'Government Agency',
        'other' => 'Other'
    ];
    
    $interests = [
        'demo' => 'Requesting a Demo',
        'pricing' => 'Pricing Information',
        'partnership' => 'Partnership Opportunities',
        'support' => 'Technical Support',
        'careers' => 'Career Opportunities',
        'general' => 'General Inquiry'
    ];
    
    $institution_label = $institution_types[$data['institution_type']] ?? 'Not specified';
    $interest_label = $interests[$data['interest']] ?? 'Not specified';
    
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Contact Form Submission</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f8fafc;
            }
            .header {
                background: linear-gradient(135deg, #FF6200 0%, #ea580c 100%);
                color: white;
                padding: 30px;
                text-align: center;
                border-radius: 12px 12px 0 0;
            }
            .header h1 {
                margin: 0;
                font-size: 28px;
                font-weight: 700;
            }
            .header p {
                margin: 10px 0 0 0;
                opacity: 0.9;
                font-size: 16px;
            }
            .content {
                background: white;
                padding: 40px;
                border-radius: 0 0 12px 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .field-group {
                margin-bottom: 25px;
                padding-bottom: 25px;
                border-bottom: 1px solid #e2e8f0;
            }
            .field-group:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            .field-label {
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 5px;
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .field-value {
                color: #475569;
                font-size: 16px;
                margin: 0;
            }
            .field-value strong {
                color: #1e293b;
                font-weight: 600;
            }
            .message-box {
                background: #f8fafc;
                padding: 20px;
                border-radius: 8px;
                border-left: 4px solid #FF6200;
                margin-top: 10px;
            }
            .footer {
                text-align: center;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #e2e8f0;
                color: #64748b;
                font-size: 14px;
            }
            .logo {
                font-size: 24px;
                font-weight: 700;
                color: white;
                margin-bottom: 5px;
            }
            .priority-badge {
                display: inline-block;
                background: #10b981;
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                margin-left: 10px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">🏦 Apex Softwares</div>
            <h1>New Contact Form Submission</h1>
            <p>A potential client has reached out through your website</p>
        </div>
        
        <div class="content">
            <div class="field-group">
                <div class="field-label">Contact Information</div>
                <p class="field-value"><strong>Name:</strong> <?php echo esc_html($data['first_name'] . ' ' . $data['last_name']); ?></p>
                <p class="field-value"><strong>Email:</strong> <?php echo esc_html($data['email']); ?></p>
                <?php if (!empty($data['phone'])): ?>
                <p class="field-value"><strong>Phone:</strong> <?php echo esc_html($data['phone']); ?></p>
                <?php endif; ?>
                <?php if (!empty($data['company'])): ?>
                <p class="field-value"><strong>Company:</strong> <?php echo esc_html($data['company']); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="field-group">
                <div class="field-label">Institution Details</div>
                <p class="field-value"><strong>Institution Type:</strong> <?php echo esc_html($institution_label); ?></p>
                <p class="field-value"><strong>Interest Area:</strong> <?php echo esc_html($interest_label); ?></p>
            </div>
            
            <div class="field-group">
                <div class="field-label">Message</div>
                <div class="message-box">
                    <p class="field-value"><?php echo nl2br(esc_html($data['message'])); ?></p>
                </div>
            </div>
            
            <div class="field-group">
                <div class="field-label">Submission Details</div>
                <p class="field-value"><strong>Submitted:</strong> <?php echo esc_html($data['submission_date']); ?></p>
                <p class="field-value"><strong>Source:</strong> Apex Website Contact Form</p>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was sent from the Apex Softwares website contact form.</p>
            <p>Please respond to the inquiry within 24 hours.</p>
        </div>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

/**
 * Add contact form processing to the contact page
 */
function apex_add_contact_form_processing() {
    // Only add to contact page
    if (is_page('contact') || (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'contact') !== false)) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.querySelector('.apex-contact-main__form');
            if (contactForm) {
                console.log('Apex Contact Form: Form found, adding processing');
                
                // Add nonce field immediately
                const nonceField = document.createElement('input');
                nonceField.type = 'hidden';
                nonceField.name = 'apex_contact_nonce';
                nonceField.value = '<?php echo wp_create_nonce('apex_contact_form'); ?>';
                contactForm.appendChild(nonceField);
                console.log('Apex Contact Form: Nonce field added');

                // Handle form submission
                contactForm.addEventListener('submit', function(e) {
                    console.log('Apex Contact Form: Submit event triggered');
                    console.log('Apex Contact Form: Form data:', new FormData(contactForm));
                    
                    // Don't prevent default - let the form submit normally
                    // e.preventDefault();

                    // Show loading state
                    const submitBtn = contactForm.querySelector('.apex-contact-main__form-submit');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = 'Sending...';
                    submitBtn.disabled = true;

                    console.log('Apex Contact Form: Form submitting normally');
                    // The form will submit normally to the same page
                    // No need to call contactForm.submit() here
                });

                // Show success/error messages
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('success') === '1') {
                    console.log('Apex Contact Form: Showing success message');
                    apex_show_contact_message('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else if (urlParams.get('error')) {
                    console.log('Apex Contact Form: Showing error message:', urlParams.get('error'));
                    const errorMessages = {
                        'missing_fields': 'Please fill in all required fields.',
                        'invalid_email': 'Please enter a valid email address.',
                        'send_failed': 'There was an error sending your message. Please try again.'
                    };
                    const errorMsg = errorMessages[urlParams.get('error')] || 'An error occurred. Please try again.';
                    apex_show_contact_message('error', errorMsg);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } else {
                console.log('Apex Contact Form: Form not found');
            }

            function apex_show_contact_message(type, message) {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'apex-contact-message apex-contact-message--' + type;
                messageDiv.innerHTML = `
                    <div class="apex-contact-message__content">
                        ${type === 'success' ? '✓' : '⚠'} ${message}
                    </div>
                `;

                const formWrapper = document.querySelector('.apex-contact-main__form-wrapper');
                if (formWrapper) {
                    formWrapper.insertBefore(messageDiv, formWrapper.firstChild);
                }

                // Auto-hide after 10 seconds
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        messageDiv.parentNode.removeChild(messageDiv);
                    }
                }, 10000);
            }
        });
        </script>

        <style>
        .apex-contact-message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .apex-contact-message--success {
            background: #10b981;
            color: white;
        }
        .apex-contact-message--error {
            background: #ef4444;
            color: white;
        }
        .apex-contact-message__content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        </style>
        <?php
    }
}
add_action('wp_footer', 'apex_add_contact_form_processing');

/**
 * Test email function - call this manually to test Mailtrap setup
 */
function apex_test_email() {
    if (isset($_GET['test_email']) && current_user_can('administrator')) {
        $to = 'info@apex-softwares.com';
        $subject = 'Test Email from Apex Website';
        $message = '<h1>Test Email</h1><p>This is a test email to verify Mailtrap configuration.</p>';
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        $sent = wp_mail($to, $subject, $message, $headers);

        if ($sent) {
            echo 'Email sent successfully!';
        } else {
            echo 'Email sending failed!';
        }
        exit;
    }
}
add_action('init', 'apex_test_email');

/**
 * Theme setup.
 */
function apex_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'apex-theme'),
        'footer' => __('Footer Menu', 'apex-theme'),
    ]);
}
add_action('after_setup_theme', 'apex_theme_setup');

/**
 * Enqueue styles and scripts.
 */
function apex_theme_assets(): void {
    // Font Awesome 6 for social media icons
    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    // Font (matches modern B2B SaaS typography).
    wp_enqueue_style(
        'apex-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    // Tailwind CDN (fast prototype). Swap to a compiled build for production.
    wp_enqueue_script(
        'tailwind-cdn',
        'https://cdn.tailwindcss.com?plugins=forms,typography',
        [],
        null,
        false
    );

    // Configure Tailwind (brand colors, font) - run after script loads.
    wp_add_inline_script(
        'tailwind-cdn',
        "tailwind.config = {
  theme: {
    extend: {
      colors: {
        apex: {
          orange: '#FF6200',
          dark: '#1e293b',
          light: '#f8fafc',
          blue: '#0ea5e9',
          green: '#10b981',
          purple: '#8b5cf6',
          gray: {
            50: '#f8fafc',
            100: '#f1f5f9',
            200: '#e2e8f0',
            300: '#cbd5e1',
            400: '#94a3b8',
            500: '#64748b',
            600: '#475569',
            700: '#334155',
            800: '#1e293b',
            900: '#0f172a'
          }
        }
      },
      fontFamily: {
        sans: ['Josefin Sans', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Arial', 'Noto Sans', 'sans-serif']
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'bounce-subtle': 'bounceSubtle 2s infinite'
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' }
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        },
        bounceSubtle: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-5px)' }
        }
      }
    }
  }
};",
        'after'
    );

    // Main stylesheet (for WP requirements + small fallbacks).
    wp_enqueue_style(
        'apex-theme-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    // Add inline styles for comments
    $comment_styles = "
        /* Comment List Styling */
        .comment-list { list-style: none !important; padding: 0 !important; margin: 0 !important; }
        .comment-list .comment { 
            background: white; 
            border-radius: 1rem; 
            border: 1px solid #e2e8f0; 
            padding: 1.5rem; 
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        .comment-list .children { 
            margin-left: 2rem; 
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 2px solid #fed7aa;
        }
        .comment-author { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; }
        .comment-author .avatar { border-radius: 9999px; }
        .comment-author .fn { font-weight: 600; color: #1e293b; }
        .comment-author .fn a { color: #1e293b; text-decoration: none; }
        .comment-author .fn a:hover { color: #f97316; }
        .comment-author .says { display: none; }
        .comment-metadata { font-size: 0.875rem; color: #64748b; margin-bottom: 1rem; }
        .comment-metadata a { color: #64748b; text-decoration: none; }
        .comment-metadata a:hover { color: #f97316; }
        .comment-content { color: #475569; line-height: 1.6; }
        .comment-content p { margin-bottom: 0.75rem; }
        .reply { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0; }
        .reply a { 
            color: #f97316; 
            font-weight: 500; 
            font-size: 0.875rem; 
            text-decoration: none;
        }
        .reply a:hover { color: #ea580c; }
        
        /* Pagination styling */
        .nav-links { display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap; }
        .nav-links a, .nav-links span { 
            padding: 0.5rem 1rem; 
            border-radius: 0.5rem; 
            text-decoration: none;
            font-weight: 500;
        }
        .nav-links a { background: white; border: 1px solid #e2e8f0; color: #475569; }
        .nav-links a:hover { border-color: #f97316; color: #f97316; }
        .nav-links .current { background: #f97316; color: white; border: 1px solid #f97316; }
        
        /* Sidebar Widget Styling */
        .widget-item { margin-bottom: 1.5rem; }
        .widget-item:last-child { margin-bottom: 0; }
        .widget-title, .widget-item h2 { 
            font-size: 1.125rem; 
            font-weight: 700; 
            color: #1e293b; 
            margin-bottom: 1rem; 
            padding-bottom: 0.75rem; 
            border-bottom: 2px solid #fed7aa;
        }
        
        /* Search Widget - WordPress Block & Classic - High Specificity */
        .side-column .wp-block-search .wp-block-search__inside-wrapper,
        aside .wp-block-search .wp-block-search__inside-wrapper,
        .widget .wp-block-search .wp-block-search__inside-wrapper,
        .wp-block-search__inside-wrapper {
            display: flex !important;
            gap: 0.5rem !important;
            flex-wrap: nowrap !important;
        }
        .side-column .wp-block-search .wp-block-search__input,
        aside .wp-block-search .wp-block-search__input,
        .widget .wp-block-search .wp-block-search__input,
        .side-column .wp-block-search input[type='search'],
        aside .wp-block-search input[type='search'],
        .wp-block-search .wp-block-search__input,
        .wp-block-search__input {
            flex: 1 !important;
            min-width: 0 !important;
            padding: 12px 16px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 9999px !important;
            font-size: 14px !important;
            color: #1e293b !important;
            background: white !important;
            transition: all 0.2s !important;
            box-sizing: border-box !important;
            height: auto !important;
            appearance: none !important;
            -webkit-appearance: none !important;
        }
        .side-column .wp-block-search .wp-block-search__input:focus,
        aside .wp-block-search .wp-block-search__input:focus,
        .wp-block-search .wp-block-search__input:focus,
        .wp-block-search__input:focus {
            outline: none !important;
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1) !important;
        }
        .side-column .wp-block-search .wp-block-search__button,
        aside .wp-block-search .wp-block-search__button,
        .widget .wp-block-search .wp-block-search__button,
        .wp-block-search .wp-block-search__button,
        .wp-block-search__button {
            padding: 12px 20px !important;
            background: linear-gradient(to right, #f97316, #ea580c) !important;
            color: white !important;
            border: none !important;
            border-radius: 9999px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            height: auto !important;
        }
        .side-column .wp-block-search .wp-block-search__button:hover,
        aside .wp-block-search .wp-block-search__button:hover,
        .wp-block-search .wp-block-search__button:hover,
        .wp-block-search__button:hover {
            background: linear-gradient(to right, #ea580c, #dc2626) !important;
        }
        
        /* Classic Search Widget */
        .widget_search form { 
            display: flex; 
            gap: 0.5rem; 
            flex-wrap: wrap; 
        }
        .widget_search input[type='search'],
        .widget_search input[type='text'],
        .side-column input[name='s'],
        input#s,
        input.search-field {
            flex: 1;
            min-width: 0;
            padding: 0.75rem 1rem !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 9999px !important;
            font-size: 0.875rem !important;
            color: #1e293b !important;
            background: white !important;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        .widget_search input[type='search']:focus,
        .widget_search input[type='text']:focus,
        input#s:focus,
        input.search-field:focus {
            outline: none !important;
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1) !important;
        }
        .widget_search input[type='submit'],
        input#searchsubmit {
            padding: 0.75rem 1.25rem !important;
            background: linear-gradient(to right, #f97316, #ea580c) !important;
            color: white !important;
            border: none !important;
            border-radius: 9999px !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            cursor: pointer;
            transition: all 0.2s;
        }
        .widget_search input[type='submit']:hover,
        input#searchsubmit:hover {
            background: linear-gradient(to right, #ea580c, #dc2626) !important;
        }
        
        /* Recent Posts & Recent Comments Widgets */
        .widget_recent_entries ul,
        .widget_recent_comments ul,
        .wp-block-latest-posts,
        .wp-block-latest-comments {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .widget_recent_entries li,
        .widget_recent_comments li,
        .wp-block-latest-posts__post-title {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .widget_recent_entries li:last-child,
        .widget_recent_comments li:last-child {
            border-bottom: none;
        }
        .widget_recent_entries a,
        .widget_recent_comments a,
        .wp-block-latest-posts a {
            color: #475569;
            text-decoration: none;
            transition: color 0.2s;
        }
        .widget_recent_entries a:hover,
        .widget_recent_comments a:hover,
        .wp-block-latest-posts a:hover {
            color: #f97316;
        }
        .widget_recent_comments .comment-author-link {
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Categories & Archives Widgets */
        .widget_categories ul,
        .widget_archive ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .widget_categories li,
        .widget_archive li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }
        .widget_categories li:last-child,
        .widget_archive li:last-child {
            border-bottom: none;
        }
        .widget_categories a,
        .widget_archive a {
            color: #475569;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .widget_categories a:hover,
        .widget_archive a:hover {
            color: #f97316;
        }
        
        /* Tag Cloud Widget */
        .widget_tag_cloud .tagcloud a,
        .wp-block-tag-cloud a {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            margin: 0.25rem;
            background: #f1f5f9;
            color: #475569;
            border-radius: 9999px;
            font-size: 0.75rem !important;
            text-decoration: none;
            transition: all 0.2s;
        }
        .widget_tag_cloud .tagcloud a:hover,
        .wp-block-tag-cloud a:hover {
            background: #f97316;
            color: white;
        }
    ";
    wp_add_inline_style('apex-theme-style', $comment_styles);
}
add_action('wp_enqueue_scripts', 'apex_theme_assets');

// Get top ancestor
function get_top_ancestor_id() {
	
	global $post;
	
	if ($post->post_parent) {
		$ancestors = array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
		
	}
	
	return $post->ID;
	
}

// Does page have children?
function has_children() {
	
	global $post;
	
	$pages = get_pages('child_of=' . $post->ID);
	return count($pages);
	
}

// Customize excerpt word count length
function custom_excerpt_length() {
	return 25;
}

add_filter('excerpt_length', 'custom_excerpt_length');

// Add search widget styles in footer to override WordPress block styles
function apex_search_widget_styles() {
    ?>
    <style id="apex-search-override">
        /* Override WordPress Block Search Styles */
        .wp-block-search__input,
        .wp-block-search .wp-block-search__input,
        input.wp-block-search__input {
            border-radius: 9999px !important;
            padding: 12px 16px !important;
            border: 1px solid #e2e8f0 !important;
            background: white !important;
        }
        .wp-block-search__button,
        .wp-block-search .wp-block-search__button,
        button.wp-block-search__button {
            border-radius: 9999px !important;
            padding: 12px 20px !important;
            background: linear-gradient(to right, #f97316, #ea580c) !important;
            color: white !important;
            border: none !important;
            font-weight: 600 !important;
        }
        .wp-block-search__button:hover {
            background: linear-gradient(to right, #ea580c, #dc2626) !important;
        }
    </style>
    <?php
}
add_action('wp_footer', 'apex_search_widget_styles');

// Add Widget Areas
function apex_theme_widgets_init() {
	
	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 1',
		'id' => 'footer1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 2',
		'id' => 'footer2',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 3',
		'id' => 'footer3',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 4',
		'id' => 'footer4',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
}

add_action('widgets_init', 'apex_theme_widgets_init');



// Add custom JavaScript for header functionality
function apex_header_scripts() {
    if (is_admin()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get current page URL for active state detection
        const currentUrl = window.location.pathname + window.location.search;
        const currentHost = window.location.hostname;
        
        // Function to check if a link is active
        function isLinkActive(href) {
            if (!href) return false;
            
            // Remove domain and protocol for comparison
            const linkPath = href.replace(/^https?:\/\/[^\/]+/, '');
            const currentPath = currentUrl;
            
            // Exact match
            if (linkPath === currentPath) return true;
            
            // Check if current path starts with link path (for parent pages)
            if (linkPath !== '/' && currentPath.startsWith(linkPath)) return true;
            
            // Special cases for home page
            if (linkPath === '/' || linkPath === '/index.php') {
                return currentPath === '/' || currentPath === '/index.php';
            }
            
            return false;
        }
        
        // Set active states for main navigation
        function setActiveStates() {
            // Main navigation links
            const mainLinks = document.querySelectorAll('.apex-nav-link, .apex-nav-trigger');
            mainLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && isLinkActive(href)) {
                    link.classList.add('apex-nav-active');
                }
            });
            
            // Dropdown links
            const dropdownLinks = document.querySelectorAll('.apex-nav-panel a');
            dropdownLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && isLinkActive(href)) {
                    link.classList.add('apex-subnav-active');
                    
                    // Also mark parent dropdown as active
                    const parentPanel = link.closest('.apex-nav-panel');
                    if (parentPanel) {
                        const parentItem = parentPanel.closest('.apex-nav-item');
                        if (parentItem) {
                            const parentTrigger = parentItem.querySelector('.apex-nav-trigger');
                            if (parentTrigger) {
                                parentTrigger.classList.add('apex-nav-active');
                                // Add a special class to the parent item for CSS targeting
                                parentItem.classList.add('apex-nav-parent-active');
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize active states
        setActiveStates();
        
        // NOTE: Desktop dropdown positioning and mobile menu toggle are handled in header.php inline script
        // to avoid duplicate event handlers causing conflicts
        
        // Header scroll effect
        let header = document.querySelector('header');
        if (header) {
            // Initial check in case page is loaded with scroll
            if (window.scrollY > 10) {
                header.classList.add('apex-header-scrolled');
                header.classList.add('bg-white/90', 'supports-[backdrop-filter]:bg-white/70', 'shadow-sm');
            }
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 10) {
                    header.classList.add('apex-header-scrolled');
                    header.classList.add('bg-white/90', 'supports-[backdrop-filter]:bg-white/70', 'shadow-sm');
                } else {
                    header.classList.remove('apex-header-scrolled');
                    header.classList.remove('bg-white/90', 'supports-[backdrop-filter]:bg-white/70', 'shadow-sm');
                }
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'apex_header_scripts');

/**
 * Register custom rewrite rules for About Us pages
 */
function apex_about_us_rewrite_rules() {
    add_rewrite_rule('^about-us/?$', 'index.php?apex_about_page=overview', 'top');
    add_rewrite_rule('^about-us/overview/?$', 'index.php?apex_about_page=overview', 'top');
    add_rewrite_rule('^about-us/our-approach/?$', 'index.php?apex_about_page=our-approach', 'top');
    add_rewrite_rule('^about-us/leadership-team/?$', 'index.php?apex_about_page=leadership-team', 'top');
    add_rewrite_rule('^about-us/news/?$', 'index.php?apex_about_page=news', 'top');
}
add_action('init', 'apex_about_us_rewrite_rules');

/**
 * Register custom rewrite rules for Insights pages
 */
function apex_insights_rewrite_rules() {
    add_rewrite_rule('^insights/blog/?$', 'index.php?apex_insights_page=blog', 'top');
    add_rewrite_rule('^insights/success-stories/?$', 'index.php?apex_insights_page=success-stories', 'top');
    add_rewrite_rule('^insights/webinars/?$', 'index.php?apex_insights_page=webinars', 'top');
    add_rewrite_rule('^insights/whitepapers-reports/?$', 'index.php?apex_insights_page=whitepapers-reports', 'top');
}
add_action('init', 'apex_insights_rewrite_rules');

/**
 * Register custom rewrite rules for Contact page
 */
function apex_contact_rewrite_rules() {
    add_rewrite_rule('^contact/?$', 'index.php?apex_contact_page=contact', 'top');
}
add_action('init', 'apex_contact_rewrite_rules');

/**
 * Register custom rewrite rules for Industry pages
 */
function apex_industry_rewrite_rules() {
    add_rewrite_rule('^industry/overview/?$', 'index.php?apex_industry_page=overview', 'top');
    add_rewrite_rule('^industry/mfis/?$', 'index.php?apex_industry_page=mfis', 'top');
    add_rewrite_rule('^industry/credit-unions/?$', 'index.php?apex_industry_page=credit-unions', 'top');
    add_rewrite_rule('^industry/banks-microfinance/?$', 'index.php?apex_industry_page=banks', 'top');
    add_rewrite_rule('^industry/digital-government/?$', 'index.php?apex_industry_page=digital-government', 'top');
}
add_action('init', 'apex_industry_rewrite_rules');

/**
 * Register custom rewrite rules for Legal and Support pages
 */
function apex_support_rewrite_rules() {
    // Legal pages
    add_rewrite_rule('^privacy-policy/?$', 'index.php?apex_support_page=privacy-policy', 'top');
    add_rewrite_rule('^terms-and-conditions/?$', 'index.php?apex_support_page=terms-and-conditions', 'top');
    
    // Support pages
    add_rewrite_rule('^careers/?$', 'index.php?apex_support_page=careers', 'top');
    add_rewrite_rule('^help-support/?$', 'index.php?apex_support_page=help-support', 'top');
    add_rewrite_rule('^faq/?$', 'index.php?apex_support_page=faq', 'top');
    add_rewrite_rule('^knowledge-base/?$', 'index.php?apex_support_page=knowledge-base', 'top');
    add_rewrite_rule('^developers/?$', 'index.php?apex_support_page=developers', 'top');
    add_rewrite_rule('^partners/?$', 'index.php?apex_support_page=partners', 'top');
    add_rewrite_rule('^request-demo/?$', 'index.php?apex_support_page=request-demo', 'top');
}
add_action('init', 'apex_support_rewrite_rules');

/**
 * Register custom rewrite rules for Solutions pages
 */
function apex_solutions_rewrite_rules() {
    add_rewrite_rule('^solutions/overview/?$', 'index.php?apex_solutions_page=overview', 'top');
    add_rewrite_rule('^solutions/core-banking-microfinance/?$', 'index.php?apex_solutions_page=core-banking', 'top');
    add_rewrite_rule('^solutions/mobile-wallet-app/?$', 'index.php?apex_solutions_page=mobile-wallet', 'top');
    add_rewrite_rule('^solutions/agency-branch-banking/?$', 'index.php?apex_solutions_page=agency-banking', 'top');
    add_rewrite_rule('^solutions/internet-mobile-banking/?$', 'index.php?apex_solutions_page=internet-banking', 'top');
    add_rewrite_rule('^solutions/loan-origination-workflows/?$', 'index.php?apex_solutions_page=loan-origination', 'top');
    add_rewrite_rule('^solutions/digital-field-agent/?$', 'index.php?apex_solutions_page=field-agent', 'top');
    add_rewrite_rule('^solutions/enterprise-integration/?$', 'index.php?apex_solutions_page=enterprise-integration', 'top');
    add_rewrite_rule('^solutions/payment-switch-ledger/?$', 'index.php?apex_solutions_page=payment-switch', 'top');
    add_rewrite_rule('^solutions/reporting-analytics/?$', 'index.php?apex_solutions_page=reporting', 'top');
}
add_action('init', 'apex_solutions_rewrite_rules');

/**
 * Flush rewrite rules on theme activation
 */
function apex_flush_rewrite_rules() {
    apex_about_us_rewrite_rules();
    apex_insights_rewrite_rules();
    apex_contact_rewrite_rules();
    apex_industry_rewrite_rules();
    apex_support_rewrite_rules();
    apex_solutions_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'apex_flush_rewrite_rules');

/**
 * One-time flush for development (remove in production)
 */
function apex_maybe_flush_rules() {
    if (get_option('apex_rewrite_rules_flushed') !== '7') {
        flush_rewrite_rules();
        update_option('apex_rewrite_rules_flushed', '7');
    }
}
add_action('init', 'apex_maybe_flush_rules', 20);

/**
 * Register Website Settings Menu
 */
function apex_register_website_settings_menu() {
    // Add main menu
    add_menu_page(
        'Website Settings',
        'Website Settings',
        'edit_theme_options',
        'apex-website-settings',
        'apex_website_settings_overview',
        'dashicons-admin-settings',
        30
    );
    
    // Define hierarchical menu organization system
    $menu_hierarchy = [
        // Parent categories that can contain child items
        'parents' => [
            'about-us' => [
                'title' => 'About Us',
                'slug' => 'about-us-overview',
                'description' => 'About Us main pages and sub-pages',
                'children' => [
                    'about-us-overview',
                    'about-us-our-approach', 
                    'about-us-leadership-team',
                    'about-us-news'
                ]
            ],
            'solutions' => [
                'title' => 'Solutions',
                'slug' => 'solutions-overview',
                'description' => 'All Apex Solutions and services',
                'children' => [
                    'solutions-overview',
                    'solutions-core-banking-microfinance',
                    'solutions-mobile-wallet-app',
                    'solutions-agency-branch-banking',
                    'solutions-internet-mobile-banking',
                    'solutions-loan-origination-workflows',
                    'solutions-digital-field-agent',
                    'solutions-enterprise-integration',
                    'solutions-payment-switch-ledger',
                    'solutions-reporting-analytics'
                ]
            ],
            'industry' => [
                'title' => 'Industry',
                'slug' => 'industry-overview',
                'description' => 'Industry-specific solutions and services',
                'children' => [
                    'industry-overview',
                    'industry-mfis',
                    'industry-credit-unions',
                    'industry-banks-microfinance',
                    'industry-digital-government'
                ]
            ],
            'insights' => [
                'title' => 'Insights',
                'slug' => 'insights-blog',
                'description' => 'Blog, success stories, and resources',
                'children' => [
                    'insights-blog',
                    'insights-success-stories',
                    'insights-webinars',
                    'insights-whitepapers-reports'
                ]
            ],
            'support' => [
                'title' => 'Support',
                'slug' => 'help-support',
                'description' => 'Help, support, and additional resources',
                'children' => [
                    'careers',
                    'help-support',
                    'faq',
                    'knowledge-base',
                    'developers',
                    'partners',
                    'request-demo'
                ]
            ],
            'legal' => [
                'title' => 'Legal',
                'slug' => 'privacy-policy',
                'description' => 'Legal pages and policies',
                'children' => [
                    'privacy-policy',
                    'terms-and-conditions'
                ]
            ]
        ],
        
        // Standalone items that don't belong to any parent category
        'standalone' => [
            'home' => [
                'title' => 'Home',
                'slug' => '',
                'description' => 'Homepage content and hero section'
            ],
            'contact' => [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'description' => 'Contact page and information'
            ]
        ]
    ];
    
    // Store hierarchy configuration globally for use in other functions
    global $apex_menu_hierarchy;
    $apex_menu_hierarchy = $menu_hierarchy;
    
    // Get navigation routes from header.php structure
    $navigation_routes = [
        // Main navigation items from header.php
        ['title' => 'Home', 'slug' => '', 'href' => home_url('/')],
        
        // About Us routes (parent + children)
        ['title' => 'About Apex Softwares', 'slug' => 'about-us-overview', 'href' => home_url('/about-us/overview')],
        ['title' => 'Our Approach', 'slug' => 'about-us-our-approach', 'href' => home_url('/about-us/our-approach'), 'parent' => 'About Us'],
        ['title' => 'Leadership Team', 'slug' => 'about-us-leadership-team', 'href' => home_url('/about-us/leadership-team'), 'parent' => 'About Us'],
        ['title' => 'News & Updates', 'slug' => 'about-us-news', 'href' => home_url('/about-us/news'), 'parent' => 'About Us'],
        
        // Solutions routes (parent + children)
        ['title' => 'Solutions', 'slug' => 'solutions-overview', 'href' => home_url('/solutions/overview')],
        ['title' => 'Core Banking & Microfinance', 'slug' => 'solutions-core-banking-microfinance', 'href' => home_url('/solutions/core-banking-microfinance'), 'parent' => 'Solutions'],
        ['title' => 'Mobile Wallet App', 'slug' => 'solutions-mobile-wallet-app', 'href' => home_url('/solutions/mobile-wallet-app'), 'parent' => 'Solutions'],
        ['title' => 'Agency & Branch Banking', 'slug' => 'solutions-agency-branch-banking', 'href' => home_url('/solutions/agency-branch-banking'), 'parent' => 'Solutions'],
        ['title' => 'Internet & Mobile Banking', 'slug' => 'solutions-internet-mobile-banking', 'href' => home_url('/solutions/internet-mobile-banking'), 'parent' => 'Solutions'],
        ['title' => 'Loan Origination & Workflows', 'slug' => 'solutions-loan-origination-workflows', 'href' => home_url('/solutions/loan-origination-workflows'), 'parent' => 'Solutions'],
        ['title' => 'Digital Field Agent', 'slug' => 'solutions-digital-field-agent', 'href' => home_url('/solutions/digital-field-agent'), 'parent' => 'Solutions'],
        ['title' => 'Enterprise Integration', 'slug' => 'solutions-enterprise-integration', 'href' => home_url('/solutions/enterprise-integration'), 'parent' => 'Solutions'],
        ['title' => 'Payment Switch & General Ledger', 'slug' => 'solutions-payment-switch-ledger', 'href' => home_url('/solutions/payment-switch-ledger'), 'parent' => 'Solutions'],
        ['title' => 'Reporting & Analytics', 'slug' => 'solutions-reporting-analytics', 'href' => home_url('/solutions/reporting-analytics'), 'parent' => 'Solutions'],
        
        // Industry routes (parent + children)
        ['title' => 'Industry', 'slug' => 'industry-overview', 'href' => home_url('/industry/overview')],
        ['title' => 'Microfinance Institutions (MFIs)', 'slug' => 'industry-mfis', 'href' => home_url('/industry/mfis'), 'parent' => 'Industry'],
        ['title' => 'SACCOs & Credit Unions', 'slug' => 'industry-credit-unions', 'href' => home_url('/industry/credit-unions'), 'parent' => 'Industry'],
        ['title' => 'Commercial Banks', 'slug' => 'industry-banks-microfinance', 'href' => home_url('/industry/banks-microfinance'), 'parent' => 'Industry'],
        ['title' => 'Digital Government & NGOs', 'slug' => 'industry-digital-government', 'href' => home_url('/industry/digital-government'), 'parent' => 'Industry'],
        
        // Insights routes (parent + children)
        ['title' => 'Insights', 'slug' => 'insights-blog', 'href' => home_url('/insights/blog')],
        ['title' => 'Success Stories', 'slug' => 'insights-success-stories', 'href' => home_url('/insights/success-stories'), 'parent' => 'Insights'],
        ['title' => 'Webinars & Events', 'slug' => 'insights-webinars', 'href' => home_url('/insights/webinars'), 'parent' => 'Insights'],
        ['title' => 'Whitepapers & Reports', 'slug' => 'insights-whitepapers-reports', 'href' => home_url('/insights/whitepapers-reports'), 'parent' => 'Insights'],
        
        // Standalone items
        ['title' => 'Contact Us', 'slug' => 'contact', 'href' => home_url('/contact')],
        
        // Footer routes from footer.php
        ['title' => 'Support', 'slug' => 'help-support', 'href' => home_url('/help-support')],
        ['title' => 'Careers', 'slug' => 'careers', 'href' => home_url('/careers'), 'parent' => 'Support'],
        ['title' => 'Help & Support', 'slug' => 'help-support', 'href' => home_url('/help-support'), 'parent' => 'Support'],
        ['title' => 'FAQ', 'slug' => 'faq', 'href' => home_url('/faq'), 'parent' => 'Support'],
        ['title' => 'Knowledge Base', 'slug' => 'knowledge-base', 'href' => home_url('/knowledge-base'), 'parent' => 'Support'],
        ['title' => 'Developers', 'slug' => 'developers', 'href' => home_url('/developers'), 'parent' => 'Support'],
        ['title' => 'Partners', 'slug' => 'partners', 'href' => home_url('/partners'), 'parent' => 'Support'],
        ['title' => 'Request Demo', 'slug' => 'request-demo', 'href' => home_url('/request-demo'), 'parent' => 'Support'],
        
        ['title' => 'Legal', 'slug' => 'privacy-policy', 'href' => home_url('/privacy-policy')],
        ['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'href' => home_url('/privacy-policy'), 'parent' => 'Legal'],
        ['title' => 'Terms and Conditions', 'slug' => 'terms-and-conditions', 'href' => home_url('/terms-and-conditions'), 'parent' => 'Legal'],
    ];
    
    // Add individual route pages as direct menu items (maintaining current structure)
    foreach ($navigation_routes as $route) {
        $menu_slug = 'apex-edit-' . $route['slug'];
        if (empty($route['slug'])) {
            $menu_slug = 'apex-edit-home';
        }
        
        add_submenu_page(
            'apex-website-settings',
            $route['title'],
            $route['title'],
            'edit_theme_options',
            $menu_slug,
            function() use ($route) {
                apex_render_page_editor($route['slug'], $route['title']);
            }
        );
    }
    
    // Add Footer Settings submenu
    add_submenu_page(
        'apex-website-settings',
        'Footer Settings',
        'Footer Settings',
        'edit_theme_options',
        'apex-footer-settings',
        'apex_render_footer_settings_page'
    );
}
add_action('admin_menu', 'apex_register_website_settings_menu');

/**
 * Register ACF Options Page
 */
function apex_register_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title'    => 'Website Settings',
            'menu_title'    => 'Website Settings',
            'menu_slug'     => 'apex-website-settings',
            'capability'    => 'edit_theme_options',
            'redirect'      => false,
            'parent_slug'   => '',
            'position'      => 30,
            'icon_url'      => 'dashicons-admin-settings',
            'update_button' => 'Save Changes',
            'updated_message' => 'Website settings updated successfully!'
        ]);
    }
}
add_action('acf/init', 'apex_register_acf_options_page');

/**
 * Get hierarchical menu organization
 */
function apex_get_menu_hierarchy() {
    global $apex_menu_hierarchy;
    
    if (!isset($apex_menu_hierarchy)) {
        // Default hierarchy if not set
        $apex_menu_hierarchy = [
            'parents' => [],
            'standalone' => []
        ];
    }
    
    return $apex_menu_hierarchy;
}

/**
 * Check if a menu item belongs to a parent category
 */
function apex_get_menu_item_parent($slug) {
    $hierarchy = apex_get_menu_hierarchy();
    
    foreach ($hierarchy['parents'] as $parent_key => $parent_data) {
        if (in_array($slug, $parent_data['children'])) {
            return $parent_key;
        }
    }
    
    return false;
}

/**
 * Get child items for a parent category
 */
function apex_get_parent_children($parent_key) {
    $hierarchy = apex_get_menu_hierarchy();
    
    if (isset($hierarchy['parents'][$parent_key])) {
        return $hierarchy['parents'][$parent_key]['children'];
    }
    
    return [];
}

/**
 * Get menu item display order based on hierarchy
 */
function apex_get_menu_item_order($slug) {
    $hierarchy = apex_get_menu_hierarchy();
    $order = 0;
    
    // Standalone items first
    foreach ($hierarchy['standalone'] as $key => $item) {
        $order++;
        if ($item['slug'] === $slug || (empty($item['slug']) && empty($slug))) {
            return $order;
        }
    }
    
    // Parent items and their children
    foreach ($hierarchy['parents'] as $parent_key => $parent_data) {
        $order++; // Parent item
        if ($parent_data['slug'] === $slug) {
            return $order;
        }
        
        // Child items
        foreach ($parent_data['children'] as $child_slug) {
            $order++;
            if ($child_slug === $slug) {
                return $order;
            }
        }
    }
    
    return $order;
}

/**
 * Website Settings Overview Page
 */
function apex_website_settings_overview() {
    $hierarchy = apex_get_menu_hierarchy();
    ?>
    <div class="wrap">
        <h1>Website Settings - Content Management</h1>
        <p>Click on any menu item on the left to edit that page's content dynamically. Menu items are organized hierarchically with parent categories containing child sub-items.</p>
        
        <div class="apex-menu-organization">
            <h2>Menu Organization Structure</h2>
            <p>The menu is organized in a hierarchical tree structure where parent categories can contain multiple child sub-items.</p>
            
            <div class="apex-hierarchy-display">
                <!-- Standalone Items -->
                <?php if (!empty($hierarchy['standalone'])): ?>
                <div class="apex-hierarchy-section">
                    <h3>Standalone Items</h3>
                    <div class="apex-hierarchy-items">
                        <?php foreach ($hierarchy['standalone'] as $key => $item): ?>
                            <div class="apex-hierarchy-item apex-standalone-item">
                                <div class="apex-item-content">
                                    <strong><?php echo esc_html($item['title']); ?></strong>
                                    <?php if (!empty($item['description'])): ?>
                                        <span class="apex-item-description"><?php echo esc_html($item['description']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="apex-item-actions">
                                    <a href="<?php echo admin_url('admin.php?page=apex-edit-' . ($item['slug'] ?: 'home')); ?>" class="button button-small">Edit</a>
                                    <a href="<?php echo empty($item['slug']) ? home_url('/') : home_url('/' . $item['slug']); ?>" target="_blank" class="button button-small button-secondary">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Parent Categories with Children -->
                <?php if (!empty($hierarchy['parents'])): ?>
                <div class="apex-hierarchy-section">
                    <h3>Hierarchical Categories</h3>
                    <div class="apex-hierarchy-tree">
                        <?php foreach ($hierarchy['parents'] as $parent_key => $parent_data): ?>
                            <div class="apex-parent-category">
                                <div class="apex-parent-header">
                                    <div class="apex-parent-info">
                                        <strong><?php echo esc_html($parent_data['title']); ?></strong>
                                        <?php if (!empty($parent_data['description'])): ?>
                                            <span class="apex-parent-description"><?php echo esc_html($parent_data['description']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="apex-parent-actions">
                                        <a href="<?php echo admin_url('admin.php?page=apex-edit-' . $parent_data['slug']); ?>" class="button button-small">Edit Parent</a>
                                        <a href="<?php echo home_url('/' . $parent_data['slug']); ?>" target="_blank" class="button button-small button-secondary">View Parent</a>
                                    </div>
                                </div>
                                
                                <div class="apex-child-items">
                                    <?php foreach ($parent_data['children'] as $child_slug): 
                                        $child_title = apex_get_menu_item_title($child_slug);
                                        $child_url = empty($child_slug) ? home_url('/') : home_url('/' . $child_slug);
                                    ?>
                                        <div class="apex-child-item">
                                            <div class="apex-child-content">
                                                <span class="apex-child-indicator">→</span>
                                                <strong><?php echo esc_html($child_title); ?></strong>
                                            </div>
                                            <div class="apex-child-actions">
                                                <a href="<?php echo admin_url('admin.php?page=apex-edit-' . (empty($child_slug) ? 'home' : $child_slug)); ?>" class="button button-small">Edit</a>
                                                <a href="<?php echo esc_url($child_url); ?>" target="_blank" class="button button-small button-secondary">View</a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="apex-organization-info">
                <h3>How the Hierarchy Works</h3>
                <ul>
                    <li><strong>Parent Categories</strong>: Main menu items that can contain sub-items (like "Solutions", "Industry", "About Us")</li>
                    <li><strong>Child Sub-items</strong>: Individual pages organized under their parent categories</li>
                    <li><strong>Standalone Items</strong>: Top-level items that don't belong to any parent category (like "Home", "Contact Us")</li>
                    <li><strong>Navigation</strong>: Click any menu item on the left sidebar to edit that page's content</li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
        .apex-menu-organization {
            margin-top: 30px;
        }
        .apex-hierarchy-display {
            background: #f8f9fa;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .apex-hierarchy-section {
            margin-bottom: 30px;
        }
        .apex-hierarchy-section h3 {
            margin-bottom: 15px;
            color: #23282d;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 5px;
        }
        .apex-hierarchy-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .apex-hierarchy-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .apex-item-content {
            flex: 1;
        }
        .apex-item-description {
            display: block;
            color: #666;
            font-size: 13px;
            margin-top: 4px;
        }
        .apex-item-actions {
            display: flex;
            gap: 8px;
        }
        .apex-hierarchy-tree {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .apex-parent-category {
            background: #fff;
            border: 2px solid #0073aa;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .apex-parent-header {
            background: #0073aa;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .apex-parent-info strong {
            font-size: 16px;
        }
        .apex-parent-description {
            display: block;
            font-size: 13px;
            opacity: 0.9;
            margin-top: 4px;
        }
        .apex-parent-actions {
            display: flex;
            gap: 8px;
        }
        .apex-parent-actions .button {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.3);
            color: white;
        }
        .apex-parent-actions .button:hover {
            background: rgba(255,255,255,0.3);
        }
        .apex-child-items {
            padding: 15px 20px;
            background: #f8f9fa;
        }
        .apex-child-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 8px;
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .apex-child-item:last-child {
            margin-bottom: 0;
        }
        .apex-child-content {
            display: flex;
            align-items: center;
            flex: 1;
        }
        .apex-child-indicator {
            color: #0073aa;
            font-weight: bold;
            margin-right: 10px;
            font-size: 14px;
        }
        .apex-child-actions {
            display: flex;
            gap: 8px;
        }
        .apex-organization-info {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 20px;
        }
        .apex-organization-info h3 {
            margin-top: 0;
            color: #23282d;
        }
        .apex-organization-info ul {
            margin: 0;
            padding-left: 20px;
        }
        .apex-organization-info li {
            margin-bottom: 8px;
            color: #555;
        }
    </style>
    <?php
}

/**
 * Get menu item title from slug
 */
function apex_get_menu_item_title($slug) {
    $title_map = [
        '' => 'Home',
        'about-us-overview' => 'About Apex Softwares',
        'about-us-our-approach' => 'Our Approach',
        'about-us-leadership-team' => 'Leadership Team',
        'about-us-news' => 'News & Updates',
        'solutions-overview' => 'Solutions Overview',
        'solutions-core-banking-microfinance' => 'Core Banking & Microfinance',
        'solutions-mobile-wallet-app' => 'Mobile Wallet App',
        'solutions-agency-branch-banking' => 'Agency & Branch Banking',
        'solutions-internet-mobile-banking' => 'Internet & Mobile Banking',
        'solutions-loan-origination-workflows' => 'Loan Origination & Workflows',
        'solutions-digital-field-agent' => 'Digital Field Agent',
        'solutions-enterprise-integration' => 'Enterprise Integration',
        'solutions-payment-switch-ledger' => 'Payment Switch & General Ledger',
        'solutions-reporting-analytics' => 'Reporting & Analytics',
        'industry-overview' => 'Industry Overview',
        'industry-mfis' => 'Microfinance Institutions (MFIs)',
        'industry-credit-unions' => 'SACCOs & Credit Unions',
        'industry-banks-microfinance' => 'Commercial Banks',
        'industry-digital-government' => 'Digital Government & NGOs',
        'insights-blog' => 'Blog',
        'insights-success-stories' => 'Success Stories',
        'insights-webinars' => 'Webinars & Events',
        'insights-whitepapers-reports' => 'Whitepapers & Reports',
        'contact' => 'Contact Us',
    ];
    
    return isset($title_map[$slug]) ? $title_map[$slug] : ucwords(str_replace(['-', '_'], ' ', $slug));
}

/**
 * Parent Menu Page for Grouped Routes
 */
function apex_website_settings_parent_menu($routes, $parent_name) {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html($parent_name); ?> - Content Management</h1>
        <p>Select a page to edit its content:</p>
        
        <div class="apex-route-list">
            <?php foreach ($routes as $route): ?>
                <div class="apex-route-item">
                    <h3><?php echo esc_html($route['title']); ?></h3>
                    <div class="apex-route-actions">
                        <a href="<?php echo admin_url('admin.php?page=apex-edit-' . $route['slug']); ?>" class="button button-primary">Edit Content</a>
                        <a href="<?php echo home_url('/' . $route['slug']); ?>" target="_blank" class="button button-secondary">View Page</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <style>
        .apex-route-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .apex-route-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .apex-route-item h3 {
            margin-top: 0;
            color: #23282d;
        }
        .apex-route-actions {
            margin-top: 15px;
        }
        .apex-route-actions .button {
            margin-right: 10px;
        }
    </style>
    <?php
}

/**
 * Render ACF form for editing a specific page
 */
function apex_render_page_editor($page_slug, $page_title) {
    // Handle home page special case
    if (empty($page_slug)) {
        $page_slug = 'home';
    }
    
    // Map page slugs to ACF field group keys and page titles
    $page_config = [
        'home' => [
            'title' => 'Home Page',
            'acf_group' => 'group_home_hero'
        ],
        'about-us-overview' => [
            'title' => 'About Apex Softwares Overview',
            'acf_group' => 'group_about_us_hero'
        ],
        'about-us-our-approach' => [
            'title' => 'Our Approach',
            'acf_group' => 'group_approach_hero'
        ],
        'about-us-leadership-team' => [
            'title' => 'Leadership Team',
            'acf_group' => 'group_about_us_leadership'
        ],
        'about-us-news' => [
            'title' => 'News & Updates',
            'acf_group' => 'group_about_us_news'
        ],
        'solutions-overview' => [
            'title' => 'Solutions Overview',
            'acf_group' => 'group_solutions_overview'
        ],
        'solutions-core-banking-microfinance' => [
            'title' => 'Core Banking & Microfinance',
            'acf_group' => 'group_solutions_core_banking'
        ],
        'solutions-mobile-wallet-app' => [
            'title' => 'Mobile Wallet App',
            'acf_group' => 'group_solutions_mobile_wallet'
        ],
        'solutions-agency-branch-banking' => [
            'title' => 'Agency & Branch Banking',
            'acf_group' => 'group_solutions_agency_banking'
        ],
        'solutions-internet-mobile-banking' => [
            'title' => 'Internet & Mobile Banking',
            'acf_group' => 'group_solutions_internet_banking'
        ],
        'solutions-loan-origination-workflows' => [
            'title' => 'Loan Origination & Workflows',
            'acf_group' => 'group_solutions_loan_origination'
        ],
        'solutions-digital-field-agent' => [
            'title' => 'Digital Field Agent',
            'acf_group' => 'group_solutions_field_agent'
        ],
        'solutions-enterprise-integration' => [
            'title' => 'Enterprise Integration',
            'acf_group' => 'group_solutions_enterprise_integration'
        ],
        'solutions-payment-switch-ledger' => [
            'title' => 'Payment Switch & General Ledger',
            'acf_group' => 'group_solutions_payment_switch'
        ],
        'solutions-reporting-analytics' => [
            'title' => 'Reporting & Analytics',
            'acf_group' => 'group_solutions_reporting'
        ],
        'industry-overview' => [
            'title' => 'Industry Overview',
            'acf_group' => 'group_industry_overview'
        ],
        'industry-mfis' => [
            'title' => 'Microfinance Institutions (MFIs)',
            'acf_group' => 'group_industry_mfis'
        ],
        'industry-credit-unions' => [
            'title' => 'SACCOs & Credit Unions',
            'acf_group' => 'group_industry_credit_unions'
        ],
        'industry-banks-microfinance' => [
            'title' => 'Commercial Banks',
            'acf_group' => 'group_industry_banks'
        ],
        'industry-digital-government' => [
            'title' => 'Digital Government & NGOs',
            'acf_group' => 'group_industry_digital_government'
        ],
        'insights-blog' => [
            'title' => 'Blog',
            'acf_group' => 'group_insights_blog'
        ],
        'insights-success-stories' => [
            'title' => 'Success Stories',
            'acf_group' => 'group_insights_success_stories'
        ],
        'insights-webinars' => [
            'title' => 'Webinars & Events',
            'acf_group' => 'group_insights_webinars'
        ],
        'insights-whitepapers-reports' => [
            'title' => 'Whitepapers & Reports',
            'acf_group' => 'group_insights_whitepapers'
        ],
        'contact' => [
            'title' => 'Contact Us',
            'acf_group' => 'group_contact'
        ],
        // Add more page configurations as needed
    ];
    
    if (!isset($page_config[$page_slug])) {
        echo '<div class="wrap"><h1>Page not found</h1><p>The requested page editor is not available.</p></div>';
        return;
    }
    $config = $page_config[$page_slug];
    
    ?>
    <div class="wrap">
        <h1>Edit: <?php echo esc_html($config['title']); ?></h1>
        <a href="<?php echo admin_url('admin.php?page=apex-website-settings'); ?>" class="button">← Back to Overview</a>
        <a href="<?php echo empty($page_slug) || $page_slug === 'home' ? home_url('/') : home_url('/' . $page_slug); ?>" target="_blank" class="button button-secondary" style="margin-left: 10px;">View Page</a>
        
        <div style="margin-top: 20px;">
            <?php 
            // Render ACF form for this page
            if (function_exists('acf_form')) {
                echo '<div style="background: #e7f3ff; padding: 10px; margin-bottom: 20px; border: 1px solid #3498db;">';
                echo '<strong>Attempting to render ACF form...</strong><br>';
                echo 'Post ID: options<br>';
                echo 'Field Groups: ' . esc_html($config['acf_group']) . '<br>';
                echo '</div>';
                
                acf_form([
                    'post_id' => 'options', // Use options page
                    'field_groups' => [$config['acf_group']],
                    'return' => admin_url('admin.php?page=apex-website-settings'),
                    'submit_value' => 'Save Changes',
                ]);
                
                echo '<div style="background: #d4edda; padding: 10px; margin-top: 20px; border: 1px solid #28a745;">';
                echo '<strong>ACF form rendering completed.</strong>';
                echo '</div>';
            } else {
                // Fallback form when ACF is not available
                apex_render_fallback_form($page_slug, $config);
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Render fallback form when ACF is not available
 */
function apex_render_fallback_form($page_slug, $config) {
    ?>
    <form method="post" action="" style="background: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; border-radius: 6px;">
        <?php wp_nonce_field('apex_save_fallback_content', 'apex_fallback_nonce'); ?>
        <input type="hidden" name="apex_page_slug" value="<?php echo esc_attr($page_slug); ?>">
        
        <h3>Edit Content: <?php echo esc_html($config['title']); ?></h3>
        <p class="description">Update the content for this page. Changes will appear immediately on the frontend.</p>
        
        <!-- Hero Section (Common to both pages) -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_hero_badge" name="apex_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_hero_badge_' . $page_slug, 'About Apex Softwares')); ?>" 
                               class="regular-text" placeholder="e.g., About Apex Softwares">
                        <p class="description">The small badge text above the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_hero_heading" name="apex_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_hero_heading_' . $page_slug, 'Transforming Financial Services Across Africa')); ?>" 
                               class="regular-text" placeholder="Main hero heading">
                        <p class="description">The main heading for the hero section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_hero_description" name="apex_hero_description" rows="4" class="large-text"
                                  placeholder="Hero section description"><?php echo esc_textarea(get_option('apex_hero_description_' . $page_slug, "For over a decade, we've been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences.")); ?></textarea>
                        <p class="description">The description text below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_hero_image" name="apex_hero_image" 
                               value="<?php echo esc_attr(get_option('apex_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">The main hero image URL (recommended size: 1200x800px)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_stats">Statistics</label></th>
                    <td>
                        <textarea id="apex_hero_stats" name="apex_hero_stats" rows="6" class="large-text"
                                  placeholder="100+ Financial Institutions&#10;15+ Countries&#10;10M+ End Users&#10;14+ Years Experience"><?php 
                            $stats = get_option('apex_hero_stats_' . $page_slug, "100+ Financial Institutions\n15+ Countries\n10M+ End Users\n14+ Years Experience");
                            echo esc_textarea($stats);
                        ?></textarea>
                        <p class="description">One statistic per line in format: "Value Label"</p>
                    </td>
                </tr>
            </table>
        </div>

        <?php if ($page_slug === 'about-us-overview'): ?>
        <!-- About Us Overview Specific Sections -->
        
        <!-- Our Story Section -->
        <div style="margin-bottom: 30px;">
            <h4>📖 Our Story Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section tells your company story with multiple content paragraphs and key milestones.</strong> Content appears as flowing paragraphs followed by a timeline of important achievements.</p>
                <p><strong>Format for milestones:</strong> Enter each milestone on a new line using this format:<br>
                <code>Year | Title | Description</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_story_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_story_badge" name="apex_story_badge" 
                               value="<?php echo esc_attr(get_option('apex_story_badge_' . $page_slug, 'Our Story')); ?>" 
                               class="regular-text" placeholder="e.g., Our Story">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_story_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_story_heading" name="apex_story_heading" 
                               value="<?php echo esc_attr(get_option('apex_story_heading_' . $page_slug, 'From Vision to Reality')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the story section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_story_content">Story Content Paragraphs</label></th>
                    <td>
                        <textarea id="apex_story_content" name="apex_story_content" rows="12" class="large-text"
                                  placeholder="Founded in 2010, Apex Softwares began with a simple yet powerful vision: to democratize access to modern banking technology across Africa.&#10;Our journey has been defined by a relentless focus on innovation, customer success, and the belief that every financial institution—regardless of size—deserves access to world-class technology.&#10;Today, we continue to push boundaries, developing solutions that help our partners reach more customers, reduce costs, and compete effectively in an increasingly digital world."><?php 
                            $content = get_option('apex_story_content_' . $page_slug, "Founded in 2010, Apex Softwares began with a simple yet powerful vision: to democratize access to modern banking technology across Africa.\nOur journey has been defined by a relentless focus on innovation, customer success, and the belief that every financial institution—regardless of size—deserves access to world-class technology.\nToday, we continue to push boundaries, developing solutions that help our partners reach more customers, reduce costs, and compete effectively in an increasingly digital world.");
                            echo esc_textarea($content);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Each paragraph on a new line. These will be displayed as flowing text paragraphs.</p>
                        <p class="description"><strong>Example:</strong> First paragraph text here.[line break]Second paragraph text here.</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Write compelling story paragraphs that engage readers. Each line break creates a new paragraph on the frontend.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_story_milestones">Company Milestones</label></th>
                    <td>
                        <textarea id="apex_story_milestones" name="apex_story_milestones" rows="15" class="large-text"
                                  placeholder="2010 | Company Founded | Started with a vision to transform African banking&#10;2013 | First Major Client | Deployed ApexCore to our first SACCO partner&#10;2016 | Mobile Banking Launch | Introduced mobile and agent banking solutions&#10;2019 | Pan-African Expansion | Extended operations to 10+ African countries&#10;2022 | 100+ Clients Milestone | Reached 100 financial institution partners&#10;2024 | Next-Gen Platform | Launched cloud-native ApexCore 3.0"><?php 
                            $milestones = get_option('apex_story_milestones_' . $page_slug, "2010 | Company Founded | Started with a vision to transform African banking\n2013 | First Major Client | Deployed ApexCore to our first SACCO partner\n2016 | Mobile Banking Launch | Introduced mobile and agent banking solutions\n2019 | Pan-African Expansion | Extended operations to 10+ African countries\n2022 | 100+ Clients Milestone | Reached 100 financial institution partners\n2024 | Next-Gen Platform | Launched cloud-native ApexCore 3.0");
                            echo esc_textarea($milestones);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Year | Title | Description (one milestone per line)</p>
                        <p class="description"><strong>Example:</strong> 2010 | Company Founded | Started with a vision to transform African banking</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Milestones will be displayed in a timeline format. Use chronological order and highlight key achievements that showcase your growth.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Mission & Vision Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎯 Mission & Vision Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your mission, vision, and core values.</strong> Mission and vision appear as prominent cards with icons, followed by a grid of core value cards.</p>
                <p><strong>Format for values:</strong> Enter each value on a new line using this format:<br>
                <code>Icon Name | Title | Description</code></p>
                <p><strong>Available icons:</strong> lightbulb, handshake, shield, users, rocket, heart, wrench, message-circle, target, eye</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_mission_title">Mission Title</label></th>
                    <td>
                        <input type="text" id="apex_mission_title" name="apex_mission_title" 
                               value="<?php echo esc_attr(get_option('apex_mission_title_' . $page_slug, 'Our Mission')); ?>" 
                               class="regular-text" placeholder="e.g., Our Mission">
                        <p class="description">The title for your mission statement</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mission_description">Mission Description</label></th>
                    <td>
                        <textarea id="apex_mission_description" name="apex_mission_description" rows="4" class="large-text"
                                  placeholder="To empower financial institutions with innovative, accessible, and secure technology solutions that drive financial inclusion and economic growth across Africa."><?php 
                            $mission_desc = get_option('apex_mission_description_' . $page_slug, 'To empower financial institutions with innovative, accessible, and secure technology solutions that drive financial inclusion and economic growth across Africa.');
                            echo esc_textarea($mission_desc);
                        ?></textarea>
                        <p class="description">Detailed description of your company's mission</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_vision_title">Vision Title</label></th>
                    <td>
                        <input type="text" id="apex_vision_title" name="apex_vision_title" 
                               value="<?php echo esc_attr(get_option('apex_vision_title_' . $page_slug, 'Our Vision')); ?>" 
                               class="regular-text" placeholder="e.g., Our Vision">
                        <p class="description">The title for your vision statement</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_vision_description">Vision Description</label></th>
                    <td>
                        <textarea id="apex_vision_description" name="apex_vision_description" rows="4" class="large-text"
                                  placeholder="To be the leading financial technology partner in Africa, enabling every institution to deliver world-class digital banking experiences to their customers."><?php 
                            $vision_desc = get_option('apex_vision_description_' . $page_slug, 'To be the leading financial technology partner in Africa, enabling every institution to deliver world-class digital banking experiences to their customers.');
                            echo esc_textarea($vision_desc);
                        ?></textarea>
                        <p class="description">Detailed description of your company's vision</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_values">Core Values</label></th>
                    <td>
                        <textarea id="apex_values" name="apex_values" rows="20" class="large-text"
                                  placeholder="lightbulb | Innovation | We continuously push boundaries to deliver cutting-edge solutions that anticipate market needs.&#10;handshake | Partnership | We succeed when our clients succeed. Their growth is our primary measure of success.&#10;shield | Integrity | We operate with transparency, honesty, and the highest ethical standards in everything we do.&#10;users | Customer Focus | Every decision we make is guided by how it will benefit our clients and their customers.&#10;rocket | Excellence | We strive for excellence in our products, services, and every interaction with stakeholders.&#10;heart | Impact | We measure our success by the positive impact we create for communities across Africa."><?php 
                            $values = get_option('apex_values_' . $page_slug, "lightbulb | Innovation | We continuously push boundaries to deliver cutting-edge solutions that anticipate market needs.\nhandshake | Partnership | We succeed when our clients succeed. Their growth is our primary measure of success.\nshield | Integrity | We operate with transparency, honesty, and the highest ethical standards in everything we do.\nusers | Customer Focus | Every decision we make is guided by how it will benefit our clients and their customers.\nrocket | Excellence | We strive for excellence in our products, services, and every interaction with stakeholders.\nheart | Impact | We measure our success by the positive impact we create for communities across Africa.");
                            echo esc_textarea($values);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Icon Name | Title | Description (one value per line)</p>
                        <p class="description"><strong>Available icons:</strong> lightbulb, handshake, shield, users, rocket, heart, wrench, message-circle, target, eye</p>
                        <p class="description"><strong>Example:</strong> lightbulb | Innovation | We continuously push boundaries...</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Values will be displayed in a grid of cards with icons. Choose values that truly represent your company culture and choose appropriate icons for each.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Leadership Team Section -->
        <div style="margin-bottom: 30px;">
            <h4>👥 Leadership Team Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your leadership team with photos, bios, and social links.</strong> Each team member appears as a card with their photo, name, role, bio, and social media links.</p>
                <p><strong>Format for team members:</strong> Enter each member on a new line using this format:<br>
                <code>Name | Role | Image URL | Bio | LinkedIn URL | Twitter URL</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_leadership_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_leadership_badge" name="apex_leadership_badge" 
                               value="<?php echo esc_attr(get_option('apex_leadership_badge_' . $page_slug, 'Leadership')); ?>" 
                               class="regular-text" placeholder="e.g., Leadership">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_leadership_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_leadership_heading" name="apex_leadership_heading" 
                               value="<?php echo esc_attr(get_option('apex_leadership_heading_' . $page_slug, 'Meet Our Team')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the leadership section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_leadership_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_leadership_description" name="apex_leadership_description" rows="3" class="large-text"
                                  placeholder="Our leadership team brings together decades of experience in financial technology, banking, and software development."><?php 
                            $leadership_desc = get_option('apex_leadership_description_' . $page_slug, 'Our leadership team brings together decades of experience in financial technology, banking, and software development.');
                            echo esc_textarea($leadership_desc);
                        ?></textarea>
                        <p class="description">Brief description of your leadership team</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_team_members">Team Members</label></th>
                    <td>
                        <textarea id="apex_team_members" name="apex_team_members" rows="25" class="large-text"
                                  placeholder="John Kamau | Chief Executive Officer | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400 | With 20+ years in fintech, John leads our vision to transform African banking. | https://linkedin.com/in/johnkamau | https://twitter.com/johnkamau&#10;Sarah Ochieng | Chief Technology Officer | https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400 | Sarah drives our technology strategy and product innovation initiatives. | https://linkedin.com/in/sarahochieng | https://twitter.com/sarahochieng"><?php 
                            $team = get_option('apex_team_members_' . $page_slug, "John Kamau | Chief Executive Officer | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400 | With 20+ years in fintech, John leads our vision to transform African banking. | # | #\nSarah Ochieng | Chief Technology Officer | https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400 | Sarah drives our technology strategy and product innovation initiatives. | # | #\nMichael Njoroge | Chief Operations Officer | https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400 | Michael ensures operational excellence across all our client implementations. | # | #\nGrace Wanjiku | Chief Financial Officer | https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400 | Grace oversees our financial strategy and sustainable growth initiatives. | # | #");
                            echo esc_textarea($team);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Name | Role | Image URL | Bio | LinkedIn URL | Twitter URL (one member per line)</p>
                        <p class="description"><strong>Example:</strong> John Kamau | Chief Executive Officer | https://image-url.jpg | Bio text here... | https://linkedin.com/profile | https://twitter.com/handle</p>
                        <p class="description"><strong>Note:</strong> Use # for social links if you don't have them</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Team members will be displayed in a grid of cards. Use professional headshot photos (400x400px recommended). Write compelling bios highlighting experience and achievements.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Our Reach Section -->
        <div style="margin-bottom: 30px;">
            <h4>🌍 Our Reach Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your global presence with regional coverage and headquarters information.</strong> Regions display with country lists and client counts, followed by headquarters location details.</p>
                <p><strong>Format for regions:</strong> Enter each region on a new line using this format:<br>
                <code>Region Name | Countries (comma-separated) | Client Count</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reach_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_reach_badge" name="apex_reach_badge" 
                               value="<?php echo esc_attr(get_option('apex_reach_badge_' . $page_slug, 'Our Reach')); ?>" 
                               class="regular-text" placeholder="e.g., Our Reach">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reach_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_reach_heading" name="apex_reach_heading" 
                               value="<?php echo esc_attr(get_option('apex_reach_heading_' . $page_slug, 'Pan-African Presence')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the reach section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reach_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_reach_description" name="apex_reach_description" rows="3" class="large-text"
                                  placeholder="From our headquarters in Nairobi, we serve financial institutions across the African continent."><?php 
                            $reach_desc = get_option('apex_reach_description_' . $page_slug, 'From our headquarters in Nairobi, we serve financial institutions across the African continent.');
                            echo esc_textarea($reach_desc);
                        ?></textarea>
                        <p class="description">Brief description of your geographical presence</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_regions">Regional Presence</label></th>
                    <td>
                        <textarea id="apex_regions" name="apex_regions" rows="15" class="large-text"
                                  placeholder="East Africa | Kenya, Uganda, Tanzania, Rwanda, Ethiopia | 60+&#10;West Africa | Nigeria, Ghana, Senegal, Ivory Coast | 25+&#10;Southern Africa | South Africa, Zambia, Zimbabwe, Malawi | 15+&#10;Central Africa | DRC, Cameroon | 5+"><?php 
                            $regions = get_option('apex_regions_' . $page_slug, "East Africa | Kenya, Uganda, Tanzania, Rwanda, Ethiopia | 60+\nWest Africa | Nigeria, Ghana, Senegal, Ivory Coast | 25+\nSouthern Africa | South Africa, Zambia, Zimbabwe, Malawi | 15+\nCentral Africa | DRC, Cameroon | 5+");
                            echo esc_textarea($regions);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Region Name | Countries (comma-separated) | Client Count (one region per line)</p>
                        <p class="description"><strong>Example:</strong> East Africa | Kenya, Uganda, Tanzania, Rwanda, Ethiopia | 60+</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Regions will be displayed with country flags and client counts. List all countries in each region where you have clients. Client counts show your market presence strength.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_headquarters_city">Headquarters City</label></th>
                    <td>
                        <input type="text" id="apex_headquarters_city" name="apex_headquarters_city" 
                               value="<?php echo esc_attr(get_option('apex_headquarters_city_' . $page_slug, 'Nairobi')); ?>" 
                               class="regular-text" placeholder="e.g., Nairobi">
                        <p class="description">The city where your headquarters is located</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_headquarters_country">Headquarters Country</label></th>
                    <td>
                        <input type="text" id="apex_headquarters_country" name="apex_headquarters_country" 
                               value="<?php echo esc_attr(get_option('apex_headquarters_country_' . $page_slug, 'Kenya')); ?>" 
                               class="regular-text" placeholder="e.g., Kenya">
                        <p class="description">The country where your headquarters is located</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_headquarters_address">Headquarters Address</label></th>
                    <td>
                        <input type="text" id="apex_headquarters_address" name="apex_headquarters_address" 
                               value="<?php echo esc_attr(get_option('apex_headquarters_address_' . $page_slug, 'Westlands Business Park, 4th Floor')); ?>" 
                               class="large-text" placeholder="Full street address">
                        <p class="description">The complete street address of your headquarters</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Headquarters information appears prominently at the bottom of the section. Include specific details that help clients locate and visit your offices.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'about-us-our-approach'): ?>
        <!-- Our Approach Specific Sections -->

        <!-- Our Methodology Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔄 Our Methodology Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays your 5-phase implementation methodology.</strong> Each phase includes a title, detailed description, and bullet points explaining key activities.</p>
                <p><strong>Format for phases:</strong> Enter each phase on a new line using this format:<br>
                <code>Phase Number | Title | Description | Bullet1, Bullet2, Bullet3, Bullet4</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_methodology_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_methodology_badge" name="apex_methodology_badge" 
                               value="<?php echo esc_attr(get_option('apex_methodology_badge_' . $page_slug, 'Our Methodology')); ?>" 
                               class="regular-text" placeholder="e.g., Our Methodology">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_methodology_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_methodology_heading" name="apex_methodology_heading" 
                               value="<?php echo esc_attr(get_option('apex_methodology_heading_' . $page_slug, 'A Proven Framework for Success')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the methodology section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_methodology_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_methodology_description" name="apex_methodology_description" rows="3" class="large-text"
                                  placeholder="Section description"><?php 
                            $methodology_desc = get_option('apex_methodology_description_' . $page_slug, 'We follow a structured yet flexible approach that ensures every implementation delivers maximum value while minimizing risk.');
                            echo esc_textarea($methodology_desc);
                        ?></textarea>
                        <p class="description">Brief description of your methodology approach</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_methodology_phases">Methodology Phases</label></th>
                    <td>
                        <textarea id="apex_methodology_phases" name="apex_methodology_phases" rows="25" class="large-text"
                                  placeholder="01 | Discovery & Assessment | We begin by deeply understanding your institution's unique challenges, goals, and existing infrastructure. Our team conducts comprehensive assessments to identify opportunities for optimization and growth. | Stakeholder interviews and requirements gathering, Current system and process analysis, Gap analysis and opportunity identification, Regulatory compliance review&#10;02 | Solution Design | Based on our findings, we design a tailored solution architecture that addresses your specific needs while leveraging the full power of the ApexCore platform. | Custom solution architecture design, Integration mapping and API planning, User experience and workflow design, Security and compliance framework"><?php 
                            $phases = get_option('apex_methodology_phases_' . $page_slug, "01 | Discovery & Assessment | We begin by deeply understanding your institution's unique challenges, goals, and existing infrastructure. Our team conducts comprehensive assessments to identify opportunities for optimization and growth. | Stakeholder interviews and requirements gathering, Current system and process analysis, Gap analysis and opportunity identification, Regulatory compliance review\n02 | Solution Design | Based on our findings, we design a tailored solution architecture that addresses your specific needs while leveraging the full power of the ApexCore platform. | Custom solution architecture design, Integration mapping and API planning, User experience and workflow design, Security and compliance framework\n03 | Agile Implementation | Our agile development methodology ensures rapid delivery with continuous feedback loops. We work in sprints, delivering functional components that you can test and validate. | Iterative development with 2-week sprints, Continuous integration and testing, Regular demos and stakeholder reviews, Parallel data migration and validation\n04 | Training & Change Management | Technology is only as good as the people using it. We invest heavily in training and change management to ensure your team is confident and capable. | Role-based training programs, Train-the-trainer sessions, Comprehensive documentation and guides, Change management support\n05 | Go-Live & Optimization | We ensure a smooth transition to production with comprehensive support. Post-launch, we continue to optimize and enhance your solution based on real-world usage. | Phased rollout strategy, Hypercare support period, Performance monitoring and optimization, Continuous improvement roadmap");
                            echo esc_textarea($phases);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Phase Number | Title | Description | Bullet1, Bullet2, Bullet3, Bullet4 (one phase per line)</p>
                        <p class="description"><strong>Example:</strong> 01 | Discovery & Assessment | We begin by deeply understanding... | Stakeholder interviews..., Current system analysis..., Gap analysis..., Regulatory compliance...</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Each phase will be displayed with a numbered circle, title, description paragraph, and bullet points. Use commas to separate bullet points.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Guiding Principles Section -->
        <div style="margin-bottom: 30px;">
            <h4>💎 Guiding Principles Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays your core guiding principles in a beautiful grid layout.</strong> Each principle includes an icon, title, and detailed description explaining your values and approach.</p>
                <p><strong>Format for principles:</strong> Enter each principle on a new line using this format:<br>
                <code>Icon Name | Title | Description</code></p>
                <p><strong>Available icons:</strong> users, shield, clock, arrow-up, wrench, message-circle, lightbulb, handshake, rocket, heart</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_principles_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_principles_badge" name="apex_principles_badge" 
                               value="<?php echo esc_attr(get_option('apex_principles_badge_' . $page_slug, 'Guiding Principles')); ?>" 
                               class="regular-text" placeholder="e.g., Guiding Principles">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_principles_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_principles_heading" name="apex_principles_heading" 
                               value="<?php echo esc_attr(get_option('apex_principles_heading_' . $page_slug, 'What Sets Us Apart')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the principles section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_principles_cards">Principle Cards</label></th>
                    <td>
                        <textarea id="apex_principles_cards" name="apex_principles_cards" rows="30" class="large-text"
                                  placeholder="users | Client-Centric Focus | Every decision we make is guided by what's best for our clients. We measure our success by your success, not by the number of features we ship.&#10;shield | Security First | Security isn't an afterthought—it's built into everything we do. From architecture to deployment, we follow industry best practices and regulatory requirements.&#10;clock | Speed to Value | We understand that time is money. Our proven methodology and pre-built components enable rapid deployment without sacrificing quality or customization."><?php 
                            $principles = get_option('apex_principles_cards_' . $page_slug, "users | Client-Centric Focus | Every decision we make is guided by what's best for our clients. We measure our success by your success, not by the number of features we ship.\nshield | Security First | Security isn't an afterthought—it's built into everything we do. From architecture to deployment, we follow industry best practices and regulatory requirements.\nclock | Speed to Value | We understand that time is money. Our proven methodology and pre-built components enable rapid deployment without sacrificing quality or customization.\narrow-up | Scalable Architecture | Our solutions are designed to grow with you. Whether you're serving 1,000 or 1 million customers, our platform scales seamlessly to meet demand.\nwrench | Continuous Innovation | The financial industry never stands still, and neither do we. We continuously invest in R&D to bring you the latest technologies and capabilities.\nmessage-circle | Transparent Communication | We believe in open, honest communication. You'll always know where your project stands, what challenges we're facing, and how we're addressing them.");
                            echo esc_textarea($principles);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Icon Name | Title | Description (one principle per line)</p>
                        <p class="description"><strong>Available icons:</strong> users, shield, clock, arrow-up, wrench, message-circle, lightbulb, handshake, rocket, heart</p>
                        <p class="description"><strong>Example:</strong> users | Client-Centric Focus | Every decision we make is guided by what's best for our clients...</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Each principle will be displayed as a card with an icon, title, and description. Choose icons that best represent each principle. You can add up to 6 principles.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Ongoing Partnership Section -->
        <div style="margin-bottom: 30px;">
            <h4>🤝 Ongoing Partnership Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your ongoing support and partnership commitment.</strong> It includes 4 support features with icons and descriptions, plus 3 key statistics demonstrating your service quality.</p>
                <p><strong>Format for features:</strong> Enter each feature on a new line using this format:<br>
                <code>Icon Name | Title | Description</code></p>
                <p><strong>Format for statistics:</strong> Enter each stat on a new line using this format:<br>
                <code>Value | Label</code></p>
                <p><strong>Available icons:</strong> clock, edit-3, book-open, users, shield, heart, message-circle, rocket</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_support_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_support_badge" name="apex_support_badge" 
                               value="<?php echo esc_attr(get_option('apex_support_badge_' . $page_slug, 'Ongoing Partnership')); ?>" 
                               class="regular-text" placeholder="e.g., Ongoing Partnership">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_support_heading" name="apex_support_heading" 
                               value="<?php echo esc_attr(get_option('apex_support_heading_' . $page_slug, 'Support That Never Sleeps')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the partnership section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_support_description" name="apex_support_description" rows="3" class="large-text"
                                  placeholder="Section description"><?php 
                            $support_desc = get_option('apex_support_description_' . $page_slug, 'Our relationship doesn\'t end at go-live. We provide comprehensive support and continuous improvement services to ensure your platform evolves with your business.');
                            echo esc_textarea($support_desc);
                        ?></textarea>
                        <p class="description">Brief description of your partnership commitment</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_features">Support Features</label></th>
                    <td>
                        <textarea id="apex_support_features" name="apex_support_features" rows="20" class="large-text"
                                  placeholder="clock | 24/7 Technical Support | Round-the-clock access to our expert support team via phone, email, and chat.&#10;edit-3 | Regular Updates | Quarterly platform updates with new features, security patches, and performance improvements.&#10;book-open | Knowledge Base | Comprehensive documentation, tutorials, and best practices at your fingertips.&#10;users | Dedicated Success Manager | A single point of contact who understands your business and advocates for your needs."><?php 
                            $features = get_option('apex_support_features_' . $page_slug, "clock | 24/7 Technical Support | Round-the-clock access to our expert support team via phone, email, and chat.\nedit-3 | Regular Updates | Quarterly platform updates with new features, security patches, and performance improvements.\nbook-open | Knowledge Base | Comprehensive documentation, tutorials, and best practices at your fingertips.\nusers | Dedicated Success Manager | A single point of contact who understands your business and advocates for your needs.");
                            echo esc_textarea($features);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Icon Name | Title | Description (one feature per line)</p>
                        <p class="description"><strong>Available icons:</strong> clock, edit-3, book-open, users, shield, heart, message-circle, rocket</p>
                        <p class="description"><strong>Example:</strong> clock | 24/7 Technical Support | Round-the-clock access to our expert support team...</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Each feature will be displayed with an icon, title, and description. These showcase your ongoing commitment to client success.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_stats">Support Statistics</label></th>
                    <td>
                        <textarea id="apex_support_stats" name="apex_support_stats" rows="8" class="large-text"
                                  placeholder="<15min | Average Response Time&#10;95% | First Call Resolution&#10;4.9/5 | Customer Satisfaction"><?php 
                            $stats = get_option('apex_support_stats_' . $page_slug, "<15min | Average Response Time\n95% | First Call Resolution\n4.9/5 | Customer Satisfaction");
                            echo esc_textarea($stats);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Value | Label (one statistic per line)</p>
                        <p class="description"><strong>Example:</strong> <15min | Average Response Time</p>
                        <p class="description"><strong>Example:</strong> 95% | First Call Resolution</p>
                        <p class="description"><strong>Example:</strong> 4.9/5 | Customer Satisfaction</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Statistics will be displayed in prominent cards. Use values that demonstrate your service quality and commitment to clients.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        }

        <?php elseif ($page_slug === 'about-us-leadership-team'): ?>
        <!-- Leadership Team Specific Sections -->

        <!-- Executive Team Section -->
        <div style="margin-bottom: 30px;">
            <h4>👔 Executive Team Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your executive leadership team with detailed profiles.</strong> Each executive member includes their photo, name, role, comprehensive bio, and social media links.</p>
                <p><strong>Format for executive members:</strong> Enter each executive on a new line using this format:<br>
                <code>Name | Role | Image URL | Bio Paragraph 1 | Bio Paragraph 2 | LinkedIn URL | Twitter URL</code></p>
            </div>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_executive_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_executive_badge" name="apex_executive_badge"
                               value="<?php echo esc_attr(get_option('apex_executive_badge_' . $page_slug, 'Executive Team')); ?>"
                               class="regular-text" placeholder="e.g., Executive Team">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_executive_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_executive_heading" name="apex_executive_heading"
                               value="<?php echo esc_attr(get_option('apex_executive_heading_' . $page_slug, 'Executive Leadership')); ?>"
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the executive team section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_executive_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_executive_description" name="apex_executive_description" rows="3" class="large-text"
                                  placeholder="Our executive team brings together visionary leaders with deep expertise in financial services, technology, and business transformation."><?php
                            $exec_desc = get_option('apex_executive_description_' . $page_slug, 'Our executive team brings together visionary leaders with deep expertise in financial services, technology, and business transformation.');
                            echo esc_textarea($exec_desc);
                        ?></textarea>
                        <p class="description">Brief description of your executive leadership team</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_executive_members">Executive Team Members</label></th>
                    <td>
                        <textarea id="apex_executive_members" name="apex_executive_members" rows="35" class="large-text"
                                  placeholder="John Kamau | Chief Executive Officer | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400 | John founded Apex Softwares in 2010 with a vision to democratize access to modern banking technology across Africa. With over 25 years of experience in financial services and technology, he has led the company from a small startup to a leading fintech provider serving 100+ institutions. | Prior to Apex, John held senior positions at Standard Chartered Bank and Accenture, where he led digital transformation initiatives across East Africa. | https://linkedin.com/in/johnkamau | https://twitter.com/johnkamau&#10;Sarah Ochieng | Chief Technology Officer | https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400 | Sarah leads our technology strategy and product innovation, overseeing a team of 80+ engineers. She is passionate about building scalable, secure systems that empower financial inclusion across Africa. | Before joining Apex, Sarah was VP of Engineering at Safaricom, where she led the development of M-Pesa's core platform. She holds a Master's in Computer Science from MIT. | https://linkedin.com/in/sarahochieng | https://twitter.com/sarahochieng"><?php
                            $exec_members = get_option('apex_executive_members_' . $page_slug, "John Kamau | Chief Executive Officer | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400 | John founded Apex Softwares in 2010 with a vision to democratize access to modern banking technology across Africa. With over 25 years of experience in financial services and technology, he has led the company from a small startup to a leading fintech provider serving 100+ institutions. | Prior to Apex, John held senior positions at Standard Chartered Bank and Accenture, where he led digital transformation initiatives across East Africa. | # | #\nSarah Ochieng | Chief Technology Officer | https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400 | Sarah leads our technology strategy and product innovation, overseeing a team of 80+ engineers. She is passionate about building scalable, secure systems that empower financial inclusion across Africa. | Before joining Apex, Sarah was VP of Engineering at Safaricom, where she led the development of M-Pesa's core platform. She holds a Master's in Computer Science from MIT. | # | #\nMichael Njoroge | Chief Operations Officer | https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400 | Michael ensures operational excellence across all client implementations and internal processes. He has successfully overseen 100+ core banking implementations across 15 African countries. | Michael previously served as Director of Operations at Temenos for Sub-Saharan Africa, managing a portfolio of 50+ banking clients. | # | #\nGrace Wanjiku | Chief Financial Officer | https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400 | Grace oversees financial strategy, investor relations, and sustainable growth initiatives. Under her leadership, Apex has achieved profitability while maintaining aggressive investment in R&D. | Grace is a CPA with 18 years of experience in financial management. She previously served as CFO at Cellulant and held senior finance roles at Deloitte East Africa. | # | #");
                            echo esc_textarea($exec_members);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Name | Role | Image URL | Bio Paragraph 1 | Bio Paragraph 2 | LinkedIn URL | Twitter URL (one executive per line)</p>
                        <p class="description"><strong>Example:</strong> John Kamau | Chief Executive Officer | https://image-url.jpg | First bio paragraph... | Second bio paragraph... | https://linkedin.com/profile | https://twitter.com/handle</p>
                        <p class="description"><strong>Note:</strong> Use # for social links if you don't have them</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Executive profiles appear in a prominent grid layout. Use professional headshot photos (400x400px recommended). Write compelling bios that highlight experience, achievements, and previous roles.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Senior Leadership Section -->
        <div style="margin-bottom: 30px;">
            <h4>👥 Senior Leadership Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your senior leadership team in a clean grid layout.</strong> Each senior leader includes their photo, name, and role title.</p>
                <p><strong>Format for senior leaders:</strong> Enter each leader on a new line using this format:<br>
                <code>Name | Role | Image URL</code></p>
            </div>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_senior_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_senior_heading" name="apex_senior_heading"
                               value="<?php echo esc_attr(get_option('apex_senior_heading_' . $page_slug, 'Senior Leadership')); ?>"
                               class="regular-text" placeholder="e.g., Senior Leadership">
                        <p class="description">The main heading for the senior leadership section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_senior_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_senior_description" name="apex_senior_description" rows="2" class="large-text"
                                  placeholder="Our senior leaders drive excellence across every function of the organization."><?php
                            $senior_desc = get_option('apex_senior_description_' . $page_slug, 'Our senior leaders drive excellence across every function of the organization.');
                            echo esc_textarea($senior_desc);
                        ?></textarea>
                        <p class="description">Brief description of your senior leadership team</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_senior_members">Senior Leadership Team</label></th>
                    <td>
                        <textarea id="apex_senior_members" name="apex_senior_members" rows="20" class="large-text"
                                  placeholder="David Mutua | VP, Product Management | https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300&#10;Amina Hassan | VP, Customer Success | https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?w=300&#10;Peter Otieno | VP, Engineering | https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&#10;Faith Mwende | VP, Human Resources | https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=300"><?php
                            $senior_members = get_option('apex_senior_members_' . $page_slug, "David Mutua | VP, Product Management | https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300\nAmina Hassan | VP, Customer Success | https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?w=300\nPeter Otieno | VP, Engineering | https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300\nFaith Mwende | VP, Human Resources | https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=300\nJames Kariuki | VP, Sales & Partnerships | https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300\nLinda Achieng | VP, Marketing | https://images.unsplash.com/photo-1598550874175-4d0ef436c909?w=300\nSamuel Omondi | Director, Security & Compliance | https://images.unsplash.com/photo-1507591064344-4c6ce005b128?w=300\nChristine Wairimu | Director, Professional Services | https://images.unsplash.com/photo-1589156280159-27698a70f29e?w=300");
                            echo esc_textarea($senior_members);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Name | Role | Image URL (one leader per line)</p>
                        <p class="description"><strong>Example:</strong> David Mutua | VP, Product Management | https://image-url.jpg</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Senior leaders appear in a clean grid layout. Use professional headshot photos (300x300px recommended). Keep roles clear and descriptive.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Our Culture Section -->
        <div style="margin-bottom: 30px;">
            <h4>🏢 Our Culture Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section promotes your company culture and career opportunities.</strong> It includes culture description, benefits list, call-to-action button, and hero image.</p>
                <p><strong>Format for benefits:</strong> Enter each benefit on a new line using this format:<br>
                <code>Icon Name | Benefit Description</code></p>
                <p><strong>Available icons:</strong> check, users, book-open, heart, rocket, shield, message-circle</p>
            </div>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_culture_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_culture_badge" name="apex_culture_badge"
                               value="<?php echo esc_attr(get_option('apex_culture_badge_' . $page_slug, 'Our Culture')); ?>"
                               class="regular-text" placeholder="e.g., Our Culture">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_culture_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_culture_heading" name="apex_culture_heading"
                               value="<?php echo esc_attr(get_option('apex_culture_heading_' . $page_slug, 'Join Our Team')); ?>"
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the culture section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_culture_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_culture_description" name="apex_culture_description" rows="3" class="large-text"
                                  placeholder="We're always looking for talented individuals who share our passion for transforming financial services in Africa. At Apex, you'll work on challenging problems, learn from industry experts, and make a real impact."><?php
                            $culture_desc = get_option('apex_culture_description_' . $page_slug, "We're always looking for talented individuals who share our passion for transforming financial services in Africa. At Apex, you'll work on challenging problems, learn from industry experts, and make a real impact.");
                            echo esc_textarea($culture_desc);
                        ?></textarea>
                        <p class="description">Description of your company culture and career opportunities</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_culture_benefits">Culture Benefits</label></th>
                    <td>
                        <textarea id="apex_culture_benefits" name="apex_culture_benefits" rows="12" class="large-text"
                                  placeholder="check | Competitive compensation & equity&#10;check | Flexible remote work options&#10;check | Learning & development budget&#10;check | Health insurance for you & family"><?php
                            $benefits = get_option('apex_culture_benefits_' . $page_slug, "check | Competitive compensation & equity\ncheck | Flexible remote work options\ncheck | Learning & development budget\ncheck | Health insurance for you & family");
                            echo esc_textarea($benefits);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Icon Name | Benefit Description (one benefit per line)</p>
                        <p class="description"><strong>Available icons:</strong> check, users, book-open, heart, rocket, shield, message-circle</p>
                        <p class="description"><strong>Example:</strong> check | Competitive compensation & equity</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Benefits appear with icons in a grid layout. Use the check icon for most benefits, or choose icons that best represent each benefit.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_culture_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_culture_cta_text" name="apex_culture_cta_text"
                               value="<?php echo esc_attr(get_option('apex_culture_cta_text_' . $page_slug, 'View Open Positions')); ?>"
                               class="regular-text" placeholder="e.g., View Open Positions">
                        <p class="description">Text for the call-to-action button</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_culture_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_culture_cta_url" name="apex_culture_cta_url"
                               value="<?php echo esc_attr(get_option('apex_culture_cta_url_' . $page_slug, home_url('/careers'))); ?>"
                               class="large-text" placeholder="https://yoursite.com/careers">
                        <p class="description">URL where the CTA button should link to</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_culture_image">Culture Section Image</label></th>
                    <td>
                        <input type="url" id="apex_culture_image" name="apex_culture_image"
                               value="<?php echo esc_attr(get_option('apex_culture_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600')); ?>"
                               class="large-text" placeholder="https://example.com/culture-image.jpg">
                        <p class="description">Hero image for the culture section (recommended size: 600x400px)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use a team photo or office image that represents your company culture. This image appears prominently alongside the culture content.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'about-us-news'): ?>
        <!-- News & Updates Specific Sections -->
        
        <!-- Featured Story Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Featured Story Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays a featured news story prominently at the top of the news page.</strong> It includes an image, category badge, date, title, excerpt, and link to the full story.</p>
                <p><strong>Best practices:</strong> Choose your most important or recent announcement. Use high-quality images and compelling copy that encourages readers to learn more.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_featured_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_featured_badge" name="apex_featured_badge" 
                               value="<?php echo esc_attr(get_option('apex_featured_badge_' . $page_slug, 'Featured Story')); ?>" 
                               class="regular-text" placeholder="e.g., Featured Story">
                        <p class="description">The small badge text above the featured story</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_featured_image">Featured Story Image</label></th>
                    <td>
                        <input type="url" id="apex_featured_image" name="apex_featured_image" 
                               value="<?php echo esc_attr(get_option('apex_featured_image_' . $page_slug, 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800')); ?>" 
                               class="large-text" placeholder="https://example.com/featured-image.jpg">
                        <p class="description">The featured story image URL (recommended size: 800x600px)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use a high-quality, relevant image that captures attention. This image appears prominently at the top of your news page and should represent your featured story well.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_featured_category">Category</label></th>
                    <td>
                        <input type="text" id="apex_featured_category" name="apex_featured_category" 
                               value="<?php echo esc_attr(get_option('apex_featured_category_' . $page_slug, 'Product Launch')); ?>" 
                               class="regular-text" placeholder="e.g., Product Launch">
                        <p class="description">The category label for the featured story</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_featured_date">Publication Date</label></th>
                    <td>
                        <input type="text" id="apex_featured_date" name="apex_featured_date" 
                               value="<?php echo esc_attr(get_option('apex_featured_date_' . $page_slug, 'January 15, 2026')); ?>" 
                               class="regular-text" placeholder="e.g., January 15, 2026">
                        <p class="description">The publication date of the featured story</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use the format "Month Day, Year" (e.g., "January 15, 2026"). This helps establish the recency and relevance of your announcement.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_featured_title">Story Title</label></th>
                    <td>
                        <input type="text" id="apex_featured_title" name="apex_featured_title" 
                               value="<?php echo esc_attr(get_option('apex_featured_title_' . $page_slug, 'Apex Softwares Launches ApexCore 3.0: The Next Generation of Core Banking')); ?>" 
                               class="large-text" placeholder="Featured story title">
                        <p class="description">The main title of the featured story</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Write a compelling, descriptive title that clearly communicates the news. Keep it under 100 characters for best readability and SEO.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_featured_excerpt">Story Excerpt</label></th>
                    <td>
                        <textarea id="apex_featured_excerpt" name="apex_featured_excerpt" rows="6" class="large-text"
                                  placeholder="We're excited to announce the launch of ApexCore 3.0, our most advanced core banking platform yet. This major release introduces cloud-native architecture, AI-powered analytics, and enhanced API capabilities."><?php 
                            $excerpt = get_option('apex_featured_excerpt_' . $page_slug, "We're excited to announce the launch of ApexCore 3.0, our most advanced core banking platform yet. This major release introduces cloud-native architecture, AI-powered analytics, and enhanced API capabilities that will transform how financial institutions operate.\n\nKey highlights include 10x faster transaction processing, real-time fraud detection, and a completely redesigned user interface that reduces training time by 60%.");
                            echo esc_textarea($excerpt);
                        ?></textarea>
                        <p class="description">The excerpt/content of the featured story</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Write 2-3 paragraphs that summarize the key points of your news. Include the most important information first. Use paragraph breaks (empty lines) to separate ideas.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_featured_link">Read More Link</label></th>
                    <td>
                        <input type="url" id="apex_featured_link" name="apex_featured_link" 
                               value="<?php echo esc_attr(get_option('apex_featured_link_' . $page_slug, '#')); ?>" 
                               class="large-text" placeholder="https://example.com/full-story">
                        <p class="description">The URL for the full story (leave empty to disable link)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Link to the full press release, blog post, or external article. If you don't have a full article yet, use "#" to create a placeholder link.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- News Grid Section -->
        <div style="margin-bottom: 30px;">
            <h4>📰 News Grid Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays a grid of news items with filtering capabilities.</strong> Each item includes an image, category, date, title, excerpt, and link. Users can filter by category.</p>
                <p><strong>Format for news items:</strong> Enter each news item on a new line using this format:<br>
                <code>Image URL | Category | Filter | Date | Title | Excerpt | Link</code></p>
                <p><strong>Filter categories:</strong> all, product, company, industry</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_news_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_news_heading" name="apex_news_heading" 
                               value="<?php echo esc_attr(get_option('apex_news_heading_' . $page_slug, 'Recent News')); ?>" 
                               class="regular-text" placeholder="e.g., Recent News">
                        <p class="description">The heading for the news grid section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_news_filters">Filter Categories</label></th>
                    <td>
                        <textarea id="apex_news_filters" name="apex_news_filters" rows="4" class="large-text"
                                  placeholder="All | all&#10;Product | product&#10;Company | company&#10;Industry | industry"><?php 
                            $filters = get_option('apex_news_filters_' . $page_slug, "All | all\nProduct | product\nCompany | company\nIndustry | industry");
                            echo esc_textarea($filters);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Display Name | Filter Value (one filter per line)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> These create the filter buttons above the news grid. The filter value should match the filter used in news items. Keep display names short and clear.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_news_items">News Items</label></th>
                    <td>
                        <textarea id="apex_news_items" name="apex_news_items" rows="20" class="large-text"
                                  placeholder="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400 | Company News | company | January 8, 2026 | Apex Softwares Raises $25M Series B | Investment led by TLcom Capital will fuel expansion into West and Southern Africa. | #&#10;https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400 | Product Update | product | December 20, 2025 | New Mobile Banking Features | Our latest mobile banking update introduces biometric authentication. | #"><?php 
                            $items = get_option('apex_news_items_' . $page_slug, "https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400 | Company News | company | January 8, 2026 | Apex Softwares Raises $25M Series B to Accelerate Pan-African Expansion | Investment led by TLcom Capital will fuel expansion into West and Southern Africa, with plans to double the team by end of 2026. | #\nhttps://images.unsplash.com/photo-1563986768609-322da13575f3?w=400 | Product Update | product | December 20, 2025 | New Mobile Banking Features: Biometric Authentication and Instant Loans | Our latest mobile banking update introduces fingerprint and face ID authentication, plus instant loan disbursement in under 60 seconds. | #\nhttps://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400 | Industry Insight | industry | December 15, 2025 | 2025 African Financial Inclusion Report | Our annual report analyzes the state of financial inclusion across Africa. | #\nhttps://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400 | Awards | company | November 28, 2025 | Apex Softwares Wins Best Core Banking Provider | Recognition for innovation and impact in transforming financial services. | #\nhttps://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400 | Product Launch | product | November 15, 2025 | Introducing ApexConnect API Marketplace | Connect with 50+ pre-built integrations including payment gateways. | #\nhttps://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400 | Expansion | company | November 1, 2025 | Apex Softwares Opens New Office in Lagos | Strategic expansion to better serve our growing client base in West Africa. | #");
                            echo esc_textarea($items);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Image URL | Category | Filter | Date | Title | Excerpt | Link (one item per line)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Each news item appears as a card in the grid. Use high-quality images (400x300px recommended). Keep titles concise and excerpts brief (1-2 sentences). Use "#" for links if you don't have full articles yet.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_news_load_more">Load More Button Text</label></th>
                    <td>
                        <input type="text" id="apex_news_load_more" name="apex_news_load_more" 
                               value="<?php echo esc_attr(get_option('apex_news_load_more_' . $page_slug, 'Load More Articles')); ?>" 
                               class="regular-text" placeholder="e.g., Load More Articles">
                        <p class="description">The text for the load more button (links to insights/blog)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> This button automatically links to your insights/blog page. Use clear, action-oriented text that encourages users to explore more content.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Press Section -->
        <div style="margin-bottom: 30px;">
            <h4>📺 In the Press Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases media mentions and press coverage.</strong> Each item includes the publication name, a quote, and link to the full article.</p>
                <p><strong>Format for press items:</strong> Enter each press mention on a new line using this format:<br>
                <code>Publication Name | Quote | Link</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_press_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_press_heading" name="apex_press_heading" 
                               value="<?php echo esc_attr(get_option('apex_press_heading_' . $page_slug, 'In the Press')); ?>" 
                               class="regular-text" placeholder="e.g., In the Press">
                        <p class="description">The heading for the press section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_press_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_press_description" name="apex_press_description" rows="2" class="large-text"
                                  placeholder="What leading publications are saying about Apex Softwares"><?php 
                            $press_desc = get_option('apex_press_description_' . $page_slug, "What leading publications are saying about Apex Softwares");
                            echo esc_textarea($press_desc);
                        ?></textarea>
                        <p class="description">Brief description of the press section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_press_items">Press Items</label></th>
                    <td>
                        <textarea id="apex_press_items" name="apex_press_items" rows="12" class="large-text"
                                  placeholder="TechCrunch | Apex Softwares is quietly becoming the Stripe of African banking infrastructure. | #&#10;Bloomberg | The Kenyan fintech is powering a digital banking revolution across the continent. | #"><?php 
                            $press_items = get_option('apex_press_items_' . $page_slug, "TechCrunch | \"Apex Softwares is quietly becoming the Stripe of African banking infrastructure.\" | #\nBloomberg | \"The Kenyan fintech is powering a digital banking revolution across the continent.\" | #\nForbes Africa | \"One of Africa's most promising B2B fintech companies, enabling financial inclusion at scale.\" | #\nQuartz Africa | \"Apex's technology is helping SACCOs and MFIs compete with traditional banks.\" | #");
                            echo esc_textarea($press_items);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Publication Name | Quote | Link (one item per line)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use exact quotes from publications when possible. Include well-known publications to build credibility. Use "#" for links if articles aren't available yet. Keep quotes concise and impactful.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Newsletter Section -->
        <div style="margin-bottom: 30px;">
            <h4>📧 Newsletter Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section encourages visitors to subscribe to your newsletter.</strong> It includes a heading, description, signup form, and privacy note.</p>
                <p><strong>Integration:</strong> Configure the form action URL to connect with your email marketing service (Mailchimp, ConvertKit, etc.).</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_newsletter_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_newsletter_heading" name="apex_newsletter_heading" 
                               value="<?php echo esc_attr(get_option('apex_newsletter_heading_' . $page_slug, 'Stay Updated')); ?>" 
                               class="regular-text" placeholder="e.g., Stay Updated">
                        <p class="description">The heading for the newsletter section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_newsletter_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_newsletter_description" name="apex_newsletter_description" rows="3" class="large-text"
                                  placeholder="Subscribe to our newsletter for the latest news, product updates, and industry insights."><?php 
                            $newsletter_desc = get_option('apex_newsletter_description_' . $page_slug, "Subscribe to our newsletter for the latest news, product updates, and industry insights delivered to your inbox.");
                            echo esc_textarea($newsletter_desc);
                        ?></textarea>
                        <p class="description">Description of the newsletter and its benefits</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_newsletter_form_action">Form Action URL</label></th>
                    <td>
                        <input type="url" id="apex_newsletter_form_action" name="apex_newsletter_form_action" 
                               value="<?php echo esc_attr(get_option('apex_newsletter_form_action_' . $page_slug, '')); ?>" 
                               class="large-text" placeholder="https://your-email-service.com/subscribe">
                        <p class="description">The URL where the newsletter form submits (leave empty for demo)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Get this URL from your email marketing service (Mailchimp, ConvertKit, etc.). The form will POST to this URL with the email field. Leave empty for a non-functional demo form.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_newsletter_button_text">Button Text</label></th>
                    <td>
                        <input type="text" id="apex_newsletter_button_text" name="apex_newsletter_button_text" 
                               value="<?php echo esc_attr(get_option('apex_newsletter_button_text_' . $page_slug, 'Subscribe')); ?>" 
                               class="regular-text" placeholder="e.g., Subscribe">
                        <p class="description">The text on the subscribe button</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_newsletter_note">Privacy Note</label></th>
                    <td>
                        <textarea id="apex_newsletter_note" name="apex_newsletter_note" rows="2" class="large-text"
                                  placeholder="By subscribing, you agree to our Privacy Policy. Unsubscribe at any time."><?php 
                            $note = get_option('apex_newsletter_note_' . $page_slug, "By subscribing, you agree to our Privacy Policy. Unsubscribe at any time.");
                            echo esc_textarea($note);
                        ?></textarea>
                        <p class="description">Privacy policy note below the form</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Include privacy compliance information and mention that users can unsubscribe. This builds trust and ensures legal compliance.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Media Contact Section -->
        <div style="margin-bottom: 30px;">
            <h4>📞 Media Contact Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section provides contact information for media inquiries.</strong> Each item includes a type (email/phone/link), label, and value.</p>
                <p><strong>Format for contact items:</strong> Enter each contact method on a new line using this format:<br>
                <code>Type | Label | Value</code></p>
                <p><strong>Available types:</strong> email, phone, link, text</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_contact_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_contact_heading" name="apex_contact_heading" 
                               value="<?php echo esc_attr(get_option('apex_contact_heading_' . $page_slug, 'Media Inquiries')); ?>" 
                               class="regular-text" placeholder="e.g., Media Inquiries">
                        <p class="description">The heading for the contact section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_contact_description" name="apex_contact_description" rows="3" class="large-text"
                                  placeholder="For press inquiries, interview requests, or media resources, please contact our communications team."><?php 
                            $contact_desc = get_option('apex_contact_description_' . $page_slug, "For press inquiries, interview requests, or media resources, please contact our communications team.");
                            echo esc_textarea($contact_desc);
                        ?></textarea>
                        <p class="description">Description of the contact section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_items">Contact Items</label></th>
                    <td>
                        <textarea id="apex_contact_items" name="apex_contact_items" rows="8" class="large-text"
                                  placeholder="email | Email | press@apexsoftwares.com&#10;link | Press Kit | https://example.com/press-kit"><?php 
                            $contact_items = get_option('apex_contact_items_' . $page_slug, "email | Email | press@apexsoftwares.com\nlink | Press Kit | #");
                            echo esc_textarea($contact_items);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Type | Label | Value (one item per line)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use "email" for email addresses (creates mailto link), "link" for URLs, "phone" for phone numbers, and "text" for plain text. Include your press email and a link to downloadable media assets.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'contact'): ?>
        <!-- Contact Us Specific Sections -->
        
        <!-- Contact Form Section -->
        <div style="margin-bottom: 30px;">
            <h4>📝 Contact Form Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section configures the main contact form on the page.</strong> It includes the form title, description, form action URL, and submission handling.</p>
                <p><strong>Integration:</strong> Configure the form action URL to connect with your form processing service or CRM.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_contact_form_title">Form Title</label></th>
                    <td>
                        <input type="text" id="apex_contact_form_title" name="apex_contact_form_title" 
                               value="<?php echo esc_attr(get_option('apex_contact_form_title_' . $page_slug, 'Send Us a Message')); ?>" 
                               class="regular-text" placeholder="e.g., Send Us a Message">
                        <p class="description">The heading for the contact form</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_form_description">Form Description</label></th>
                    <td>
                        <textarea id="apex_contact_form_description" name="apex_contact_form_description" rows="3" class="large-text"
                                  placeholder="Fill out the form below and we'll get back to you within 24 hours."><?php 
                            $form_desc = get_option('apex_contact_form_description_' . $page_slug, "Fill out the form below and we'll get back to you within 24 hours.");
                            echo esc_textarea($form_desc);
                        ?></textarea>
                        <p class="description">Description text below the form title</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Set clear expectations about response time and what information users should provide. This helps reduce form abandonment and improves user experience.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_form_action">Form Action URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_form_action" name="apex_contact_form_action" 
                               value="<?php echo esc_attr(get_option('apex_contact_form_action_' . $page_slug, '')); ?>" 
                               class="large-text" placeholder="https://your-form-processor.com/submit">
                        <p class="description">The URL where the form submits (leave empty for demo)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Get this URL from your form processing service (Formspree, Netlify Forms, etc.). The form will POST all fields with their names. Leave empty for a non-functional demo form.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_form_submit_text">Submit Button Text</label></th>
                    <td>
                        <input type="text" id="apex_contact_form_submit_text" name="apex_contact_form_submit_text" 
                               value="<?php echo esc_attr(get_option('apex_contact_form_submit_text_' . $page_slug, 'Send Message')); ?>" 
                               class="regular-text" placeholder="e.g., Send Message">
                        <p class="description">The text on the submit button</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Contact Info Sidebar Section -->
        <div style="margin-bottom: 30px;">
            <h4>📞 Contact Information Sidebar</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays contact information cards in the sidebar.</strong> Each card includes an icon, title, description, and contact details.</p>
                <p><strong>Format for contact cards:</strong> Enter each contact method on a new line using this format:<br>
                <code>Type | Title | Description | Contact Info 1 | Contact Info 2 | Hours</code></p>
                <p><strong>Available types:</strong> phone, email, hours, social</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_contact_sidebar_items">Contact Cards</label></th>
                    <td>
                        <textarea id="apex_contact_sidebar_items" name="apex_contact_sidebar_items" rows="12" class="large-text"
                                  placeholder="phone | Call Us | Speak directly with our team | +254 700 000 000 | Mon - Fri: 8:00 AM - 6:00 PM EAT | &#10;email | Email Us | We'll respond within 24 hours | info@apex-softwares.com | sales@apex-softwares.com | &#10;hours | Support Hours | 24/7 for critical issues | Business Hours: Mon - Fri | 8:00 AM - 6:00 PM EAT | &#10;social | Follow Us | Stay updated with our latest news | LinkedIn | Twitter | Facebook | YouTube"><?php 
                            $sidebar_items = get_option('apex_contact_sidebar_items_' . $page_slug, "phone | Call Us | Speak directly with our team | +254 700 000 000 | Mon - Fri: 8:00 AM - 6:00 PM EAT | \nemail | Email Us | We'll respond within 24 hours | info@apex-softwares.com | sales@apex-softwares.com | \nhours | Support Hours | 24/7 for critical issues | Business Hours: Mon - Fri | 8:00 AM - 6:00 PM EAT | \nsocial | Follow Us | Stay updated with our latest news | https://linkedin.com | https://twitter.com | https://facebook.com | https://youtube.com");
                            echo esc_textarea($sidebar_items);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Type | Title | Description | Contact Info 1 | Contact Info 2 | Hours (one card per line)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> For phone cards: use phone number in Contact Info 1 and hours in Contact Info 2. For email cards: use email addresses in Contact Info 1 and 2. For social cards: use social media URLs in Contact Info fields 1-4. Leave empty fields unused.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Social Media Links for "Follow Us" Card -->
        <div style="margin-bottom: 30px;">
            <h4>🔗 Social Media Links (Follow Us Card)</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>These URLs are used in the "Follow Us" card in the contact sidebar.</strong> All 7 social media platforms matching the footer settings.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_contact_social_linkedin">LinkedIn URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_linkedin" name="apex_contact_social_linkedin" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_linkedin_' . $page_slug, get_option('apex_footer_linkedin', 'https://linkedin.com'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://linkedin.com/company/yourcompany</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_social_twitter">Twitter/X URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_twitter" name="apex_contact_social_twitter" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_twitter_' . $page_slug, get_option('apex_footer_twitter', 'https://twitter.com'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://twitter.com/yourhandle</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_social_facebook">Facebook URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_facebook" name="apex_contact_social_facebook" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_facebook_' . $page_slug, get_option('apex_footer_facebook', 'https://facebook.com'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://facebook.com/yourcompany</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_social_instagram">Instagram URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_instagram" name="apex_contact_social_instagram" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_instagram_' . $page_slug, get_option('apex_footer_instagram', 'https://instagram.com'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://instagram.com/yourhandle</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_social_youtube">YouTube URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_youtube" name="apex_contact_social_youtube" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_youtube_' . $page_slug, get_option('apex_footer_youtube', 'https://youtube.com'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://youtube.com/@yourchannel</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_social_whatsapp">WhatsApp URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_whatsapp" name="apex_contact_social_whatsapp" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_whatsapp_' . $page_slug, get_option('apex_footer_whatsapp', 'https://wa.me/'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://wa.me/254700000000</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_social_github">GitHub URL</label></th>
                    <td>
                        <input type="url" id="apex_contact_social_github" name="apex_contact_social_github" 
                               value="<?php echo esc_attr(get_option('apex_contact_social_github_' . $page_slug, get_option('apex_footer_github', 'https://github.com'))); ?>" 
                               class="large-text">
                        <p class="description">Format: https://github.com/yourusername</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Offices Section -->
        <div style="margin-bottom: 30px;">
            <h4>🏢 Offices Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays office locations with interactive maps.</strong> Each office includes address, contact details, and a map embed URL.</p>
                <p><strong>Format for offices:</strong> Enter each office on a new line using this format:<br>
                <code>Office Name | Badge | Address | Phone | Email | Map URL | Is HQ</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_offices_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_offices_heading" name="apex_offices_heading" 
                               value="<?php echo esc_attr(get_option('apex_offices_heading_' . $page_slug, 'Visit Us')); ?>" 
                               class="regular-text" placeholder="e.g., Visit Us">
                        <p class="description">The heading for the offices section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_offices_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_offices_description" name="apex_offices_description" rows="2" class="large-text"
                                  placeholder="We have offices across Africa to serve you better."><?php 
                            $offices_desc = get_option('apex_offices_description_' . $page_slug, "We have offices across Africa to serve you better.");
                            echo esc_textarea($offices_desc);
                        ?></textarea>
                        <p class="description">Brief description of the offices section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_offices_items">Office Locations</label></th>
                    <td>
                        <textarea id="apex_offices_items" name="apex_offices_items" rows="16" class="large-text"
                                  placeholder="Nairobi, Kenya | Headquarters | Apex Softwares Ltd<br>Westlands Business Park<br>Waiyaki Way, 4th Floor<br>P.O. Box 12345-00100<br>Nairobi, Kenya | +254 700 000 000 | nairobi@apex-softwares.com | https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.819708510148!2d36.80419731475395!3d-1.2641399990638045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f17366e5a8e8b%3A0x1234567890abcdef!2sWestlands%2C%20Nairobi%2C%20Kenya!5e0!3m2!1sen!2ske!4v1706659200000!5m2!1sen!2ske | yes"><?php 
                            $offices_items = get_option('apex_offices_items_' . $page_slug, "Nairobi, Kenya | Headquarters | Apex Softwares Ltd<br>Westlands Business Park<br>Waiyaki Way, 4th Floor<br>P.O. Box 12345-00100<br>Nairobi, Kenya | +254 700 000 000 | nairobi@apex-softwares.com | https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.819708510148!2d36.80419731475395!3d-1.2641399990638045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f17366e5a8e8b%3A0x1234567890abcdef!2sWestlands%2C%20Nairobi%2C%20Kenya!5e0!3m2!1sen!2ske!4v1706659200000!5m2!1sen!2ske | yes\nLagos, Nigeria | | Apex Softwares Nigeria<br>Victoria Island<br>Adeola Odeku Street<br>Lagos, Nigeria | +234 123 456 7890 | lagos@apex-softwares.com | https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.7286407648195!2d3.4226840147632847!3d6.428055295344566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf53aec4dd92d%3A0x5e34fe6b5f6e0a0a!2sVictoria%20Island%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sng!4v1706659200000!5m2!1sen!2sng | \nKampala, Uganda | | Apex Softwares Uganda<br>Nakasero Hill<br>Plot 45, Kampala Road<br>Kampala, Uganda | +256 700 000 000 | kampala@apex-softwares.com | https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7573456789012!2d32.58219731475395!3d0.3155030997654321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbc0f90c1234a%3A0xabcdef1234567890!2sNakasero%2C%20Kampala%2C%20Uganda!5e0!3m2!1sen!2sug!4v1706659200000!5m2!1sen!2sug | \nDar es Salaam, Tanzania | | Apex Softwares Tanzania<br>Oyster Bay<br>Haile Selassie Road<br>Dar es Salaam, Tanzania | +255 700 000 000 | dar@apex-softwares.com | https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.234567890123!2d39.28219731475395!3d-6.7923456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c1234567890%3A0xfedcba0987654321!2sOyster%20Bay%2C%20Dar%20es%20Salaam%2C%20Tanzania!5e0!3m2!1sen!2stz!4v1706659200000!5m2!1sen!2stz | ");
                            echo esc_textarea($offices_items);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Office Name | Badge | Address | Phone | Email | Map URL | Is HQ (yes/no)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use <code>&lt;br&gt;</code> tags for line breaks in addresses. Get Google Maps embed URLs from Google Maps (Share > Embed a map). Mark headquarters with "yes" in the last field. The first office marked as HQ will be shown by default.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_offices_map_heading">Map Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_offices_map_heading" name="apex_offices_map_heading" 
                               value="<?php echo esc_attr(get_option('apex_offices_map_heading_' . $page_slug, 'Find Us')); ?>" 
                               class="regular-text" placeholder="e.g., Find Us">
                        <p class="description">The heading for the interactive map section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_offices_map_hours">Default Office Hours</label></th>
                    <td>
                        <textarea id="apex_offices_map_hours" name="apex_offices_map_hours" rows="3" class="large-text"
                                  placeholder="Monday - Friday&#10;8:00 AM - 6:00 PM EAT"><?php 
                            $map_hours = get_option('apex_offices_map_hours_' . $page_slug, "Monday - Friday\n8:00 AM - 6:00 PM EAT");
                            echo esc_textarea($map_hours);
                        ?></textarea>
                        <p class="description">Default office hours displayed in the map section</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use line breaks to separate hours information. This will be displayed in the map section for all offices unless overridden.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php endif; ?>
        
        <p class="submit">
            <input type="submit" name="apex_save_fallback" id="apex_save_fallback" class="button button-primary" value="Save Changes">
            <a href="<?php echo admin_url('admin.php?page=apex-website-settings'); ?>" class="button">← Back to Overview</a>
            <a href="<?php echo empty($page_slug) || $page_slug === 'home' ? home_url('/') : home_url('/' . $page_slug); ?>" target="_blank" class="button button-secondary" style="margin-left: 10px;">View Page</a>
        </p>
    </form>
    
    <?php
    // Handle form submission
    if (isset($_POST['apex_save_fallback']) && check_admin_referer('apex_save_fallback_content', 'apex_fallback_nonce')) {
        $page_slug = sanitize_text_field($_POST['apex_page_slug']);
        
        // Save Hero Section (common to both pages)
        update_option('apex_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_hero_badge']));
        update_option('apex_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_hero_heading']));
        update_option('apex_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_description']));
        update_option('apex_hero_image_' . $page_slug, esc_url_raw($_POST['apex_hero_image']));
        update_option('apex_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_stats']));
        
        if ($page_slug === 'about-us-overview') {
            // Save About Us Overview specific sections
            update_option('apex_story_badge_' . $page_slug, sanitize_text_field($_POST['apex_story_badge']));
            update_option('apex_story_heading_' . $page_slug, sanitize_text_field($_POST['apex_story_heading']));
            update_option('apex_story_content_' . $page_slug, sanitize_textarea_field($_POST['apex_story_content']));
            update_option('apex_story_milestones_' . $page_slug, sanitize_textarea_field($_POST['apex_story_milestones']));
            
            update_option('apex_mission_title_' . $page_slug, sanitize_text_field($_POST['apex_mission_title']));
            update_option('apex_mission_description_' . $page_slug, sanitize_textarea_field($_POST['apex_mission_description']));
            update_option('apex_vision_title_' . $page_slug, sanitize_text_field($_POST['apex_vision_title']));
            update_option('apex_vision_description_' . $page_slug, sanitize_textarea_field($_POST['apex_vision_description']));
            
            update_option('apex_values_' . $page_slug, sanitize_textarea_field($_POST['apex_values']));
            
            update_option('apex_leadership_badge_' . $page_slug, sanitize_text_field($_POST['apex_leadership_badge']));
            update_option('apex_leadership_heading_' . $page_slug, sanitize_text_field($_POST['apex_leadership_heading']));
            update_option('apex_leadership_description_' . $page_slug, sanitize_textarea_field($_POST['apex_leadership_description']));
            update_option('apex_team_members_' . $page_slug, sanitize_textarea_field($_POST['apex_team_members']));
            
            update_option('apex_reach_badge_' . $page_slug, sanitize_text_field($_POST['apex_reach_badge']));
            update_option('apex_reach_heading_' . $page_slug, sanitize_text_field($_POST['apex_reach_heading']));
            update_option('apex_reach_description_' . $page_slug, sanitize_textarea_field($_POST['apex_reach_description']));
            update_option('apex_regions_' . $page_slug, sanitize_textarea_field($_POST['apex_regions']));
            update_option('apex_headquarters_city_' . $page_slug, sanitize_text_field($_POST['apex_headquarters_city']));
            update_option('apex_headquarters_country_' . $page_slug, sanitize_text_field($_POST['apex_headquarters_country']));
            update_option('apex_headquarters_address_' . $page_slug, sanitize_text_field($_POST['apex_headquarters_address']));
            
            echo '<div class="notice notice-success is-dismissible"><p>About Us Overview content saved successfully! Changes will appear on the frontend.</p></div>';
        } elseif ($page_slug === 'about-us-our-approach') {
            // Save Our Approach specific sections
            update_option('apex_methodology_badge_' . $page_slug, sanitize_text_field($_POST['apex_methodology_badge']));
            update_option('apex_methodology_heading_' . $page_slug, sanitize_text_field($_POST['apex_methodology_heading']));
            update_option('apex_methodology_description_' . $page_slug, sanitize_textarea_field($_POST['apex_methodology_description']));
            update_option('apex_methodology_phases_' . $page_slug, sanitize_textarea_field($_POST['apex_methodology_phases']));
            
            update_option('apex_principles_badge_' . $page_slug, sanitize_text_field($_POST['apex_principles_badge']));
            update_option('apex_principles_heading_' . $page_slug, sanitize_text_field($_POST['apex_principles_heading']));
            update_option('apex_principles_cards_' . $page_slug, sanitize_textarea_field($_POST['apex_principles_cards']));
            
            update_option('apex_support_badge_' . $page_slug, sanitize_text_field($_POST['apex_support_badge']));
            update_option('apex_support_heading_' . $page_slug, sanitize_text_field($_POST['apex_support_heading']));
            update_option('apex_support_description_' . $page_slug, sanitize_textarea_field($_POST['apex_support_description']));
            update_option('apex_support_features_' . $page_slug, sanitize_textarea_field($_POST['apex_support_features']));
            update_option('apex_support_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_support_stats']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Our Approach content saved successfully! All sections with methodology phases, guiding principles, and support features have been updated.</p></div>';
        } elseif ($page_slug === 'about-us-leadership-team') {
            // Save Leadership Team specific sections
            update_option('apex_executive_badge_' . $page_slug, sanitize_text_field($_POST['apex_executive_badge']));
            update_option('apex_executive_heading_' . $page_slug, sanitize_text_field($_POST['apex_executive_heading']));
            update_option('apex_executive_description_' . $page_slug, sanitize_textarea_field($_POST['apex_executive_description']));
            update_option('apex_executive_members_' . $page_slug, sanitize_textarea_field($_POST['apex_executive_members']));
            
            update_option('apex_senior_heading_' . $page_slug, sanitize_text_field($_POST['apex_senior_heading']));
            update_option('apex_senior_description_' . $page_slug, sanitize_textarea_field($_POST['apex_senior_description']));
            update_option('apex_senior_members_' . $page_slug, sanitize_textarea_field($_POST['apex_senior_members']));
            
            update_option('apex_culture_badge_' . $page_slug, sanitize_text_field($_POST['apex_culture_badge']));
            update_option('apex_culture_heading_' . $page_slug, sanitize_text_field($_POST['apex_culture_heading']));
            update_option('apex_culture_description_' . $page_slug, sanitize_textarea_field($_POST['apex_culture_description']));
            update_option('apex_culture_benefits_' . $page_slug, sanitize_textarea_field($_POST['apex_culture_benefits']));
            update_option('apex_culture_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_culture_cta_text']));
            update_option('apex_culture_cta_url_' . $page_slug, esc_url_raw($_POST['apex_culture_cta_url']));
            update_option('apex_culture_image_' . $page_slug, esc_url_raw($_POST['apex_culture_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Leadership Team content saved successfully! All sections with executive team, senior leadership, and culture have been updated.</p></div>';
        } elseif ($page_slug === 'about-us-news') {
            // Save News & Updates specific sections
            update_option('apex_featured_badge_' . $page_slug, sanitize_text_field($_POST['apex_featured_badge']));
            update_option('apex_featured_image_' . $page_slug, esc_url_raw($_POST['apex_featured_image']));
            update_option('apex_featured_category_' . $page_slug, sanitize_text_field($_POST['apex_featured_category']));
            update_option('apex_featured_date_' . $page_slug, sanitize_text_field($_POST['apex_featured_date']));
            update_option('apex_featured_title_' . $page_slug, sanitize_text_field($_POST['apex_featured_title']));
            update_option('apex_featured_excerpt_' . $page_slug, sanitize_textarea_field($_POST['apex_featured_excerpt']));
            update_option('apex_featured_link_' . $page_slug, esc_url_raw($_POST['apex_featured_link']));
            
            update_option('apex_news_heading_' . $page_slug, sanitize_text_field($_POST['apex_news_heading']));
            update_option('apex_news_filters_' . $page_slug, sanitize_textarea_field($_POST['apex_news_filters']));
            update_option('apex_news_items_' . $page_slug, sanitize_textarea_field($_POST['apex_news_items']));
            update_option('apex_news_load_more_' . $page_slug, sanitize_text_field($_POST['apex_news_load_more']));
            
            update_option('apex_press_heading_' . $page_slug, sanitize_text_field($_POST['apex_press_heading']));
            update_option('apex_press_description_' . $page_slug, sanitize_textarea_field($_POST['apex_press_description']));
            update_option('apex_press_items_' . $page_slug, sanitize_textarea_field($_POST['apex_press_items']));
            
            update_option('apex_newsletter_heading_' . $page_slug, sanitize_text_field($_POST['apex_newsletter_heading']));
            update_option('apex_newsletter_description_' . $page_slug, sanitize_textarea_field($_POST['apex_newsletter_description']));
            update_option('apex_newsletter_form_action_' . $page_slug, esc_url_raw($_POST['apex_newsletter_form_action']));
            update_option('apex_newsletter_button_text_' . $page_slug, sanitize_text_field($_POST['apex_newsletter_button_text']));
            update_option('apex_newsletter_note_' . $page_slug, sanitize_textarea_field($_POST['apex_newsletter_note']));
            
            update_option('apex_contact_heading_' . $page_slug, sanitize_text_field($_POST['apex_contact_heading']));
            update_option('apex_contact_description_' . $page_slug, sanitize_textarea_field($_POST['apex_contact_description']));
            update_option('apex_contact_items_' . $page_slug, sanitize_textarea_field($_POST['apex_contact_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>News & Updates content saved successfully! All sections with featured story, news grid, press mentions, newsletter, and media contact have been updated.</p></div>';
        } elseif ($page_slug === 'contact') {
            // Save Contact Us specific sections
            update_option('apex_contact_form_title_' . $page_slug, sanitize_text_field($_POST['apex_contact_form_title']));
            update_option('apex_contact_form_description_' . $page_slug, sanitize_textarea_field($_POST['apex_contact_form_description']));
            update_option('apex_contact_form_action_' . $page_slug, esc_url_raw($_POST['apex_contact_form_action']));
            update_option('apex_contact_form_submit_text_' . $page_slug, sanitize_text_field($_POST['apex_contact_form_submit_text']));
            
            update_option('apex_contact_sidebar_items_' . $page_slug, sanitize_textarea_field($_POST['apex_contact_sidebar_items']));
            
            // Save social media URLs for "Follow Us" card
            update_option('apex_contact_social_linkedin_' . $page_slug, esc_url_raw($_POST['apex_contact_social_linkedin']));
            update_option('apex_contact_social_twitter_' . $page_slug, esc_url_raw($_POST['apex_contact_social_twitter']));
            update_option('apex_contact_social_facebook_' . $page_slug, esc_url_raw($_POST['apex_contact_social_facebook']));
            update_option('apex_contact_social_instagram_' . $page_slug, esc_url_raw($_POST['apex_contact_social_instagram']));
            update_option('apex_contact_social_youtube_' . $page_slug, esc_url_raw($_POST['apex_contact_social_youtube']));
            update_option('apex_contact_social_whatsapp_' . $page_slug, esc_url_raw($_POST['apex_contact_social_whatsapp']));
            update_option('apex_contact_social_github_' . $page_slug, esc_url_raw($_POST['apex_contact_social_github']));
            
            update_option('apex_offices_heading_' . $page_slug, sanitize_text_field($_POST['apex_offices_heading']));
            update_option('apex_offices_description_' . $page_slug, sanitize_textarea_field($_POST['apex_offices_description']));
            update_option('apex_offices_items_' . $page_slug, sanitize_textarea_field($_POST['apex_offices_items']));
            update_option('apex_offices_map_heading_' . $page_slug, sanitize_text_field($_POST['apex_offices_map_heading']));
            update_option('apex_offices_map_hours_' . $page_slug, sanitize_textarea_field($_POST['apex_offices_map_hours']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Contact Us content saved successfully! All sections with contact form, sidebar information, and office locations have been updated.</p></div>';
        }
    }
}

/**
 * Render Footer Settings Page
 */
function apex_render_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1>Footer Settings</h1>
        <a href="<?php echo admin_url('admin.php?page=apex-website-settings'); ?>" class="button">← Back to Overview</a>
        
        <form method="post" action="" style="background: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; border-radius: 6px; margin-top: 20px;">
            <?php wp_nonce_field('apex_save_footer_settings', 'apex_footer_nonce'); ?>
            
            <h3>Edit Footer Content</h3>
            <p class="description">Update the footer content. Changes will appear immediately on all pages.</p>
            
            <!-- Pre-Footer CTA Section -->
            <div style="margin-bottom: 30px;">
                <h4>🎯 Pre-Footer CTA Cards</h4>
                <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                    <h5>📋 Section Overview</h5>
                    <p><strong>This section displays two call-to-action cards above the main footer.</strong> Card 1 (primary/orange) and Card 2 (secondary/dark blue).</p>
                </div>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apex_footer_cta1_title">Card 1 Title</label></th>
                        <td>
                            <input type="text" id="apex_footer_cta1_title" name="apex_footer_cta1_title" 
                                   value="<?php echo esc_attr(get_option('apex_footer_cta1_title', 'Ready to Transform Your Institution?')); ?>" 
                                   class="regular-text">
                            <p class="description">The title for the first CTA card (orange/primary)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta1_description">Card 1 Description</label></th>
                        <td>
                            <textarea id="apex_footer_cta1_description" name="apex_footer_cta1_description" rows="2" class="large-text"><?php echo esc_textarea(get_option('apex_footer_cta1_description', 'Get in touch to discuss a tailored banking or fintech strategy for your business.')); ?></textarea>
                            <p class="description">Description text for the first card</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta1_button_text">Card 1 Button Text</label></th>
                        <td>
                            <input type="text" id="apex_footer_cta1_button_text" name="apex_footer_cta1_button_text" 
                                   value="<?php echo esc_attr(get_option('apex_footer_cta1_button_text', 'Request a Demo')); ?>" 
                                   class="regular-text">
                            <p class="description">Text displayed on the first card button</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta1_button_url">Card 1 Button URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_cta1_button_url" name="apex_footer_cta1_button_url" 
                                   value="<?php echo esc_attr(get_option('apex_footer_cta1_button_url', '/contact')); ?>" 
                                   class="large-text">
                            <p class="description">URL for the first card button (can be relative like /contact or absolute)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta2_title">Card 2 Title</label></th>
                        <td>
                            <input type="text" id="apex_footer_cta2_title" name="apex_footer_cta2_title" 
                                   value="<?php echo esc_attr(get_option('apex_footer_cta2_title', 'Need Support?')); ?>" 
                                   class="regular-text">
                            <p class="description">The title for the second CTA card (dark blue/secondary)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta2_description">Card 2 Description</label></th>
                        <td>
                            <textarea id="apex_footer_cta2_description" name="apex_footer_cta2_description" rows="2" class="large-text"><?php echo esc_textarea(get_option('apex_footer_cta2_description', 'For existing customers, access our knowledge base and expert support team.')); ?></textarea>
                            <p class="description">Description text for the second card</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta2_button_text">Card 2 Button Text</label></th>
                        <td>
                            <input type="text" id="apex_footer_cta2_button_text" name="apex_footer_cta2_button_text" 
                                   value="<?php echo esc_attr(get_option('apex_footer_cta2_button_text', 'Get Support')); ?>" 
                                   class="regular-text">
                            <p class="description">Text displayed on the second card button</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_cta2_button_url">Card 2 Button URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_cta2_button_url" name="apex_footer_cta2_button_url" 
                                   value="<?php echo esc_attr(get_option('apex_footer_cta2_button_url', '/contact')); ?>" 
                                   class="large-text">
                            <p class="description">URL for the second card button</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Brand Section -->
            <div style="margin-bottom: 30px;">
                <h4>🏢 Brand Section</h4>
                <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                    <h5>📋 Section Overview</h5>
                    <p><strong>This section displays your company logo, tagline, description, and newsletter signup.</strong></p>
                </div>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apex_footer_logo_url">Logo Image URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_logo_url" name="apex_footer_logo_url" 
                                   value="<?php echo esc_attr(get_option('apex_footer_logo_url', 'https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png')); ?>" 
                                   class="large-text">
                            <p class="description">URL to your company logo image</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_company_name">Company Name</label></th>
                        <td>
                            <input type="text" id="apex_footer_company_name" name="apex_footer_company_name" 
                                   value="<?php echo esc_attr(get_option('apex_footer_company_name', 'Apex Softwares')); ?>" 
                                   class="regular-text">
                            <p class="description">Your company name displayed in the footer</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_tagline">Company Tagline</label></th>
                        <td>
                            <input type="text" id="apex_footer_tagline" name="apex_footer_tagline" 
                                   value="<?php echo esc_attr(get_option('apex_footer_tagline', 'Microfinance & Banking Solutions')); ?>" 
                                   class="regular-text">
                            <p class="description">Short tagline describing your business</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_description">Company Description</label></th>
                        <td>
                            <textarea id="apex_footer_description" name="apex_footer_description" rows="3" class="large-text"><?php echo esc_textarea(get_option('apex_footer_description', 'Comprehensive solutions for financial operations automation, covering retail banking, portfolio management, and deposit accounts across Africa.')); ?></textarea>
                            <p class="description">Detailed company description for the footer</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Contact Information -->
            <div style="margin-bottom: 30px;">
                <h4>📞 Contact Information</h4>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apex_footer_email">Email Address</label></th>
                        <td>
                            <input type="email" id="apex_footer_email" name="apex_footer_email" 
                                   value="<?php echo esc_attr(get_option('apex_footer_email', 'info@apex-softwares.com')); ?>" 
                                   class="regular-text">
                            <p class="description">Primary contact email address</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_phone">Phone Number</label></th>
                        <td>
                            <input type="text" id="apex_footer_phone" name="apex_footer_phone" 
                                   value="<?php echo esc_attr(get_option('apex_footer_phone', '+254 700 000 000')); ?>" 
                                   class="regular-text">
                            <p class="description">Main contact phone number with country code</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_city">City</label></th>
                        <td>
                            <input type="text" id="apex_footer_city" name="apex_footer_city" 
                                   value="<?php echo esc_attr(get_option('apex_footer_city', 'Nairobi, Kenya')); ?>" 
                                   class="regular-text">
                            <p class="description">City and country for your location</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_address">Full Address</label></th>
                        <td>
                            <textarea id="apex_footer_address" name="apex_footer_address" rows="3" class="large-text"><?php echo esc_textarea(get_option('apex_footer_address', "Westlands Business Park\n3rd Floor, Suite 305\nWaiyaki Way, Westlands")); ?></textarea>
                            <p class="description">Use line breaks for multi-line address</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_hours">Business Hours</label></th>
                        <td>
                            <input type="text" id="apex_footer_hours" name="apex_footer_hours" 
                                   value="<?php echo esc_attr(get_option('apex_footer_hours', 'Mon - Fri: 8:00 AM - 6:00 PM')); ?>" 
                                   class="large-text">
                            <p class="description">Your business operating hours</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Social Media Links -->
            <div style="margin-bottom: 30px;">
                <h4>🔗 Social Media Links</h4>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apex_footer_linkedin">LinkedIn URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_linkedin" name="apex_footer_linkedin" 
                                   value="<?php echo esc_attr(get_option('apex_footer_linkedin', 'https://linkedin.com')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://linkedin.com/company/yourcompany</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_twitter">Twitter/X URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_twitter" name="apex_footer_twitter" 
                                   value="<?php echo esc_attr(get_option('apex_footer_twitter', 'https://twitter.com')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://twitter.com/yourhandle</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_facebook">Facebook URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_facebook" name="apex_footer_facebook" 
                                   value="<?php echo esc_attr(get_option('apex_footer_facebook', 'https://facebook.com')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://facebook.com/yourcompany</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_instagram">Instagram URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_instagram" name="apex_footer_instagram" 
                                   value="<?php echo esc_attr(get_option('apex_footer_instagram', 'https://instagram.com')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://instagram.com/yourhandle</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_youtube">YouTube URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_youtube" name="apex_footer_youtube" 
                                   value="<?php echo esc_attr(get_option('apex_footer_youtube', 'https://youtube.com')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://youtube.com/@yourchannel</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_whatsapp">WhatsApp URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_whatsapp" name="apex_footer_whatsapp" 
                                   value="<?php echo esc_attr(get_option('apex_footer_whatsapp', 'https://wa.me/')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://wa.me/254700000000</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_github">GitHub URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_github" name="apex_footer_github" 
                                   value="<?php echo esc_attr(get_option('apex_footer_github', 'https://github.com')); ?>" 
                                   class="large-text">
                            <p class="description">Format: https://github.com/yourusername</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- App Store Links -->
            <div style="margin-bottom: 30px;">
                <h4>📱 Mobile App Links</h4>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apex_footer_google_play">Google Play Store URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_google_play" name="apex_footer_google_play" 
                                   value="<?php echo esc_attr(get_option('apex_footer_google_play', 'https://play.google.com')); ?>" 
                                   class="large-text">
                            <p class="description">Link to your app on Google Play Store</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_app_store">Apple App Store URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_app_store" name="apex_footer_app_store" 
                                   value="<?php echo esc_attr(get_option('apex_footer_app_store', 'https://apps.apple.com')); ?>" 
                                   class="large-text">
                            <p class="description">Link to your app on Apple App Store</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Footer Bottom -->
            <div style="margin-bottom: 30px;">
                <h4>©️ Footer Bottom</h4>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apex_footer_copyright_text">Copyright Text</label></th>
                        <td>
                            <input type="text" id="apex_footer_copyright_text" name="apex_footer_copyright_text" 
                                   value="<?php echo esc_attr(get_option('apex_footer_copyright_text', 'All rights reserved.')); ?>" 
                                   class="large-text">
                            <p class="description">The year and company name are added automatically</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_certification_image">Certification Badge URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_certification_image" name="apex_footer_certification_image" 
                                   value="<?php echo esc_attr(get_option('apex_footer_certification_image', 'https://www.continualengine.com/wp-content/uploads/2025/01/information-security-management-system-iso-27001_1-transformed.png')); ?>" 
                                   class="large-text">
                            <p class="description">URL to certification badge image (e.g., ISO 27001)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_certification_alt">Certification Badge Alt Text</label></th>
                        <td>
                            <input type="text" id="apex_footer_certification_alt" name="apex_footer_certification_alt" 
                                   value="<?php echo esc_attr(get_option('apex_footer_certification_alt', 'ISO 27001 Certified')); ?>" 
                                   class="regular-text">
                            <p class="description">Alternative text for the certification badge image</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_credit_text">Credit Text</label></th>
                        <td>
                            <input type="text" id="apex_footer_credit_text" name="apex_footer_credit_text" 
                                   value="<?php echo esc_attr(get_option('apex_footer_credit_text', 'Built for performance, accessibility, and scale with')); ?>" 
                                   class="large-text">
                            <p class="description">Text before the credit link (e.g., "Built by")</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_credit_link_text">Credit Link Text</label></th>
                        <td>
                            <input type="text" id="apex_footer_credit_link_text" name="apex_footer_credit_link_text" 
                                   value="<?php echo esc_attr(get_option('apex_footer_credit_link_text', 'Wagura Maurice')); ?>" 
                                   class="regular-text">
                            <p class="description">Text for the credit link (developer/company name)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apex_footer_credit_link_url">Credit Link URL</label></th>
                        <td>
                            <input type="url" id="apex_footer_credit_link_url" name="apex_footer_credit_link_url" 
                                   value="<?php echo esc_attr(get_option('apex_footer_credit_link_url', 'https://waguramaurice.com')); ?>" 
                                   class="large-text">
                            <p class="description">URL for the credit link</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <p class="submit">
                <input type="submit" name="apex_save_footer_settings" id="apex_save_footer_settings" class="button button-primary" value="Save Footer Settings">
                <a href="<?php echo admin_url('admin.php?page=apex-website-settings'); ?>" class="button">← Back to Overview</a>
            </p>
        </form>
    </div>
    
    <?php
    // Handle form submission
    if (isset($_POST['apex_save_footer_settings']) && check_admin_referer('apex_save_footer_settings', 'apex_footer_nonce')) {
        // Save Pre-Footer CTA Cards
        update_option('apex_footer_cta1_title', sanitize_text_field($_POST['apex_footer_cta1_title']));
        update_option('apex_footer_cta1_description', sanitize_textarea_field($_POST['apex_footer_cta1_description']));
        update_option('apex_footer_cta1_button_text', sanitize_text_field($_POST['apex_footer_cta1_button_text']));
        update_option('apex_footer_cta1_button_url', sanitize_text_field($_POST['apex_footer_cta1_button_url']));
        update_option('apex_footer_cta2_title', sanitize_text_field($_POST['apex_footer_cta2_title']));
        update_option('apex_footer_cta2_description', sanitize_textarea_field($_POST['apex_footer_cta2_description']));
        update_option('apex_footer_cta2_button_text', sanitize_text_field($_POST['apex_footer_cta2_button_text']));
        update_option('apex_footer_cta2_button_url', sanitize_text_field($_POST['apex_footer_cta2_button_url']));
        
        // Save Brand Section
        update_option('apex_footer_logo_url', esc_url_raw($_POST['apex_footer_logo_url']));
        update_option('apex_footer_company_name', sanitize_text_field($_POST['apex_footer_company_name']));
        update_option('apex_footer_tagline', sanitize_text_field($_POST['apex_footer_tagline']));
        update_option('apex_footer_description', sanitize_textarea_field($_POST['apex_footer_description']));
        
        // Save Contact Information
        update_option('apex_footer_email', sanitize_email($_POST['apex_footer_email']));
        update_option('apex_footer_phone', sanitize_text_field($_POST['apex_footer_phone']));
        update_option('apex_footer_city', sanitize_text_field($_POST['apex_footer_city']));
        update_option('apex_footer_address', sanitize_textarea_field($_POST['apex_footer_address']));
        update_option('apex_footer_hours', sanitize_text_field($_POST['apex_footer_hours']));
        
        // Save Social Media Links
        update_option('apex_footer_linkedin', esc_url_raw($_POST['apex_footer_linkedin']));
        update_option('apex_footer_twitter', esc_url_raw($_POST['apex_footer_twitter']));
        update_option('apex_footer_facebook', esc_url_raw($_POST['apex_footer_facebook']));
        update_option('apex_footer_instagram', esc_url_raw($_POST['apex_footer_instagram']));
        update_option('apex_footer_youtube', esc_url_raw($_POST['apex_footer_youtube']));
        update_option('apex_footer_whatsapp', esc_url_raw($_POST['apex_footer_whatsapp']));
        update_option('apex_footer_github', esc_url_raw($_POST['apex_footer_github']));
        
        // Save App Store Links
        update_option('apex_footer_google_play', esc_url_raw($_POST['apex_footer_google_play']));
        update_option('apex_footer_app_store', esc_url_raw($_POST['apex_footer_app_store']));
        
        // Save Footer Bottom
        update_option('apex_footer_copyright_text', sanitize_text_field($_POST['apex_footer_copyright_text']));
        update_option('apex_footer_certification_image', esc_url_raw($_POST['apex_footer_certification_image']));
        update_option('apex_footer_certification_alt', sanitize_text_field($_POST['apex_footer_certification_alt']));
        update_option('apex_footer_credit_text', sanitize_text_field($_POST['apex_footer_credit_text']));
        update_option('apex_footer_credit_link_text', sanitize_text_field($_POST['apex_footer_credit_link_text']));
        update_option('apex_footer_credit_link_url', esc_url_raw($_POST['apex_footer_credit_link_url']));
        
        echo '<div class="notice notice-success is-dismissible"><p>Footer settings saved successfully! Changes will appear on all pages.</p></div>';
    }
}
function apex_get_fallback_content($page_slug) {
    return [
        'badge' => get_option('apex_hero_badge_' . $page_slug, 'About Apex Softwares'),
        'heading' => get_option('apex_hero_heading_' . $page_slug, 'Transforming Financial Services Across Africa'),
        'description' => get_option('apex_hero_description_' . $page_slug, "For over a decade, we've been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences."),
        'image' => get_option('apex_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'),
        'stats' => get_option('apex_hero_stats_' . $page_slug, "100+ Financial Institutions\n15+ Countries\n10M+ End Users\n14+ Years Experience")
    ];
}
function apex_header_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1>Website Settings - Header & Footer</h1>
        <p>Manage header and footer content settings.</p>
        <!-- ACF form will be loaded here -->
    </div>
    <?php
}

/**
 * Global Settings Page
 */
function apex_global_settings_page() {
    ?>
    <div class="wrap">
        <h1>Website Settings - Global Settings</h1>
        <p>Manage global website settings.</p>
        <!-- ACF form will be loaded here -->
    </div>
    <?php
}

/**
 * Register custom query vars
 */
function apex_about_us_query_vars($vars) {
    $vars[] = 'apex_about_page';
    $vars[] = 'apex_insights_page';
    $vars[] = 'apex_contact_page';
    $vars[] = 'apex_industry_page';
    $vars[] = 'apex_support_page';
    $vars[] = 'apex_solutions_page';
    return $vars;
}
add_filter('query_vars', 'apex_about_us_query_vars');

/**
 * Handle About Us pages early in the request lifecycle
 */
function apex_about_us_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of about-us URLs to their templates
    $about_templates = [
        'about-us' => 'page-about-us-overview.php',
        'about-us/' => 'page-about-us-overview.php',
        'about-us/overview' => 'page-about-us-overview.php',
        'about-us/overview/' => 'page-about-us-overview.php',
        'about-us/our-approach' => 'page-about-us-our-approach.php',
        'about-us/our-approach/' => 'page-about-us-our-approach.php',
        'about-us/leadership-team' => 'page-about-us-leadership-team.php',
        'about-us/leadership-team/' => 'page-about-us-leadership-team.php',
        'about-us/news' => 'page-about-us-news.php',
        'about-us/news/' => 'page-about-us-news.php',
    ];
    
    if (isset($about_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $about_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_about_us_template_redirect', 1);

/**
 * Handle Insights pages early in the request lifecycle
 */
function apex_insights_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of insights URLs to their templates
    $insights_templates = [
        'insights/blog' => 'page-insights-blog.php',
        'insights/blog/' => 'page-insights-blog.php',
        'insights/success-stories' => 'page-insights-success-stories.php',
        'insights/success-stories/' => 'page-insights-success-stories.php',
        'insights/webinars' => 'page-insights-webinars.php',
        'insights/webinars/' => 'page-insights-webinars.php',
        'insights/whitepapers-reports' => 'page-insights-whitepapers-reports.php',
        'insights/whitepapers-reports/' => 'page-insights-whitepapers-reports.php',
    ];
    
    if (isset($insights_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $insights_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_insights_template_redirect', 1);

/**
 * Handle Contact page early in the request lifecycle
 */
function apex_contact_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of contact URLs to their templates
    $contact_templates = [
        'contact' => 'page-contact.php',
        'contact/' => 'page-contact.php',
    ];
    
    if (isset($contact_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $contact_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_contact_template_redirect', 1);

/**
 * Handle Industry pages early in the request lifecycle
 */
function apex_industry_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of industry URLs to their templates
    $industry_templates = [
        'industry/overview' => 'page-industry-overview.php',
        'industry/overview/' => 'page-industry-overview.php',
        'industry/mfis' => 'page-industry-mfis.php',
        'industry/mfis/' => 'page-industry-mfis.php',
        'industry/credit-unions' => 'page-industry-credit-unions.php',
        'industry/credit-unions/' => 'page-industry-credit-unions.php',
        'industry/banks-microfinance' => 'page-industry-banks.php',
        'industry/banks-microfinance/' => 'page-industry-banks.php',
        'industry/digital-government' => 'page-industry-digital-government.php',
        'industry/digital-government/' => 'page-industry-digital-government.php',
    ];
    
    if (isset($industry_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $industry_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_industry_template_redirect', 1);

/**
 * Handle Solutions pages early in the request lifecycle
 */
function apex_solutions_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of solutions URLs to their templates
    $solutions_templates = [
        'solutions/overview' => 'page-solutions-overview.php',
        'solutions/overview/' => 'page-solutions-overview.php',
        'solutions/core-banking-microfinance' => 'page-solutions-core-banking.php',
        'solutions/core-banking-microfinance/' => 'page-solutions-core-banking.php',
        'solutions/mobile-wallet-app' => 'page-solutions-mobile-wallet.php',
        'solutions/mobile-wallet-app/' => 'page-solutions-mobile-wallet.php',
        'solutions/agency-branch-banking' => 'page-solutions-agency-banking.php',
        'solutions/agency-branch-banking/' => 'page-solutions-agency-banking.php',
        'solutions/internet-mobile-banking' => 'page-solutions-internet-banking.php',
        'solutions/internet-mobile-banking/' => 'page-solutions-internet-banking.php',
        'solutions/loan-origination-workflows' => 'page-solutions-loan-origination.php',
        'solutions/loan-origination-workflows/' => 'page-solutions-loan-origination.php',
        'solutions/digital-field-agent' => 'page-solutions-field-agent.php',
        'solutions/digital-field-agent/' => 'page-solutions-field-agent.php',
        'solutions/enterprise-integration' => 'page-solutions-enterprise-integration.php',
        'solutions/enterprise-integration/' => 'page-solutions-enterprise-integration.php',
        'solutions/payment-switch-ledger' => 'page-solutions-payment-switch.php',
        'solutions/payment-switch-ledger/' => 'page-solutions-payment-switch.php',
        'solutions/reporting-analytics' => 'page-solutions-reporting.php',
        'solutions/reporting-analytics/' => 'page-solutions-reporting.php',
    ];
    
    if (isset($solutions_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $solutions_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_solutions_template_redirect', 1);

/**
 * Handle Support pages early in the request lifecycle
 */
function apex_support_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of support URLs to their templates
    $support_templates = [
        'privacy-policy' => 'page-privacy-policy.php',
        'privacy-policy/' => 'page-privacy-policy.php',
        'terms-and-conditions' => 'page-terms-and-conditions.php',
        'terms-and-conditions/' => 'page-terms-and-conditions.php',
        'careers' => 'page-careers.php',
        'careers/' => 'page-careers.php',
        'help-support' => 'page-help-support.php',
        'help-support/' => 'page-help-support.php',
        'faq' => 'page-faq.php',
        'faq/' => 'page-faq.php',
        'knowledge-base' => 'page-knowledge-base.php',
        'knowledge-base/' => 'page-knowledge-base.php',
        'developers' => 'page-developers.php',
        'developers/' => 'page-developers.php',
        'partners' => 'page-partners.php',
        'partners/' => 'page-partners.php',
        'request-demo' => 'page-request-demo.php',
        'request-demo/' => 'page-request-demo.php',
    ];
    
    if (isset($support_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $support_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_support_template_redirect', 1);

/**
 * Custom template for About Us pages (fallback)
 */
function apex_about_us_template($template) {
    $apex_about_page = get_query_var('apex_about_page');
    if ($apex_about_page) {
        $custom_template = locate_template('page-about-us-overview.php');
        if ($custom_template) {
            return $custom_template;
        }
    }
    
    return $template;
}
add_filter('template_include', 'apex_about_us_template');

