<?php

/**
 * Load modular component system
 */
require_once get_template_directory() . '/components/component-loader.php';

/**
 * Load ACF field definitions
 */
require_once get_template_directory() . '/inc/acf-about-us-overview.php';
require_once get_template_directory() . '/inc/acf-request-demo.php';

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
    
    // Check if it's a POST request and our contact form was submitted (not demo form)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name']) && isset($_POST['apex_contact_nonce']) && !isset($_POST['apex_demo_nonce'])) {

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

/**
 * Handle newsletter form submission
 */
function apex_handle_newsletter_form_submission() {
    // Skip if this is an AJAX request - let the AJAX handler deal with it
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }
    // Check if it's a POST request and our newsletter form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['apex_newsletter_nonce']) && !isset($_POST['action'])) {
        
        error_log('Apex Newsletter Form: Newsletter submission detected - PROCESSING');

        // Verify nonce for security
        if (!wp_verify_nonce($_POST['apex_newsletter_nonce'], 'apex_newsletter_form')) {
            error_log('Apex Newsletter Form: Nonce verification failed');
            wp_die('Security check failed!');
        }

        // Sanitize and validate form data
        $email = sanitize_email($_POST['email'] ?? '');

        error_log("Apex Newsletter Form: Processing newsletter subscription from {$email}");

        // Basic validation
        if (empty($email)) {
            error_log('Apex Newsletter Form: Validation failed - missing email');
            wp_redirect(home_url('/?newsletter_error=missing_email'));
            exit;
        }

        if (!is_email($email)) {
            error_log('Apex Newsletter Form: Invalid email address: ' . $email);
            wp_redirect(home_url('/?newsletter_error=invalid_email'));
            exit;
        }

        // Send email notification using the same email system as contact form
        error_log('Apex Newsletter Form: Attempting to send notification email');
        
        $email_sent = apex_send_email_direct([
            'to' => 'info@apex-softwares.com',
            'subject' => 'New Newsletter Subscription from ' . $email,
            'html_content' => apex_create_newsletter_email_html([
                'email' => $email,
                'submission_date' => current_time('F j, Y, g:i a'),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
            ])
        ]);

        error_log('Apex Newsletter Form: Notification email sending result: ' . ($email_sent ? 'SUCCESS' : 'FAILED'));

        if ($email_sent) {
            error_log('Apex Newsletter Form: Notification email sent successfully');
            wp_redirect(home_url('/?newsletter_success=1'));
        } else {
            error_log('Apex Newsletter Form: Notification email sending failed');
            wp_redirect(home_url('/?newsletter_error=send_failed'));
        }
        exit;
    }
}
add_action('init', 'apex_handle_newsletter_form_submission');

/**
 * AJAX handler for newsletter form submission
 */
function apex_newsletter_ajax_handler() {
    // Verify nonce for security
    if (!isset($_POST['apex_newsletter_nonce']) || !wp_verify_nonce($_POST['apex_newsletter_nonce'], 'apex_newsletter_form')) {
        wp_send_json_error(['message' => 'Security check failed!']);
    }

    // Sanitize and validate form data
    $email = sanitize_email($_POST['email'] ?? '');

    error_log("Apex Newsletter AJAX: Processing newsletter subscription from {$email}");

    // Basic validation
    if (empty($email)) {
        wp_send_json_error(['message' => 'Please enter your email address.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    // Send email notification using the same email system as contact form
    error_log('Apex Newsletter AJAX: Attempting to send notification email');
    
    $email_sent = apex_send_email_direct([
        'to' => 'info@apex-softwares.com',
        'subject' => 'New Newsletter Subscription from ' . $email,
        'html_content' => apex_create_newsletter_email_html([
            'email' => $email,
            'submission_date' => current_time('F j, Y, g:i a'),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
        ])
    ]);

    error_log('Apex Newsletter AJAX: Notification email sending result: ' . ($email_sent ? 'SUCCESS' : 'FAILED'));

    if ($email_sent) {
        error_log('Apex Newsletter AJAX: Notification email sent successfully');
        wp_send_json_success(['message' => 'Thank you for subscribing! Check your email for confirmation.']);
    } else {
        error_log('Apex Newsletter AJAX: Notification email sending failed');
        wp_send_json_error(['message' => 'Failed to subscribe. Please try again later.']);
    }
}
add_action('wp_ajax_apex_newsletter_submit', 'apex_newsletter_ajax_handler');
add_action('wp_ajax_nopriv_apex_newsletter_submit', 'apex_newsletter_ajax_handler');

/**
 * AJAX handler for demo request form submission (with file upload)
 */
function apex_demo_request_ajax_handler() {
    // Verify nonce
    if (!isset($_POST['apex_demo_nonce']) || !wp_verify_nonce($_POST['apex_demo_nonce'], 'apex_demo_request_form')) {
        wp_send_json_error(['message' => 'Security check failed!']);
    }

    // Sanitize form fields
    $first_name      = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name       = sanitize_text_field($_POST['last_name'] ?? '');
    $email           = sanitize_email($_POST['email'] ?? '');
    $phone           = sanitize_text_field($_POST['phone'] ?? '');
    $company         = sanitize_text_field($_POST['company'] ?? '');
    $job_title       = sanitize_text_field($_POST['job_title'] ?? '');
    $institution_type = sanitize_text_field($_POST['institution_type'] ?? '');
    $country         = sanitize_text_field($_POST['country'] ?? '');
    $message         = sanitize_textarea_field($_POST['message'] ?? '');
    $privacy         = isset($_POST['privacy']) ? true : false;

    // Solutions is an array of checkboxes
    $solutions = [];
    if (!empty($_POST['solutions']) && is_array($_POST['solutions'])) {
        $solutions = array_map('sanitize_text_field', $_POST['solutions']);
    }

    error_log("Apex Demo Request AJAX: Processing from {$first_name} {$last_name} <{$email}>");

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($company) || empty($job_title) || empty($institution_type) || empty($country)) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    if (empty($solutions)) {
        wp_send_json_error(['message' => 'Please select at least one solution of interest.']);
    }

    if (!$privacy) {
        wp_send_json_error(['message' => 'You must agree to the Privacy Policy to submit.']);
    }

    // Handle file attachment
    $attachments = [];
    $temp_file_path = '';

    if (!empty($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['attachment'];
        $max_size = 5 * 1024 * 1024; // 5MB

        // Validate file size
        if ($file['size'] > $max_size) {
            wp_send_json_error(['message' => 'File is too large. Maximum size is 5MB.']);
        }

        // Validate file type
        $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'png', 'jpg', 'jpeg'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            wp_send_json_error(['message' => 'Invalid file type. Allowed: PDF, Word, Excel, PowerPoint, PNG, JPG.']);
        }

        // Validate MIME type
        $allowed_mimes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detected_mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $valid_mime = false;
        foreach ($allowed_mimes as $ext => $mime) {
            if ($detected_mime === $mime) {
                $valid_mime = true;
                break;
            }
        }
        // Also accept generic octet-stream for Office docs
        if (!$valid_mime && $detected_mime === 'application/octet-stream' && in_array($file_ext, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
            $valid_mime = true;
        }
        // Also accept application/zip for Office Open XML formats
        if (!$valid_mime && $detected_mime === 'application/zip' && in_array($file_ext, ['docx', 'xlsx', 'pptx'])) {
            $valid_mime = true;
        }

        if (!$valid_mime) {
            error_log("Apex Demo Request AJAX: Rejected file MIME type: {$detected_mime} for extension: {$file_ext}");
            wp_send_json_error(['message' => 'Invalid file type detected. Please upload an allowed document.']);
        }

        // Sanitize filename and move to temp location
        $safe_name = sanitize_file_name($file['name']);
        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/demo-request-temp';
        if (!file_exists($temp_dir)) {
            wp_mkdir_p($temp_dir);
            // Add .htaccess to block direct access
            file_put_contents($temp_dir . '/.htaccess', 'Deny from all');
        }

        $temp_file_path = $temp_dir . '/' . uniqid('demo_') . '_' . $safe_name;
        if (!move_uploaded_file($file['tmp_name'], $temp_file_path)) {
            error_log('Apex Demo Request AJAX: Failed to move uploaded file');
            wp_send_json_error(['message' => 'Failed to process uploaded file. Please try again.']);
        }

        $attachments[] = [
            'path' => $temp_file_path,
            'name' => $safe_name,
        ];

        error_log("Apex Demo Request AJAX: File attached - {$safe_name} ({$file['size']} bytes)");
    } elseif (!empty($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
        // A file was attempted but there was an upload error
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload limit.',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds form upload limit.',
            UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server missing temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'File upload stopped by a server extension.',
        ];
        $err_code = $_FILES['attachment']['error'];
        $err_msg = $upload_errors[$err_code] ?? 'Unknown upload error.';
        error_log("Apex Demo Request AJAX: File upload error code {$err_code}: {$err_msg}");
        wp_send_json_error(['message' => 'File upload error: ' . $err_msg]);
    }

    // Build email
    $email_args = [
        'to'           => 'info@apex-softwares.com',
        'subject'      => 'New Demo Request from ' . $first_name . ' ' . $last_name . ' (' . $company . ')',
        'html_content' => apex_create_demo_request_email_html([
            'first_name'       => $first_name,
            'last_name'        => $last_name,
            'email'            => $email,
            'phone'            => $phone,
            'company'          => $company,
            'job_title'        => $job_title,
            'institution_type' => $institution_type,
            'country'          => $country,
            'solutions'        => $solutions,
            'message'          => $message,
            'has_attachment'   => !empty($attachments),
            'attachment_name'  => !empty($attachments) ? $attachments[0]['name'] : '',
            'submission_date'  => current_time('F j, Y, g:i a'),
            'ip_address'       => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
        ]),
    ];

    if (!empty($attachments)) {
        $email_args['attachments'] = $attachments;
    }

    $email_sent = apex_send_email_direct($email_args);

    // Clean up temp file
    if (!empty($temp_file_path) && file_exists($temp_file_path)) {
        @unlink($temp_file_path);
    }

    error_log('Apex Demo Request AJAX: Email sending result: ' . ($email_sent ? 'SUCCESS' : 'FAILED'));

    if ($email_sent) {
        wp_send_json_success(['message' => 'Thank you! Your demo request has been submitted. Our team will contact you within 24 hours to schedule your personalized demo.']);
    } else {
        wp_send_json_error(['message' => 'Failed to submit your request. Please try again later or contact us directly.']);
    }
}
add_action('wp_ajax_apex_demo_request_submit', 'apex_demo_request_ajax_handler');
add_action('wp_ajax_nopriv_apex_demo_request_submit', 'apex_demo_request_ajax_handler');

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

        // Attachments (optional)
        if (!empty($args['attachments']) && is_array($args['attachments'])) {
            foreach ($args['attachments'] as $attachment) {
                if (!empty($attachment['path']) && file_exists($attachment['path'])) {
                    $attach_name = !empty($attachment['name']) ? $attachment['name'] : basename($attachment['path']);
                    $mail->addAttachment($attachment['path'], $attach_name);
                    error_log('Apex Direct Email: Attached file - ' . $attach_name);
                }
            }
        }

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
 * Create HTML email template for newsletter form submissions
 */
function apex_create_newsletter_email_html($data) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Newsletter Subscription</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f8f9fa;
            }
            .container {
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 30px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
                font-weight: 600;
            }
            .header p {
                margin: 10px 0 0 0;
                opacity: 0.9;
            }
            .content {
                padding: 30px;
            }
            .field-group {
                margin-bottom: 25px;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 6px;
                border-left: 4px solid #667eea;
            }
            .field-label {
                font-weight: 600;
                color: #667eea;
                margin-bottom: 10px;
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .field-value {
                margin: 5px 0;
                font-size: 16px;
            }
            .email-box {
                background-color: #e3f2fd;
                padding: 15px;
                border-radius: 4px;
                font-family: 'Courier New', monospace;
                font-size: 16px;
                text-align: center;
                margin: 10px 0;
            }
            .footer {
                background-color: #f8f9fa;
                padding: 20px 30px;
                text-align: center;
                font-size: 14px;
                color: #666;
                border-top: 1px solid #e9ecef;
            }
            .success-badge {
                display: inline-block;
                background-color: #28a745;
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🎉 New Newsletter Subscription</h1>
                <p>Someone wants to stay updated with your latest insights!</p>
            </div>
            
            <div class="content">
                <div class="field-group">
                    <div class="field-label">Subscription Details</div>
                    <p class="field-value"><strong>Status:</strong> <span class="success-badge">New Subscriber</span></p>
                    <div class="email-box">
                        📧 <?php echo esc_html($data['email']); ?>
                    </div>
                </div>
                
                <div class="field-group">
                    <div class="field-label">Submission Information</div>
                    <p class="field-value"><strong>Submitted:</strong> <?php echo esc_html($data['submission_date']); ?></p>
                    <p class="field-value"><strong>IP Address:</strong> <?php echo esc_html($data['ip_address']); ?></p>
                    <p class="field-value"><strong>Source:</strong> Apex Website Footer Newsletter Form</p>
                </div>
                
                <div class="field-group">
                    <div class="field-label">Next Steps</div>
                    <p class="field-value">✅ This email has been added to your newsletter list</p>
                    <p class="field-value">📧 Consider sending a welcome email to the subscriber</p>
                    <p class="field-value">🔄 Add this contact to your email marketing platform</p>
                </div>
            </div>
            
            <div class="footer">
                <p>This email was sent from the Apex Softwares website newsletter form.</p>
                <p>The subscriber has opted-in to receive your newsletter and updates.</p>
            </div>
        </div>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

/**
 * Create HTML email template for demo request form submissions
 */
function apex_create_demo_request_email_html($data) {
    $institution_types = [
        'mfi'        => 'Microfinance Institution (MFI)',
        'sacco'      => 'SACCO / Credit Union',
        'bank'       => 'Commercial Bank',
        'government' => 'Government Agency',
        'ngo'        => 'NGO / Development Organization',
        'other'      => 'Other',
    ];

    $countries = [
        'ke'    => 'Kenya',
        'ug'    => 'Uganda',
        'tz'    => 'Tanzania',
        'ng'    => 'Nigeria',
        'gh'    => 'Ghana',
        'rw'    => 'Rwanda',
        'za'    => 'South Africa',
        'other' => 'Other',
    ];

    $solution_labels = [
        'core-banking'           => 'Core Banking & Microfinance',
        'mobile-wallet'          => 'Mobile Wallet App',
        'agency-banking'         => 'Agency & Branch Banking',
        'internet-banking'       => 'Internet & Mobile Banking',
        'loan-origination'       => 'Loan Origination & Workflows',
        'digital-field-agent'    => 'Digital Field Agent',
        'enterprise-integration' => 'Enterprise Integration',
        'payment-switch'         => 'Payment Switch & General Ledger',
        'reporting-analytics'    => 'Reporting & Analytics',
    ];

    $institution_label = $institution_types[$data['institution_type']] ?? $data['institution_type'];
    $country_label = $countries[$data['country']] ?? $data['country'];

    $solutions_html = '';
    if (!empty($data['solutions'])) {
        foreach ($data['solutions'] as $sol) {
            $label = $solution_labels[$sol] ?? $sol;
            $solutions_html .= '<span style="display:inline-block;background:#fff3e0;color:#e65100;padding:4px 12px;border-radius:20px;font-size:13px;font-weight:500;margin:3px 4px 3px 0;">' . esc_html($label) . '</span>';
        }
    }

    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Demo Request</title>
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
            .header h1 { margin: 0; font-size: 26px; font-weight: 700; }
            .header p { margin: 10px 0 0 0; opacity: 0.9; font-size: 15px; }
            .content {
                background: white;
                padding: 35px;
                border-radius: 0 0 12px 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .field-group {
                margin-bottom: 22px;
                padding-bottom: 22px;
                border-bottom: 1px solid #e2e8f0;
            }
            .field-group:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
            .field-label {
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 8px;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .field-value { color: #475569; font-size: 15px; margin: 4px 0; }
            .field-value strong { color: #1e293b; font-weight: 600; }
            .message-box {
                background: #f8fafc;
                padding: 18px;
                border-radius: 8px;
                border-left: 4px solid #FF6200;
                margin-top: 8px;
            }
            .attachment-badge {
                display: inline-block;
                background: #e3f2fd;
                color: #1565c0;
                padding: 6px 14px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 500;
                margin-top: 6px;
            }
            .footer {
                text-align: center;
                margin-top: 25px;
                padding-top: 18px;
                border-top: 1px solid #e2e8f0;
                color: #64748b;
                font-size: 13px;
            }
            .logo { font-size: 22px; font-weight: 700; color: white; margin-bottom: 5px; }
            .priority-badge {
                display: inline-block;
                background: #10b981;
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                margin-left: 8px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">Apex Softwares</div>
            <h1>New Demo Request</h1>
            <p>A potential client wants to see the platform in action</p>
        </div>

        <div class="content">
            <div class="field-group">
                <div class="field-label">Contact Information</div>
                <p class="field-value"><strong>Name:</strong> <?php echo esc_html($data['first_name'] . ' ' . $data['last_name']); ?></p>
                <p class="field-value"><strong>Email:</strong> <?php echo esc_html($data['email']); ?></p>
                <p class="field-value"><strong>Phone:</strong> <?php echo esc_html($data['phone']); ?></p>
            </div>

            <div class="field-group">
                <div class="field-label">Company Details</div>
                <p class="field-value"><strong>Company:</strong> <?php echo esc_html($data['company']); ?></p>
                <p class="field-value"><strong>Job Title:</strong> <?php echo esc_html($data['job_title']); ?></p>
                <p class="field-value"><strong>Institution Type:</strong> <?php echo esc_html($institution_label); ?></p>
                <p class="field-value"><strong>Country:</strong> <?php echo esc_html($country_label); ?></p>
            </div>

            <div class="field-group">
                <div class="field-label">Solutions of Interest</div>
                <p class="field-value"><?php echo $solutions_html; ?></p>
            </div>

            <?php if (!empty($data['message'])): ?>
            <div class="field-group">
                <div class="field-label">Additional Notes</div>
                <div class="message-box">
                    <p class="field-value"><?php echo nl2br(esc_html($data['message'])); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($data['has_attachment'])): ?>
            <div class="field-group">
                <div class="field-label">Attachment</div>
                <div class="attachment-badge">
                    📎 <?php echo esc_html($data['attachment_name']); ?> (attached to this email)
                </div>
            </div>
            <?php endif; ?>

            <div class="field-group">
                <div class="field-label">Submission Details</div>
                <p class="field-value"><strong>Submitted:</strong> <?php echo esc_html($data['submission_date']); ?></p>
                <p class="field-value"><strong>IP Address:</strong> <?php echo esc_html($data['ip_address']); ?></p>
                <p class="field-value"><strong>Source:</strong> Apex Website - Request Demo Page</p>
            </div>
        </div>

        <div class="footer">
            <p>This email was sent from the Apex Softwares website demo request form.</p>
            <p>Please schedule a demo with this lead within 24 hours.</p>
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
        
        /* ===== Sidebar Widget Wrapper ===== */
        .sidebar-widgets-wrapper .widget-item {
            margin-bottom: 1.75rem;
            padding-bottom: 1.75rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .sidebar-widgets-wrapper .widget-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        /* Widget headings (Gutenberg block headings) */
        .sidebar-widgets-wrapper .wp-block-heading,
        .sidebar-widgets-wrapper .widget-title {
            font-size: 1.125rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 0.75rem !important;
            padding-bottom: 0.625rem !important;
            border-bottom: 2px solid #fed7aa !important;
            line-height: 1.4 !important;
        }

        /* ===== Recent Posts (Block: wp-block-latest-posts) ===== */
        .wp-block-latest-posts,
        .widget_recent_entries ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .wp-block-latest-posts li,
        .widget_recent_entries li {
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            list-style: none !important;
        }

        .wp-block-latest-posts li a,
        .widget_recent_entries li a {
            display: block !important;
            padding: 0.5rem 0.75rem !important;
            border-radius: 0.5rem !important;
            background-color: transparent !important;
            color: #475569 !important;
            text-decoration: none !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
            transition: background-color 0.15s ease, color 0.15s ease !important;
            border-left: 2px solid transparent !important;
        }

        /* Hover: ONLY the single item under the cursor */
        .wp-block-latest-posts li:hover > a,
        .widget_recent_entries li:hover > a {
            background-color: #fff7ed !important;
            color: #ea580c !important;
            border-left-color: #ea580c !important;
        }

        /* ===== Recent Comments (Block: wp-block-latest-comments) ===== */
        .wp-block-latest-comments,
        .widget_recent_comments ul,
        .widget_recent_comments ol {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .wp-block-latest-comments__comment,
        .widget_recent_comments li {
            margin: 0 !important;
            padding: 0.625rem 0.75rem !important;
            border: none !important;
            border-radius: 0.5rem !important;
            border-left: 2px solid transparent !important;
            list-style: none !important;
            transition: background-color 0.15s ease, border-color 0.15s ease !important;
        }

        .wp-block-latest-comments__comment:hover,
        .widget_recent_comments li:hover {
            background-color: #fff7ed !important;
            border-left-color: #ea580c !important;
        }

        /* Comment meta text */
        .wp-block-latest-comments__comment-meta,
        .wp-block-latest-comments__comment footer {
            font-size: 0.8125rem !important;
            line-height: 1.6 !important;
            color: #64748b !important;
        }

        /* Comment author link */
        .wp-block-latest-comments__comment-author,
        .widget_recent_comments .comment-author-link {
            font-weight: 600 !important;
            color: #1e293b !important;
            text-decoration: none !important;
            transition: color 0.15s ease !important;
        }

        /* Comment post link */
        .wp-block-latest-comments__comment-link {
            font-weight: 500 !important;
            color: #475569 !important;
            text-decoration: none !important;
            transition: color 0.15s ease !important;
        }

        /* Hover state for comment links */
        .wp-block-latest-comments__comment:hover .wp-block-latest-comments__comment-author,
        .wp-block-latest-comments__comment:hover .wp-block-latest-comments__comment-link,
        .widget_recent_comments li:hover a {
            color: #ea580c !important;
        }

        /* Comment excerpt if shown */
        .wp-block-latest-comments__comment-excerpt p {
            font-size: 0.8125rem !important;
            color: #64748b !important;
            margin-top: 0.25rem !important;
            line-height: 1.5 !important;
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
        
        // Partners
        ['title' => 'Partners', 'slug' => 'partners', 'href' => home_url('/partners')],
        
        // Standalone items
        ['title' => 'Contact Us', 'slug' => 'contact', 'href' => home_url('/contact')],
        
        // Footer routes from footer.php
        // ['title' => 'Support', 'slug' => 'help-support', 'href' => home_url('/help-support')],
        ['title' => 'Careers', 'slug' => 'careers', 'href' => home_url('/careers'), 'parent' => 'Support'],
        ['title' => 'Help & Support', 'slug' => 'help-support', 'href' => home_url('/help-support'), 'parent' => 'Support'],
        ['title' => 'FAQ', 'slug' => 'faq', 'href' => home_url('/faq'), 'parent' => 'Support'],
        ['title' => 'Knowledge Base', 'slug' => 'knowledge-base', 'href' => home_url('/knowledge-base'), 'parent' => 'Support'],
        ['title' => 'Developers', 'slug' => 'developers', 'href' => home_url('/developers'), 'parent' => 'Support'],
        ['title' => 'Partners', 'slug' => 'partners', 'href' => home_url('/partners'), 'parent' => 'Support'],
        ['title' => 'Request Demo', 'slug' => 'request-demo', 'href' => home_url('/request-demo'), 'parent' => 'Support'],
        
        // ['title' => 'Legal', 'slug' => 'privacy-policy', 'href' => home_url('/privacy-policy')],
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
        'partners' => [
            'title' => 'Partners',
            'acf_group' => ''
        ],
        'developers' => [
            'title' => 'Developers',
            'acf_group' => ''
        ],
        'knowledge-base' => [
            'title' => 'Knowledge Base',
            'acf_group' => ''
        ],
        'faq' => [
            'title' => 'FAQ',
            'acf_group' => ''
        ],
        'help-support' => [
            'title' => 'Help & Support',
            'acf_group' => ''
        ],
        'careers' => [
            'title' => 'Careers',
            'acf_group' => ''
        ],
        'contact' => [
            'title' => 'Contact Us',
            'acf_group' => 'group_contact'
        ],
        'request-demo' => [
            'title' => 'Request Demo',
            'acf_group' => 'group_request_demo'
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
        
        <?php if ($page_slug !== 'home' && $page_slug !== 'solutions-overview' && $page_slug !== 'solutions-core-banking-microfinance' && $page_slug !== 'solutions-mobile-wallet-app' && $page_slug !== 'solutions-agency-branch-banking' && $page_slug !== 'solutions-internet-mobile-banking' && $page_slug !== 'solutions-loan-origination-workflows' && $page_slug !== 'solutions-digital-field-agent' && $page_slug !== 'solutions-enterprise-integration' && $page_slug !== 'solutions-payment-switch-ledger' && $page_slug !== 'solutions-reporting-analytics' && $page_slug !== 'industry-overview' && $page_slug !== 'industry-mfis' && $page_slug !== 'industry-credit-unions' && $page_slug !== 'industry-banks-microfinance' && $page_slug !== 'industry-digital-government' && $page_slug !== 'insights-blog' && $page_slug !== 'request-demo' && $page_slug !== 'insights-success-stories' && $page_slug !== 'insights-webinars' && $page_slug !== 'insights-whitepapers-reports' && $page_slug !== 'partners' && $page_slug !== 'developers' && $page_slug !== 'knowledge-base' && $page_slug !== 'faq' && $page_slug !== 'help-support' && $page_slug !== 'careers'): ?>
        <!-- Hero Section (Common to other pages, not home or solutions pages) -->
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
        <?php endif; ?>

        <?php if ($page_slug === 'home'): ?>
        <!-- Home Page Specific Sections -->
        
        <!-- Hero Slides Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎯 Hero Slides Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This controls the main hero carousel with multiple slides.</strong> Each slide has an image, heading, subheading, and alt text.</p>
                <p><strong>Format for slides:</strong> Enter each slide on a new line using this format:<br>
                <code>Image URL | Heading | Subheading | Alt Text</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_hero_slides">Hero Slides</label></th>
                    <td>
                        <textarea id="apex_hero_slides" name="apex_hero_slides" rows="20" class="large-text"
                                  placeholder="https://images.unsplash.com/photo-1551434678-e076c223a692?w=1920 | Launch Your Digital Bank of the Future | Power your winning neobank strategy with ApexCore – the web-based, multi-tenant core banking platform built for MFIs, SACCOs, and banks. | Digital Core Banking Platform&#10;https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920 | Omnichannel Banking Made Simple | Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint. | Omnichannel Banking Solutions&#10;https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1920 | Extend Your Reach with Agent Banking | Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core. | Agent Banking Solutions"><?php 
                            $slides = get_option('apex_hero_slides_' . $page_slug, "https://images.unsplash.com/photo-1551434678-e076c223a692?w=1920 | Launch Your Digital Bank of the Future | Power your winning neobank strategy with ApexCore – the web-based, multi-tenant core banking platform built for MFIs, SACCOs, and banks. | Digital Core Banking Platform\nhttps://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920 | Omnichannel Banking Made Simple | Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint. | Omnichannel Banking Solutions\nhttps://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1920 | Extend Your Reach with Agent Banking | Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core. | Agent Banking Solutions");
                            echo esc_textarea($slides);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Image URL | Heading | Subheading | Alt Text (one slide per line)</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use high-quality images (1920x1080px recommended). The first slide is shown by default.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_tagline">Hero Tagline</label></th>
                    <td>
                        <input type="text" id="apex_hero_tagline" name="apex_hero_tagline" 
                               value="<?php echo esc_attr(get_option('apex_hero_tagline_' . $page_slug, 'ApexCore Platform')); ?>" 
                               class="regular-text" placeholder="e.g., ApexCore Platform">
                        <p class="description">The tagline displayed below hero slides</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_cta_primary">Primary CTA Text</label></th>
                    <td>
                        <input type="text" id="apex_hero_cta_primary" name="apex_hero_cta_primary" 
                               value="<?php echo esc_attr(get_option('apex_hero_cta_primary_' . $page_slug, 'Explore the Platform')); ?>" 
                               class="regular-text" placeholder="e.g., Explore the Platform">
                        <p class="description">Primary call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_cta_primary_url">Primary CTA URL</label></th>
                    <td>
                        <input type="url" id="apex_hero_cta_primary_url" name="apex_hero_cta_primary_url" 
                               value="<?php echo esc_attr(get_option('apex_hero_cta_primary_url_' . $page_slug, home_url('/request-demo'))); ?>" 
                               class="regular-text" placeholder="/request-demo">
                        <p class="description">Primary call-to-action button URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_cta_secondary">Secondary CTA Text</label></th>
                    <td>
                        <input type="text" id="apex_hero_cta_secondary" name="apex_hero_cta_secondary" 
                               value="<?php echo esc_attr(get_option('apex_hero_cta_secondary_' . $page_slug, 'View Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., View Solutions">
                        <p class="description">Secondary call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_cta_secondary_url">Secondary CTA URL</label></th>
                    <td>
                        <input type="url" id="apex_hero_cta_secondary_url" name="apex_hero_cta_secondary_url" 
                               value="<?php echo esc_attr(get_option('apex_hero_cta_secondary_url_' . $page_slug, home_url('/solutions'))); ?>" 
                               class="regular-text" placeholder="/solutions">
                        <p class="description">Secondary call-to-action button URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_banner_text">Banner Text</label></th>
                    <td>
                        <input type="text" id="apex_hero_banner_text" name="apex_hero_banner_text" 
                               value="<?php echo esc_attr(get_option('apex_hero_banner_text_' . $page_slug, 'Apex Softwares\' technology solutions impact <strong>100+ financial institutions</strong> across Africa.')); ?>" 
                               class="regular-text" placeholder="Banner text below hero">
                        <p class="description">Banner text below hero (HTML allowed)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_banner_link_text">Banner Link Text</label></th>
                    <td>
                        <input type="text" id="apex_hero_banner_link_text" name="apex_hero_banner_link_text" 
                               value="<?php echo esc_attr(get_option('apex_hero_banner_link_text_' . $page_slug, 'Learn More')); ?>" 
                               class="regular-text" placeholder="e.g., Learn More">
                        <p class="description">Banner link text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_banner_link_url">Banner Link URL</label></th>
                    <td>
                        <input type="url" id="apex_hero_banner_link_url" name="apex_hero_banner_link_url" 
                               value="<?php echo esc_attr(get_option('apex_hero_banner_link_url_' . $page_slug, home_url('/about-us'))); ?>" 
                               class="regular-text" placeholder="/about-us">
                        <p class="description">Banner link URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Who We Are Section -->
        <div style="margin-bottom: 30px;">
            <h4>🏢 Who We Are Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section introduces your company with key features and statistics.</strong> Includes badge, heading, description, feature cards with icons, and an image.</p>
                <p><strong>Format for features:</strong> Enter each feature on a new line using this format:<br>
                <code>Icon Name | Title | Text</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_who_we_are_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_who_we_are_badge" name="apex_who_we_are_badge" 
                               value="<?php echo esc_attr(get_option('apex_who_we_are_badge_' . $page_slug, 'Who We Are')); ?>" 
                               class="regular-text" placeholder="e.g., Who We Are">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_who_we_are_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_who_we_are_heading" name="apex_who_we_are_heading" 
                               value="<?php echo esc_attr(get_option('apex_who_we_are_heading_' . $page_slug, 'Pioneering Digital Financial Solutions Across Africa')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the who we are section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_who_we_are_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_who_we_are_description" name="apex_who_we_are_description" rows="4" class="large-text"
                                  placeholder="Company description"><?php 
                            echo esc_textarea(get_option('apex_who_we_are_description_' . $page_slug, 'Apex Softwares is a leading financial technology company dedicated to transforming how financial institutions operate. With over a decade of experience, we deliver innovative, scalable, and secure solutions that empower banks, MFIs, and SACCOs to thrive in the digital age.'));
                        ?></textarea>
                        <p class="description">Company description paragraph</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_who_we_are_features">Feature Cards</label></th>
                    <td>
                        <textarea id="apex_who_we_are_features" name="apex_who_we_are_features" rows="12" class="large-text"
                                  placeholder="shield | Trusted Partner | 100+ financial institutions rely on our platform&#10;globe | Pan-African Reach | Operating across 15+ countries in Africa&#10;award | Industry Leader | Award-winning fintech solutions since 2010"><?php 
                            $features = get_option('apex_who_we_are_features_' . $page_slug, "shield | Trusted Partner | 100+ financial institutions rely on our platform\nglobe | Pan-African Reach | Operating across 15+ countries in Africa\naward | Industry Leader | Award-winning fintech solutions since 2010");
                            echo esc_textarea($features);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Icon Name | Title | Text (one feature per line)</p>
                        <p class="description"><strong>Available icons:</strong> shield, globe, award, users, building, etc.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_who_we_are_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_who_we_are_image" name="apex_who_we_are_image" 
                               value="<?php echo esc_attr(get_option('apex_who_we_are_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">Image URL for the who we are section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_who_we_are_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_who_we_are_cta_text" name="apex_who_we_are_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_who_we_are_cta_text_' . $page_slug, 'Learn More About Us')); ?>" 
                               class="regular-text" placeholder="e.g., Learn More About Us">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_who_we_are_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_who_we_are_cta_url" name="apex_who_we_are_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_who_we_are_cta_url_' . $page_slug, home_url('/about-us'))); ?>" 
                               class="regular-text" placeholder="/about-us">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- What We Do Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚙️ What We Do Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your services/solutions.</strong> Each service includes an icon, title, description, link, and color theme.</p>
                <p><strong>Format for services:</strong> Enter each service on a new line using this format:<br>
                <code>Icon | Title | Description | Link | Color</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_what_we_do_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_what_we_do_badge" name="apex_what_we_do_badge" 
                               value="<?php echo esc_attr(get_option('apex_what_we_do_badge_' . $page_slug, 'What We Do')); ?>" 
                               class="regular-text" placeholder="e.g., What We Do">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_what_we_do_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_what_we_do_heading" name="apex_what_we_do_heading" 
                               value="<?php echo esc_attr(get_option('apex_what_we_do_heading_' . $page_slug, 'Comprehensive Financial Technology Solutions')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the what we do section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_what_we_do_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_what_we_do_description" name="apex_what_we_do_description" rows="3" class="large-text"
                                  placeholder="Services description"><?php 
                            echo esc_textarea(get_option('apex_what_we_do_description_' . $page_slug, 'We provide end-to-end digital banking solutions that transform how financial institutions serve their customers.'));
                        ?></textarea>
                        <p class="description">Brief description of your services</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_what_we_do_services">Services List</label></th>
                    <td>
                        <textarea id="apex_what_we_do_services" name="apex_what_we_do_services" rows="25" class="large-text"
                                  placeholder="database | Core Banking System | A robust, scalable core banking platform that handles deposits, loans, payments, and accounting with real-time processing. | /solutions/core-banking | blue&#10;smartphone | Mobile Banking | Native mobile applications for iOS and Android with biometric authentication, instant transfers, and bill payments. | /solutions/mobile-banking | orange"><?php 
                            $services = get_option('apex_what_we_do_services_' . $page_slug, "database | Core Banking System | A robust, scalable core banking platform that handles deposits, loans, payments, and accounting with real-time processing. | /solutions/core-banking | blue\nsmartphone | Mobile Banking | Native mobile applications for iOS and Android with biometric authentication, instant transfers, and bill payments. | /solutions/mobile-banking | orange\nusers | Agent Banking | Extend your reach with agent networks. Enable cash-in, cash-out, account opening, and loan collections. | /solutions/agent-banking | green\ncredit-card | Payment Gateway | Secure payment processing with support for cards, mobile money, bank transfers, and QR payments. | /solutions/payments | purple\nbar-chart | Analytics & Reporting | Real-time dashboards, regulatory reports, and business intelligence tools for data-driven decisions. | /solutions/analytics | cyan\nshield | Risk & Compliance | AML/KYC compliance, fraud detection, credit scoring, and regulatory reporting automation. | /solutions/compliance | red");
                            echo esc_textarea($services);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Icon | Title | Description | Link | Color (one service per line)</p>
                        <p class="description"><strong>Available colors:</strong> blue, orange, green, purple, cyan, red</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_what_we_do_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_what_we_do_cta_text" name="apex_what_we_do_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_what_we_do_cta_text_' . $page_slug, 'Explore All Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., Explore All Solutions">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_what_we_do_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_what_we_do_cta_url" name="apex_what_we_do_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_what_we_do_cta_url_' . $page_slug, home_url('/solutions'))); ?>" 
                               class="regular-text" placeholder="/solutions">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- How We Do It Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔄 How We Do It Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section explains your implementation process.</strong> Each step includes a number, title, description, icon, and duration.</p>
                <p><strong>Format for steps:</strong> Enter each step on a new line using this format:<br>
                <code>Number | Title | Description | Icon | Duration</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_how_we_do_it_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_how_we_do_it_badge" name="apex_how_we_do_it_badge" 
                               value="<?php echo esc_attr(get_option('apex_how_we_do_it_badge_' . $page_slug, 'How We Do It')); ?>" 
                               class="regular-text" placeholder="e.g., How We Do It">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_how_we_do_it_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_how_we_do_it_heading" name="apex_how_we_do_it_heading" 
                               value="<?php echo esc_attr(get_option('apex_how_we_do_it_heading_' . $page_slug, 'Our Proven Implementation Approach')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the how we do it section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_how_we_do_it_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_how_we_do_it_description" name="apex_how_we_do_it_description" rows="3" class="large-text"
                                  placeholder="Process description"><?php 
                            echo esc_textarea(get_option('apex_how_we_do_it_description_' . $page_slug, 'We follow a structured methodology that ensures successful deployments, minimal disruption, and maximum value for your institution.'));
                        ?></textarea>
                        <p class="description">Brief description of your implementation approach</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_how_we_do_it_steps">Implementation Steps</label></th>
                    <td>
                        <textarea id="apex_how_we_do_it_steps" name="apex_how_we_do_it_steps" rows="20" class="large-text"
                                  placeholder="01 | Discovery & Assessment | We analyze your current systems, processes, and requirements to create a tailored implementation roadmap. | search | 2-4 Weeks&#10;02 | Solution Design | Our architects design a customized solution that integrates seamlessly with your existing infrastructure. | layout | 3-6 Weeks"><?php 
                            $steps = get_option('apex_how_we_do_it_steps_' . $page_slug, "01 | Discovery & Assessment | We analyze your current systems, processes, and requirements to create a tailored implementation roadmap. | search | 2-4 Weeks\n02 | Solution Design | Our architects design a customized solution that integrates seamlessly with your existing infrastructure. | layout | 3-6 Weeks\n03 | Development & Configuration | We configure the platform to your specifications and develop any custom modules required. | code | 6-12 Weeks\n04 | Testing & Training | Rigorous testing ensures quality while comprehensive training prepares your team for success. | check-circle | 4-6 Weeks\n05 | Go-Live & Support | We ensure a smooth launch with dedicated support and continuous optimization post-deployment. | rocket | Ongoing");
                            echo esc_textarea($steps);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Number | Title | Description | Icon | Duration (one step per line)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_how_we_do_it_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_how_we_do_it_cta_text" name="apex_how_we_do_it_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_how_we_do_it_cta_text_' . $page_slug, 'Start Your Journey')); ?>" 
                               class="regular-text" placeholder="e.g., Start Your Journey">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_how_we_do_it_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_how_we_do_it_cta_url" name="apex_how_we_do_it_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_how_we_do_it_cta_url_' . $page_slug, home_url('/contact'))); ?>" 
                               class="regular-text" placeholder="/contact">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Statistics Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Statistics Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays key statistics with icons and values.</strong> Each stat includes a value, suffix, label, and icon.</p>
                <p><strong>Format for statistics:</strong> Enter each stat on a new line using this format:<br>
                <code>Value | Suffix | Label | Icon</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_statistics_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_statistics_heading" name="apex_statistics_heading" 
                               value="<?php echo esc_attr(get_option('apex_statistics_heading_' . $page_slug, 'Powering Financial Institutions Across Africa')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the statistics section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_statistics_subheading">Section Subheading</label></th>
                    <td>
                        <textarea id="apex_statistics_subheading" name="apex_statistics_subheading" rows="2" class="large-text"
                                  placeholder="Section subheading"><?php 
                            echo esc_textarea(get_option('apex_statistics_subheading_' . $page_slug, 'Our platform processes millions of transactions daily, serving customers across the continent.'));
                        ?></textarea>
                        <p class="description">Brief description below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_statistics_stats">Statistics List</label></th>
                    <td>
                        <textarea id="apex_statistics_stats" name="apex_statistics_stats" rows="12" class="large-text"
                                  placeholder="100 | + | Financial Institutions | building&#10;15 | + | Countries Served | globe&#10;5 | M+ | Active Users | users&#10;99.9 | % | Uptime SLA | shield"><?php 
                            $stats = get_option('apex_statistics_stats_' . $page_slug, "100 | + | Financial Institutions | building\n15 | + | Countries Served | globe\n5 | M+ | Active Users | users\n99.9 | % | Uptime SLA | shield");
                            echo esc_textarea($stats);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Value | Suffix | Label | Icon (one stat per line)</p>
                        <p class="description"><strong>Example:</strong> 100 | + | Financial Institutions | building</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_statistics_background_image">Background Image URL</label></th>
                    <td>
                        <input type="url" id="apex_statistics_background_image" name="apex_statistics_background_image" 
                               value="<?php echo esc_attr(get_option('apex_statistics_background_image_' . $page_slug, 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">Background image for statistics section</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Testimonials Section -->
        <div style="margin-bottom: 30px;">
            <h4>💬 Testimonials Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays client testimonials.</strong> Each testimonial includes quote, author, position, company, image, and rating.</p>
                <p><strong>Format for testimonials:</strong> Enter each testimonial on a new line using this format:<br>
                <code>Quote | Author | Position | Company | Image URL | Rating (1-5)</code></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_testimonials_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_testimonials_badge" name="apex_testimonials_badge" 
                               value="<?php echo esc_attr(get_option('apex_testimonials_badge_' . $page_slug, 'Client Success Stories')); ?>" 
                               class="regular-text" placeholder="e.g., Client Success Stories">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_testimonials_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_testimonials_heading" name="apex_testimonials_heading" 
                               value="<?php echo esc_attr(get_option('apex_testimonials_heading_' . $page_slug, 'Trusted by Leading Financial Institutions')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the testimonials section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_testimonials_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_testimonials_description" name="apex_testimonials_description" rows="3" class="large-text"
                                  placeholder="Section description"><?php 
                            echo esc_textarea(get_option('apex_testimonials_description_' . $page_slug, 'See what our clients say about transforming their operations with ApexCore.'));
                        ?></textarea>
                        <p class="description">Brief description of the testimonials section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_testimonials_list">Testimonials List</label></th>
                    <td>
                        <textarea id="apex_testimonials_list" name="apex_testimonials_list" rows="20" class="large-text"
                                  placeholder="ApexCore has revolutionized our operations. We've seen a 40% increase in efficiency and our customers love the new mobile banking experience. | James Mwangi | CEO | Unity SACCO | https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150 | 5"><?php 
                            $testimonials = get_option('apex_testimonials_list_' . $page_slug, "ApexCore has revolutionized our operations. We've seen a 40% increase in efficiency and our customers love the new mobile banking experience. | James Mwangi | CEO | Unity SACCO | https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150 | 5\nThe implementation was smooth and the support team is exceptional. We went live in just 12 weeks with zero downtime. | Sarah Ochieng | CTO | Premier MFI | https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150 | 5\nThe agent banking module has helped us reach rural communities we couldn't serve before. Our customer base has grown by 60%. | David Kimani | Operations Director | Heritage Bank | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150 | 5\nReal-time reporting and analytics have transformed how we make decisions. We now have complete visibility into our operations. | Grace Wanjiku | Finance Manager | Faulu Microfinance | https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150 | 5");
                            echo esc_textarea($testimonials);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Quote | Author | Position | Company | Image URL | Rating (one testimonial per line)</p>
                        <p class="description"><strong>Rating:</strong> Use 1-5 for star rating</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Partners Section -->
        <div style="margin-bottom: 30px;">
            <h4>🤝 Partners Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your technology and integration partners.</strong> Includes badge, heading, description, and call-to-action.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_partners_badge" name="apex_partners_badge" 
                               value="<?php echo esc_attr(get_option('apex_partners_badge_' . $page_slug, 'Our Partners')); ?>" 
                               class="regular-text" placeholder="e.g., Our Partners">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_heading" name="apex_partners_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_heading_' . $page_slug, 'Trusted Technology & Integration Partners')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the partners section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_partners_description" name="apex_partners_description" rows="3" class="large-text"
                                  placeholder="Partners description"><?php 
                            echo esc_textarea(get_option('apex_partners_description_' . $page_slug, 'We collaborate with leading technology providers to deliver comprehensive solutions.'));
                        ?></textarea>
                        <p class="description">Brief description of your partnerships</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_partners_cta_text" name="apex_partners_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_partners_cta_text_' . $page_slug, 'Become a Partner')); ?>" 
                               class="regular-text" placeholder="e.g., Become a Partner">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_partners_cta_url" name="apex_partners_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_partners_cta_url_' . $page_slug, home_url('/partners'))); ?>" 
                               class="regular-text" placeholder="/partners">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- ROI Calculator Section -->
        <div style="margin-bottom: 30px;">
            <h4>💰 ROI Calculator Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section provides an interactive ROI calculator.</strong> Includes badge, heading, description, and call-to-action.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_roi_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_roi_badge" name="apex_roi_badge" 
                               value="<?php echo esc_attr(get_option('apex_roi_badge_' . $page_slug, 'ROI Calculator')); ?>" 
                               class="regular-text" placeholder="e.g., ROI Calculator">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_roi_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_roi_heading" name="apex_roi_heading" 
                               value="<?php echo esc_attr(get_option('apex_roi_heading_' . $page_slug, 'Calculate Your Return on Investment')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the ROI calculator section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_roi_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_roi_description" name="apex_roi_description" rows="3" class="large-text"
                                  placeholder="ROI description"><?php 
                            echo esc_textarea(get_option('apex_roi_description_' . $page_slug, 'See how ApexCore can transform your financial institution\'s efficiency and profitability.'));
                        ?></textarea>
                        <p class="description">Brief description of the ROI calculator</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_roi_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_roi_cta_text" name="apex_roi_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_roi_cta_text_' . $page_slug, 'Get Detailed Analysis')); ?>" 
                               class="regular-text" placeholder="e.g., Get Detailed Analysis">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_roi_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_roi_cta_url" name="apex_roi_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_roi_cta_url_' . $page_slug, home_url('/contact'))); ?>" 
                               class="regular-text" placeholder="/contact">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Case Studies Section -->
        <div style="margin-bottom: 30px;">
            <h4>📚 Case Studies Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases client success stories and case studies.</strong> Includes badge, heading, description, and call-to-action.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_case_studies_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_case_studies_badge" name="apex_case_studies_badge" 
                               value="<?php echo esc_attr(get_option('apex_case_studies_badge_' . $page_slug, 'Case Studies')); ?>" 
                               class="regular-text" placeholder="e.g., Case Studies">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_case_studies_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_case_studies_heading" name="apex_case_studies_heading" 
                               value="<?php echo esc_attr(get_option('apex_case_studies_heading_' . $page_slug, 'Real Results from Real Clients')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the case studies section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_case_studies_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_case_studies_description" name="apex_case_studies_description" rows="3" class="large-text"
                                  placeholder="Case studies description"><?php 
                            echo esc_textarea(get_option('apex_case_studies_description_' . $page_slug, 'Discover how financial institutions across Africa have transformed their operations with ApexCore.'));
                        ?></textarea>
                        <p class="description">Brief description of the case studies</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_case_studies_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_case_studies_cta_text" name="apex_case_studies_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_case_studies_cta_text_' . $page_slug, 'View All Case Studies')); ?>" 
                               class="regular-text" placeholder="e.g., View All Case Studies">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_case_studies_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_case_studies_cta_url" name="apex_case_studies_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_case_studies_cta_url_' . $page_slug, home_url('/case-studies'))); ?>" 
                               class="regular-text" placeholder="/case-studies">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- API Integration Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔌 API Integration Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases your developer platform and API capabilities.</strong> Includes badge, heading, description, and dual call-to-action buttons.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_api_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_api_badge" name="apex_api_badge" 
                               value="<?php echo esc_attr(get_option('apex_api_badge_' . $page_slug, 'Developer Platform')); ?>" 
                               class="regular-text" placeholder="e.g., Developer Platform">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_api_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_api_heading" name="apex_api_heading" 
                               value="<?php echo esc_attr(get_option('apex_api_heading_' . $page_slug, 'Powerful API & Integration Capabilities')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the API section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_api_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_api_description" name="apex_api_description" rows="3" class="large-text"
                                  placeholder="API description"><?php 
                            echo esc_textarea(get_option('apex_api_description_' . $page_slug, 'Build custom solutions with our comprehensive REST APIs, webhooks, and SDKs. Connect ApexCore to your existing systems seamlessly.'));
                        ?></textarea>
                        <p class="description">Brief description of your API capabilities</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_api_primary_cta_text">Primary CTA Text</label></th>
                    <td>
                        <input type="text" id="apex_api_primary_cta_text" name="apex_api_primary_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_api_primary_cta_text_' . $page_slug, 'View API Documentation')); ?>" 
                               class="regular-text" placeholder="e.g., View API Documentation">
                        <p class="description">Primary call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_api_primary_cta_url">Primary CTA URL</label></th>
                    <td>
                        <input type="url" id="apex_api_primary_cta_url" name="apex_api_primary_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_api_primary_cta_url_' . $page_slug, home_url('/developers/api-docs'))); ?>" 
                               class="regular-text" placeholder="/developers/api-docs">
                        <p class="description">Primary call-to-action button URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_api_secondary_cta_text">Secondary CTA Text</label></th>
                    <td>
                        <input type="text" id="apex_api_secondary_cta_text" name="apex_api_secondary_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_api_secondary_cta_text_' . $page_slug, 'Get API Keys')); ?>" 
                               class="regular-text" placeholder="e.g., Get API Keys">
                        <p class="description">Secondary call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_api_secondary_cta_url">Secondary CTA URL</label></th>
                    <td>
                        <input type="url" id="apex_api_secondary_cta_url" name="apex_api_secondary_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_api_secondary_cta_url_' . $page_slug, home_url('/developers/register'))); ?>" 
                               class="regular-text" placeholder="/developers/register">
                        <p class="description">Secondary call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Compliance & Security Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔒 Compliance & Security Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section highlights your security and compliance certifications.</strong> Includes badge, heading, description, and call-to-action.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_compliance_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_compliance_badge" name="apex_compliance_badge" 
                               value="<?php echo esc_attr(get_option('apex_compliance_badge_' . $page_slug, 'Security & Compliance')); ?>" 
                               class="regular-text" placeholder="e.g., Security & Compliance">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_compliance_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_compliance_heading" name="apex_compliance_heading" 
                               value="<?php echo esc_attr(get_option('apex_compliance_heading_' . $page_slug, 'Enterprise-Grade Security You Can Trust')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the compliance section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_compliance_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_compliance_description" name="apex_compliance_description" rows="3" class="large-text"
                                  placeholder="Compliance description"><?php 
                            echo esc_textarea(get_option('apex_compliance_description_' . $page_slug, 'ApexCore meets the highest standards of security, privacy, and regulatory compliance required by financial institutions worldwide.'));
                        ?></textarea>
                        <p class="description">Brief description of your compliance standards</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_compliance_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_compliance_cta_text" name="apex_compliance_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_compliance_cta_text_' . $page_slug, 'Download Security Whitepaper')); ?>" 
                               class="regular-text" placeholder="e.g., Download Security Whitepaper">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_compliance_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_compliance_cta_url" name="apex_compliance_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_compliance_cta_url_' . $page_slug, home_url('/insights/whitepapers-reports'))); ?>" 
                               class="regular-text" placeholder="/insights/whitepapers-reports">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- What's New Section -->
        <div style="margin-bottom: 30px;">
            <h4>📰 What's New Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays latest news and blog posts.</strong> Includes badge, heading, description, posts per page setting, and call-to-action.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_whats_new_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_whats_new_badge" name="apex_whats_new_badge" 
                               value="<?php echo esc_attr(get_option('apex_whats_new_badge_' . $page_slug, "What's New")); ?>" 
                               class="regular-text" placeholder="e.g., What's New">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_whats_new_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_whats_new_heading" name="apex_whats_new_heading" 
                               value="<?php echo esc_attr(get_option('apex_whats_new_heading_' . $page_slug, 'Latest News & Insights')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the what's new section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_whats_new_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_whats_new_description" name="apex_whats_new_description" rows="3" class="large-text"
                                  placeholder="News description"><?php 
                            echo esc_textarea(get_option('apex_whats_new_description_' . $page_slug, 'Stay updated with the latest developments in financial technology and Apex Softwares.'));
                        ?></textarea>
                        <p class="description">Brief description of the news section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_whats_new_posts_per_page">Posts Per Page</label></th>
                    <td>
                        <input type="number" id="apex_whats_new_posts_per_page" name="apex_whats_new_posts_per_page" 
                               value="<?php echo esc_attr(get_option('apex_whats_new_posts_per_page_' . $page_slug, '3')); ?>" 
                               class="regular-text" placeholder="3" min="1" max="10">
                        <p class="description">Number of posts to display (1-10)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_whats_new_cta_text">CTA Button Text</label></th>
                    <td>
                        <input type="text" id="apex_whats_new_cta_text" name="apex_whats_new_cta_text" 
                               value="<?php echo esc_attr(get_option('apex_whats_new_cta_text_' . $page_slug, 'View All Articles')); ?>" 
                               class="regular-text" placeholder="e.g., View All Articles">
                        <p class="description">Call-to-action button text</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_whats_new_cta_url">CTA Button URL</label></th>
                    <td>
                        <input type="url" id="apex_whats_new_cta_url" name="apex_whats_new_cta_url" 
                               value="<?php echo esc_attr(get_option('apex_whats_new_cta_url_' . $page_slug, home_url('/blog'))); ?>" 
                               class="regular-text" placeholder="/blog">
                        <p class="description">Call-to-action button URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <?php endif; ?>
        
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
                <tr>
                    <th scope="row"><label for="apex_contact_sales_email">Sales Email</label></th>
                    <td>
                        <input type="email" id="apex_contact_sales_email" name="apex_contact_sales_email" 
                               value="<?php echo esc_attr(get_option('apex_contact_sales_email_' . $page_slug, 'sales@apex-softwares.com')); ?>" 
                               class="regular-text" placeholder="e.g., sales@apex-softwares.com">
                        <p class="description">Sales contact email displayed in the Email Us card</p>
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
                <p><strong>Format per card type (one card per line):</strong></p>
                <code>phone | Title | Description | Phone Number | Weekday Hours | Saturday Hours | Sunday &amp; Holiday Status</code><br>
                <code>email | Title | Description | Email 1 | Email 2</code><br>
                <code>hours | Title | Description | Weekday Hours | Saturday Hours | Sunday &amp; Holiday Status</code><br>
                <code>social | Title | Description | URL 1 | URL 2 | URL 3 | URL 4</code>
                <p style="margin-top:10px;"><strong>Available types:</strong> phone, email, hours, social</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_contact_sidebar_items">Contact Cards</label></th>
                    <td>
                        <textarea id="apex_contact_sidebar_items" name="apex_contact_sidebar_items" rows="12" class="large-text"
                                  placeholder="phone | Call Us | Speak directly with our team | +254 700 000 000 | 8am - 6pm | 8am - 1pm | Closed&#10;email | Email Us | We'll respond within 24 hours | info@apex-softwares.com | sales@apex-softwares.com&#10;hours | Support Hours | 24/7 for critical issues | 8am - 6pm | 8am - 1pm | Closed&#10;social | Follow Us | Stay updated with our latest news | https://linkedin.com | https://twitter.com | https://facebook.com | https://youtube.com"><?php 
                            $sidebar_items = get_option('apex_contact_sidebar_items_' . $page_slug, "phone | Call Us | Speak directly with our team | +254 700 000 000 | 8am - 6pm | 8am - 1pm | Closed\nemail | Email Us | We'll respond within 24 hours | info@apex-softwares.com | sales@apex-softwares.com\nhours | Support Hours | 24/7 for critical issues | 8am - 6pm | 8am - 1pm | Closed\nsocial | Follow Us | Stay updated with our latest news | https://linkedin.com | https://twitter.com | https://facebook.com | https://youtube.com");
                            echo esc_textarea($sidebar_items);
                        ?></textarea>
                        <p class="description"><strong>Format varies by type</strong> — see the guide above. One card per line.</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> For <strong>phone</strong> &amp; <strong>hours</strong> cards: set Weekday Hours, Saturday Hours, and Sunday &amp; Holiday Status separately (e.g. <code>8am - 6pm | 8am - 1pm | Closed</code>). For <strong>email</strong> cards: use email addresses. For <strong>social</strong> cards: use full URLs.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Contact Details -->
        <div style="margin-bottom: 30px;">
            <h4>📞 Contact Details</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>These settings control the contact information displayed in the Call Us and Email Us cards.</strong> These override the footer settings for the contact page.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_contact_phone">Phone Number</label></th>
                    <td>
                        <input type="tel" id="apex_contact_phone" name="apex_contact_phone" 
                               value="<?php echo esc_attr(get_option('apex_contact_phone_' . $page_slug, get_option('apex_footer_phone', '+254 700 000 000'))); ?>" 
                               class="regular-text" placeholder="+254 700 000 000">
                        <p class="description">Main contact phone number displayed in Call Us card. Falls back to footer phone if not set.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_email_main">Main Email Address</label></th>
                    <td>
                        <input type="email" id="apex_contact_email_main" name="apex_contact_email_main" 
                               value="<?php echo esc_attr(get_option('apex_contact_email_main_' . $page_slug, get_option('apex_footer_email', 'info@apex-softwares.com'))); ?>" 
                               class="regular-text" placeholder="info@apex-softwares.com">
                        <p class="description">Main contact email displayed in Email Us card. Falls back to footer email if not set.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_contact_email_sales">Sales Email Address</label></th>
                    <td>
                        <input type="email" id="apex_contact_email_sales" name="apex_contact_email_sales" 
                               value="<?php echo esc_attr(get_option('apex_contact_email_sales_' . $page_slug, 'sales@apex-softwares.com')); ?>" 
                               class="regular-text" placeholder="sales@apex-softwares.com">
                        <p class="description">Sales email address displayed in Email Us card.</p>
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
                    <th scope="row"><label>Default Office Hours</label></th>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div>
                                <label for="apex_offices_weekday_hours" style="display: block; font-weight: 600; margin-bottom: 5px;">Weekdays (Mon - Fri):</label>
                                <input type="text" id="apex_offices_weekday_hours" name="apex_offices_weekday_hours" 
                                       value="<?php echo esc_attr(get_option('apex_offices_weekday_hours_' . $page_slug, get_option('apex_footer_weekday_hours', '8am - 6pm'))); ?>" 
                                       class="regular-text" placeholder="e.g., 8am - 6pm">
                            </div>
                            <div>
                                <label for="apex_offices_saturday_hours" style="display: block; font-weight: 600; margin-bottom: 5px;">Saturday:</label>
                                <input type="text" id="apex_offices_saturday_hours" name="apex_offices_saturday_hours" 
                                       value="<?php echo esc_attr(get_option('apex_offices_saturday_hours_' . $page_slug, get_option('apex_footer_saturday_hours', '8am - 1pm'))); ?>" 
                                       class="regular-text" placeholder="e.g., 8am - 1pm">
                            </div>
                            <div>
                                <label for="apex_offices_sunday_holiday_status" style="display: block; font-weight: 600; margin-bottom: 5px;">Sunday & Holidays:</label>
                                <input type="text" id="apex_offices_sunday_holiday_status" name="apex_offices_sunday_holiday_status" 
                                       value="<?php echo esc_attr(get_option('apex_offices_sunday_holiday_status_' . $page_slug, get_option('apex_footer_sunday_holiday_status', 'Closed'))); ?>" 
                                       class="regular-text" placeholder="e.g., Closed">
                            </div>
                        </div>
                        <p class="description">Default office hours displayed in the map section and contact page. Falls back to footer business hours if not set.</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> These hours are used in the Support Hours card on the contact page and in the map section. They sync with footer business hours settings.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-overview'): ?>
        <!-- Solutions Overview Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_solutions_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_solutions_hero_badge" name="apex_solutions_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_solutions_hero_badge_' . $page_slug, 'Our Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., Our Solutions">
                        <p class="description">The small badge text above the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_solutions_hero_heading" name="apex_solutions_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_solutions_hero_heading_' . $page_slug, 'Complete Digital Banking Suite')); ?>" 
                               class="regular-text" placeholder="Main hero heading">
                        <p class="description">The main heading for the hero section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_solutions_hero_description" name="apex_solutions_hero_description" rows="4" class="large-text"
                                  placeholder="Hero section description"><?php echo esc_textarea(get_option('apex_solutions_hero_description_' . $page_slug, 'From core banking to mobile wallets, we provide end-to-end solutions that help financial institutions digitize operations, reach more customers, and drive growth.')); ?></textarea>
                        <p class="description">The description text below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_solutions_hero_image" name="apex_solutions_hero_image" 
                               value="<?php echo esc_attr(get_option('apex_solutions_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">The main hero image URL (recommended size: 1200x800px)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_hero_stats">Statistics</label></th>
                    <td>
                        <textarea id="apex_solutions_hero_stats" name="apex_solutions_hero_stats" rows="6" class="large-text"
                                  placeholder="10+ | Product Modules&#10;100+ | Institutions&#10;99.9% | Uptime&#10;24/7 | Support"><?php 
                            $stats = get_option('apex_solutions_hero_stats_' . $page_slug, "10+ | Product Modules\n100+ | Institutions\n99.9% | Uptime\n24/7 | Support");
                            echo esc_textarea($stats);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Value | Label (one stat per line)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Solutions Grid Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚙️ Solutions Grid Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the grid of solution cards.</strong> Each card has an icon, title, description, and link.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_solutions_grid_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_solutions_grid_badge" name="apex_solutions_grid_badge" 
                               value="<?php echo esc_attr(get_option('apex_solutions_grid_badge_' . $page_slug, 'Product Suite')); ?>" 
                               class="regular-text" placeholder="e.g., Product Suite">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_grid_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_solutions_grid_heading" name="apex_solutions_grid_heading" 
                               value="<?php echo esc_attr(get_option('apex_solutions_grid_heading_' . $page_slug, 'Everything You Need to Succeed')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the solutions grid</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_grid_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_solutions_grid_description" name="apex_solutions_grid_description" rows="3" class="large-text"
                                  placeholder="Section description"><?php echo esc_textarea(get_option('apex_solutions_grid_description_' . $page_slug, 'Our modular platform lets you start with what you need and add capabilities as you grow.')); ?></textarea>
                        <p class="description">Brief description below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_grid_items">Solution Cards</label></th>
                    <td>
                        <textarea id="apex_solutions_grid_items" name="apex_solutions_grid_items" rows="30" class="large-text"
                                  placeholder="Core Banking & Microfinance | The foundation of your digital banking infrastructure. Manage accounts, transactions, and products with enterprise-grade reliability. | /solutions/core-banking-microfinance | featured&#10;Mobile Wallet App | White-label mobile banking app with offline-first design for seamless customer experience. | /solutions/mobile-wallet-app |"><?php 
                            $items = get_option('apex_solutions_grid_items_' . $page_slug, "Core Banking & Microfinance | The foundation of your digital banking infrastructure. Manage accounts, transactions, and products with enterprise-grade reliability. | /solutions/core-banking-microfinance | featured\nMobile Wallet App | White-label mobile banking app with offline-first design for seamless customer experience. | /solutions/mobile-wallet-app |\nAgency & Branch Banking | Extend your reach through agent networks and modernize branch operations. | /solutions/agency-branch-banking |\nInternet & Mobile Banking | Responsive web banking and USSD channels for complete customer coverage. | /solutions/internet-mobile-banking |\nLoan Origination & Workflows | Automate the entire loan lifecycle from application to disbursement and collection. | /solutions/loan-origination-workflows |\nDigital Field Agent | Empower field officers with mobile tools for customer onboarding and collections. | /solutions/digital-field-agent |\nEnterprise Integration | Connect with third-party systems, payment networks, and credit bureaus seamlessly. | /solutions/enterprise-integration |\nPayment Switch & General Ledger | Process payments across all channels with real-time settlement and accounting. | /solutions/payment-switch-ledger |\nReporting & Analytics | Real-time dashboards, regulatory reports, and business intelligence tools. | /solutions/reporting-analytics |");
                            echo esc_textarea($items);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Title | Description | Link | featured (optional)</p>
                        <p class="description">Add "featured" at the end to highlight the card. SVG icons are auto-matched by title.</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Benefits Section -->
        <div style="margin-bottom: 30px;">
            <h4>✨ Benefits Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases the key benefits of choosing Apex.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_solutions_benefits_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_solutions_benefits_badge" name="apex_solutions_benefits_badge" 
                               value="<?php echo esc_attr(get_option('apex_solutions_benefits_badge_' . $page_slug, 'Why Apex')); ?>" 
                               class="regular-text" placeholder="e.g., Why Apex">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_benefits_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_solutions_benefits_heading" name="apex_solutions_benefits_heading" 
                               value="<?php echo esc_attr(get_option('apex_solutions_benefits_heading_' . $page_slug, 'Built for African Financial Services')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the benefits section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_benefits_items">Benefit Items</label></th>
                    <td>
                        <textarea id="apex_solutions_benefits_items" name="apex_solutions_benefits_items" rows="20" class="large-text"
                                  placeholder="Modular Architecture | Start with what you need and add modules as you grow. No need to pay for features you don't use.&#10;Offline-First Design | Our mobile solutions work seamlessly in low-connectivity environments common in rural areas."><?php 
                            $benefits = get_option('apex_solutions_benefits_items_' . $page_slug, "Modular Architecture | Start with what you need and add modules as you grow. No need to pay for features you don't use.\nOffline-First Design | Our mobile solutions work seamlessly in low-connectivity environments common in rural areas.\nRegulatory Compliance | Built-in compliance with Central Bank regulations across multiple African jurisdictions.\nRapid Deployment | Go live in weeks, not months. Our experienced team ensures smooth implementation.\nProven Track Record | Trusted by 100+ financial institutions across 15+ African countries.\n24/7 Local Support | Round-the-clock support from teams based in Africa who understand your context.");
                            echo esc_textarea($benefits);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Title | Description (one benefit per line)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Integration Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔌 Integration Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section showcases integration capabilities with third-party services.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_solutions_integration_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_solutions_integration_badge" name="apex_solutions_integration_badge" 
                               value="<?php echo esc_attr(get_option('apex_solutions_integration_badge_' . $page_slug, 'Integrations')); ?>" 
                               class="regular-text" placeholder="e.g., Integrations">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_integration_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_solutions_integration_heading" name="apex_solutions_integration_heading" 
                               value="<?php echo esc_attr(get_option('apex_solutions_integration_heading_' . $page_slug, 'Connect With Your Ecosystem')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the integration section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_integration_description">Description</label></th>
                    <td>
                        <textarea id="apex_solutions_integration_description" name="apex_solutions_integration_description" rows="3" class="large-text"
                                  placeholder="Integration description"><?php echo esc_textarea(get_option('apex_solutions_integration_description_' . $page_slug, 'Our platform integrates seamlessly with the services and systems you already use.')); ?></textarea>
                        <p class="description">Description text below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_integration_categories">Integration Categories</label></th>
                    <td>
                        <textarea id="apex_solutions_integration_categories" name="apex_solutions_integration_categories" rows="12" class="large-text"
                                  placeholder="Payment Networks | M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT&#10;Credit Bureaus | TransUnion, Metropol, CRB Africa, First Central"><?php 
                            $categories = get_option('apex_solutions_integration_categories_' . $page_slug, "Payment Networks | M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT\nCredit Bureaus | TransUnion, Metropol, CRB Africa, First Central\nIdentity Verification | IPRS, NIRA, National ID systems, Smile Identity\nAccounting Systems | SAP, Oracle, QuickBooks, Sage, custom ERPs");
                            echo esc_textarea($categories);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Category Name | Items (comma separated)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_solutions_integration_image">Integration Image URL</label></th>
                    <td>
                        <input type="url" id="apex_solutions_integration_image" name="apex_solutions_integration_image" 
                               value="<?php echo esc_attr(get_option('apex_solutions_integration_image_' . $page_slug, 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">The integration section image URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-core-banking-microfinance'): ?>
        <!-- Core Banking & Microfinance Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_corebank_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_corebank_hero_badge" name="apex_corebank_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_corebank_hero_badge_' . $page_slug, 'Core Banking & Microfinance')); ?>" 
                               class="regular-text" placeholder="e.g., Core Banking & Microfinance">
                        <p class="description">The small badge text above the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_corebank_hero_heading" name="apex_corebank_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_corebank_hero_heading_' . $page_slug, 'The Foundation of Your Digital Banking')); ?>" 
                               class="regular-text" placeholder="Main hero heading">
                        <p class="description">The main heading for the hero section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_corebank_hero_description" name="apex_corebank_hero_description" rows="4" class="large-text"
                                  placeholder="Hero section description"><?php echo esc_textarea(get_option('apex_corebank_hero_description_' . $page_slug, 'A modern, cloud-native core banking system designed for African financial institutions. Handle millions of transactions with enterprise-grade reliability and flexibility.')); ?></textarea>
                        <p class="description">The description text below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_corebank_hero_image" name="apex_corebank_hero_image" 
                               value="<?php echo esc_attr(get_option('apex_corebank_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">The main hero image URL (recommended size: 1200x800px)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_hero_stats">Statistics</label></th>
                    <td>
                        <textarea id="apex_corebank_hero_stats" name="apex_corebank_hero_stats" rows="6" class="large-text"
                                  placeholder="100+ | Institutions&#10;10M+ | Accounts&#10;99.99% | Uptime&#10;<100ms | Response Time"><?php 
                            $stats = get_option('apex_corebank_hero_stats_' . $page_slug, "100+ | Institutions\n10M+ | Accounts\n99.99% | Uptime\n<100ms | Response Time");
                            echo esc_textarea($stats);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Value | Label (one stat per line)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚙️ Key Features Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the key features of the core banking system.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_corebank_features_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_corebank_features_badge" name="apex_corebank_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_corebank_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_corebank_features_heading" name="apex_corebank_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_corebank_features_heading_' . $page_slug, 'Everything You Need in a Core Banking System')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the features section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_corebank_features_items" name="apex_corebank_features_items" rows="20" class="large-text"
                                  placeholder="Account Management | Flexible account structures supporting savings, current, fixed deposits, and custom account types with configurable interest calculations."><?php 
                            $features = get_option('apex_corebank_features_items_' . $page_slug, "Account Management | Flexible account structures supporting savings, current, fixed deposits, and custom account types with configurable interest calculations.\nTransaction Processing | Real-time transaction processing with support for deposits, withdrawals, transfers, and complex multi-leg transactions.\nLoan Management | Complete loan lifecycle management from origination to settlement with support for multiple loan products and repayment schedules.\nEnd-of-Day Processing | Automated EOD processing for interest accrual, fee charges, and account maintenance with detailed audit trails.\nCustomer Management | 360-degree customer view with KYC management, document storage, and relationship tracking.\nSecurity & Compliance | Role-based access control, maker-checker workflows, and comprehensive audit logging for regulatory compliance.");
                            echo esc_textarea($features);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Title | Description (one feature per line). SVG icons auto-matched by title.</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Technical Specifications Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔧 Technical Specifications Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays technical specifications with an accompanying image.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_corebank_specs_badge">Section Badge</label></th>
                    <td>
                        <input type="text" id="apex_corebank_specs_badge" name="apex_corebank_specs_badge" 
                               value="<?php echo esc_attr(get_option('apex_corebank_specs_badge_' . $page_slug, 'Technical Specifications')); ?>" 
                               class="regular-text" placeholder="e.g., Technical Specifications">
                        <p class="description">The small badge text above the section heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_specs_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_corebank_specs_heading" name="apex_corebank_specs_heading" 
                               value="<?php echo esc_attr(get_option('apex_corebank_specs_heading_' . $page_slug, 'Built for Scale and Performance')); ?>" 
                               class="regular-text" placeholder="Section heading">
                        <p class="description">The main heading for the specifications section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_specs_items">Specification Items</label></th>
                    <td>
                        <textarea id="apex_corebank_specs_items" name="apex_corebank_specs_items" rows="12" class="large-text"
                                  placeholder="Architecture | Cloud-native microservices architecture with horizontal scaling capabilities&#10;Database | PostgreSQL with read replicas for high availability and performance"><?php 
                            $specs = get_option('apex_corebank_specs_items_' . $page_slug, "Architecture | Cloud-native microservices architecture with horizontal scaling capabilities\nDatabase | PostgreSQL with read replicas for high availability and performance\nAPI | RESTful APIs with OpenAPI documentation for easy integration\nSecurity | TLS 1.3, AES-256 encryption, OAuth 2.0, and PCI-DSS compliance\nDeployment | On-premise, private cloud, or fully managed SaaS options available");
                            echo esc_textarea($specs);
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Title | Description (one spec per line)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_corebank_specs_image">Specifications Image URL</label></th>
                    <td>
                        <input type="url" id="apex_corebank_specs_image" name="apex_corebank_specs_image" 
                               value="<?php echo esc_attr(get_option('apex_corebank_specs_image_' . $page_slug, 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">The technical specifications section image URL</p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-mobile-wallet-app'): ?>
        <!-- Mobile Wallet App Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_wallet_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_wallet_hero_badge" name="apex_wallet_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_wallet_hero_badge_' . $page_slug, 'Mobile Wallet App')); ?>" 
                               class="regular-text" placeholder="e.g., Mobile Wallet App">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_wallet_hero_heading" name="apex_wallet_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_wallet_hero_heading_' . $page_slug, 'Banking in Every Pocket')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_wallet_hero_description" name="apex_wallet_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_wallet_hero_description_' . $page_slug, 'A white-label mobile banking app designed for African markets. Offline-first architecture ensures your customers can bank anywhere, anytime.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_wallet_hero_image" name="apex_wallet_hero_image" 
                               value="<?php echo esc_url(get_option('apex_wallet_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_wallet_hero_stats" name="apex_wallet_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_wallet_hero_stats_' . $page_slug, "5M+ | App Users\n4.7★ | App Rating\n60% | Offline Usage\n<3s | Load Time")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>5M+ | App Users</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_wallet_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_wallet_features_badge" name="apex_wallet_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_wallet_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_wallet_features_heading" name="apex_wallet_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_wallet_features_heading_' . $page_slug, 'Complete Mobile Banking Experience')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_wallet_features_items" name="apex_wallet_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_wallet_features_items_' . $page_slug, "Offline-First Design | Queue transactions when offline and sync automatically when connectivity returns. Perfect for rural areas.\nBiometric Security | Fingerprint and face recognition for secure, convenient authentication.\nMoney Transfers | Send money to bank accounts, mobile money, and other app users instantly.\nBill Payments | Pay utilities, airtime, and other bills directly from the app.\nLoan Applications | Apply for loans, track status, and manage repayments from your phone.\nPush Notifications | Real-time alerts for transactions, payments due, and promotional offers.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- White-Label Solution Section -->
        <div style="margin-bottom: 30px;">
            <h4>📱 White-Label Solution Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the white-label capabilities and app store features displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_wallet_whitelabel_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_wallet_whitelabel_badge" name="apex_wallet_whitelabel_badge" 
                               value="<?php echo esc_attr(get_option('apex_wallet_whitelabel_badge_' . $page_slug, 'White-Label Solution')); ?>" 
                               class="regular-text" placeholder="e.g., White-Label Solution">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_whitelabel_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_wallet_whitelabel_heading" name="apex_wallet_whitelabel_heading" 
                               value="<?php echo esc_attr(get_option('apex_wallet_whitelabel_heading_' . $page_slug, 'Your Brand, Our Technology')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_whitelabel_items">White-Label Items</label></th>
                    <td>
                        <textarea id="apex_wallet_whitelabel_items" name="apex_wallet_whitelabel_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_wallet_whitelabel_items_' . $page_slug, "Custom Branding | Your logo, colors, and brand identity throughout the app\nPlatform Support | Native iOS and Android apps with shared codebase\nApp Store Publishing | We handle submission to Apple App Store and Google Play\nOTA Updates | Push updates without requiring app store approval")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_wallet_whitelabel_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_wallet_whitelabel_image" name="apex_wallet_whitelabel_image" 
                               value="<?php echo esc_url(get_option('apex_wallet_whitelabel_image_' . $page_slug, 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-agency-branch-banking'): ?>
        <!-- Agency & Branch Banking Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_agency_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_agency_hero_badge" name="apex_agency_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_agency_hero_badge_' . $page_slug, 'Agency & Branch Banking')); ?>" 
                               class="regular-text" placeholder="e.g., Agency & Branch Banking">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_agency_hero_heading" name="apex_agency_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_agency_hero_heading_' . $page_slug, 'Extend Your Reach Without Building Branches')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_agency_hero_description" name="apex_agency_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_agency_hero_description_' . $page_slug, 'Transform local shops into banking points and modernize your branch operations. Serve customers where they are with our comprehensive agent and branch banking platform.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_agency_hero_image" name="apex_agency_hero_image" 
                               value="<?php echo esc_url(get_option('apex_agency_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_agency_hero_stats" name="apex_agency_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_agency_hero_stats_' . $page_slug, "50K+ | Active Agents\n85% | Cost Reduction\n10x | Reach Expansion\n24/7 | Service Availability")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50K+ | Active Agents</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_agency_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_agency_features_badge" name="apex_agency_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_agency_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_agency_features_heading" name="apex_agency_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_agency_features_heading_' . $page_slug, 'Complete Agent & Branch Solution')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_agency_features_items" name="apex_agency_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_agency_features_items_' . $page_slug, "Agent Onboarding | Digital agent recruitment with KYC verification, training modules, and automated activation.\nFloat Management | Real-time float monitoring, automated rebalancing alerts, and super-agent hierarchy support.\nPOS Integration | Support for Android POS devices, mPOS, and traditional terminals with offline capability.\nCommission Management | Flexible commission structures with real-time calculation and automated payouts.\nPerformance Analytics | Agent performance dashboards, territory analytics, and productivity tracking.\nBranch Teller System | Modern teller interface with queue management and customer service tools.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Agent Network Models Section -->
        <div style="margin-bottom: 30px;">
            <h4>🌐 Agent Network Models Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the deployment options and agent network models displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_agency_models_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_agency_models_badge" name="apex_agency_models_badge" 
                               value="<?php echo esc_attr(get_option('apex_agency_models_badge_' . $page_slug, 'Agent Network Models')); ?>" 
                               class="regular-text" placeholder="e.g., Agent Network Models">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_models_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_agency_models_heading" name="apex_agency_models_heading" 
                               value="<?php echo esc_attr(get_option('apex_agency_models_heading_' . $page_slug, 'Flexible Deployment Options')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_models_items">Network Model Items</label></th>
                    <td>
                        <textarea id="apex_agency_models_items" name="apex_agency_models_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_agency_models_items_' . $page_slug, "Retail Agent Model | Partner with existing shops, pharmacies, and retail outlets to offer banking services\nSuper-Agent Hierarchy | Multi-tier agent structure with master agents managing sub-agent networks\nBank-Led Model | Direct agent recruitment and management by your institution\nHybrid Approach | Combine branch, agent, and digital channels for maximum coverage")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_agency_models_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_agency_models_image" name="apex_agency_models_image" 
                               value="<?php echo esc_url(get_option('apex_agency_models_image_' . $page_slug, 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-internet-mobile-banking'): ?>
        <!-- Internet & Mobile Banking Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_internet_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_internet_hero_badge" name="apex_internet_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_internet_hero_badge_' . $page_slug, 'Internet & Mobile Banking')); ?>" 
                               class="regular-text" placeholder="e.g., Internet & Mobile Banking">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_internet_hero_heading" name="apex_internet_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_internet_hero_heading_' . $page_slug, 'Digital Channels for Every Customer')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_internet_hero_description" name="apex_internet_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_internet_hero_description_' . $page_slug, 'Responsive web banking and USSD channels ensure every customer can access your services, regardless of their device or connectivity.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_internet_hero_image" name="apex_internet_hero_image" 
                               value="<?php echo esc_url(get_option('apex_internet_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_internet_hero_stats" name="apex_internet_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_internet_hero_stats_' . $page_slug, "3M+ | Active Users\n70% | Self-Service\n40% | Cost Savings\n99.9% | Uptime")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>3M+ | Active Users</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_internet_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_internet_features_badge" name="apex_internet_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_internet_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_internet_features_heading" name="apex_internet_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_internet_features_heading_' . $page_slug, 'Complete Digital Channel Suite')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_internet_features_items" name="apex_internet_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_internet_features_items_' . $page_slug, "Internet Banking Portal | Responsive web application for account management, transfers, and self-service operations.\nUSSD Banking | Feature phone banking via USSD codes for customers without smartphones or data.\nChatbot Integration | AI-powered chatbot for customer support and transaction assistance.\nTwo-Factor Authentication | SMS OTP, email verification, and authenticator app support for secure access.\nStatement Downloads | Generate and download account statements in PDF and Excel formats.\nBill Payments | Integrated bill payment for utilities, airtime, and other services.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Channel Accessibility Section -->
        <div style="margin-bottom: 30px;">
            <h4>📱 Channel Accessibility Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the customer segment accessibility information displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_internet_accessibility_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_internet_accessibility_badge" name="apex_internet_accessibility_badge" 
                               value="<?php echo esc_attr(get_option('apex_internet_accessibility_badge_' . $page_slug, 'Channel Accessibility')); ?>" 
                               class="regular-text" placeholder="e.g., Channel Accessibility">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_accessibility_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_internet_accessibility_heading" name="apex_internet_accessibility_heading" 
                               value="<?php echo esc_attr(get_option('apex_internet_accessibility_heading_' . $page_slug, 'Banking for Every Customer Segment')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_accessibility_items">Accessibility Items</label></th>
                    <td>
                        <textarea id="apex_internet_accessibility_items" name="apex_internet_accessibility_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_internet_accessibility_items_' . $page_slug, "Smartphone Users | Full-featured responsive web app optimized for mobile browsers\nFeature Phone Users | USSD banking with simple menu navigation for basic phones\nDesktop Users | Comprehensive internet banking portal for corporate and power users\nLow-Bandwidth Areas | Lightweight interfaces optimized for 2G/3G connections")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_internet_accessibility_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_internet_accessibility_image" name="apex_internet_accessibility_image" 
                               value="<?php echo esc_url(get_option('apex_internet_accessibility_image_' . $page_slug, 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-loan-origination-workflows'): ?>
        <!-- Loan Origination & Workflows Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_loan_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_loan_hero_badge" name="apex_loan_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_loan_hero_badge_' . $page_slug, 'Loan Origination & Workflows')); ?>" 
                               class="regular-text" placeholder="e.g., Loan Origination & Workflows">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_loan_hero_heading" name="apex_loan_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_loan_hero_heading_' . $page_slug, 'From Application to Disbursement in Minutes')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_loan_hero_description" name="apex_loan_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_loan_hero_description_' . $page_slug, 'Automate your entire loan lifecycle with digital applications, automated credit scoring, and streamlined approval workflows.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_loan_hero_image" name="apex_loan_hero_image" 
                               value="<?php echo esc_url(get_option('apex_loan_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_loan_hero_stats" name="apex_loan_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_loan_hero_stats_' . $page_slug, "90% | Faster Processing\n\$2B+ | Loans Processed\n50% | Cost Reduction\n95% | Approval Rate")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>90% | Faster Processing</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_loan_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_loan_features_badge" name="apex_loan_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_loan_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_loan_features_heading" name="apex_loan_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_loan_features_heading_' . $page_slug, 'End-to-End Loan Management')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_loan_features_items" name="apex_loan_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_loan_features_items_' . $page_slug, "Digital Applications | Mobile and web loan applications with document upload and e-signature support.\nAutomated Credit Scoring | AI-powered credit scoring with bureau integration and alternative data sources.\nApproval Workflows | Configurable multi-level approval workflows with delegation and escalation rules.\nInstant Disbursement | Automated disbursement to bank accounts or mobile money upon approval.\nRepayment Management | Flexible repayment schedules with automated reminders and collection workflows.\nDocument Management | Digital document collection, verification, and secure storage.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Loan Product Types Section -->
        <div style="margin-bottom: 30px;">
            <h4>📋 Loan Product Types Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the loan product types and lending models displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_loan_products_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_loan_products_badge" name="apex_loan_products_badge" 
                               value="<?php echo esc_attr(get_option('apex_loan_products_badge_' . $page_slug, 'Loan Product Types')); ?>" 
                               class="regular-text" placeholder="e.g., Loan Product Types">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_products_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_loan_products_heading" name="apex_loan_products_heading" 
                               value="<?php echo esc_attr(get_option('apex_loan_products_heading_' . $page_slug, 'Support for All Lending Models')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_products_items">Loan Product Items</label></th>
                    <td>
                        <textarea id="apex_loan_products_items" name="apex_loan_products_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_loan_products_items_' . $page_slug, "Individual Loans | Personal, salary, emergency, and asset financing with flexible terms\nGroup Lending | Chama loans, group guarantees, and solidarity lending models\nSME & Business Loans | Working capital, trade finance, and equipment financing\nAgricultural Loans | Seasonal lending with harvest-based repayment schedules\nDigital Nano-Loans | Instant mobile loans with automated scoring and disbursement")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_loan_products_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_loan_products_image" name="apex_loan_products_image" 
                               value="<?php echo esc_url(get_option('apex_loan_products_image_' . $page_slug, 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-digital-field-agent'): ?>
        <!-- Digital Field Agent Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_field_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_field_hero_badge" name="apex_field_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_field_hero_badge_' . $page_slug, 'Digital Field Agent')); ?>" 
                               class="regular-text" placeholder="e.g., Digital Field Agent">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_field_hero_heading" name="apex_field_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_field_hero_heading_' . $page_slug, 'Empower Your Field Teams')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_field_hero_description" name="apex_field_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_field_hero_description_' . $page_slug, 'Mobile tools for loan officers, field agents, and collection teams. Work offline, sync when connected, and serve customers anywhere.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_field_hero_image" name="apex_field_hero_image" 
                               value="<?php echo esc_url(get_option('apex_field_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_field_hero_stats" name="apex_field_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_field_hero_stats_' . $page_slug, "10K+ | Field Agents\n3x | Productivity\n80% | Offline Usage\n95% | Collection Rate")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>10K+ | Field Agents</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_field_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_field_features_badge" name="apex_field_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_field_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_field_features_heading" name="apex_field_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_field_features_heading_' . $page_slug, 'Complete Field Operations Platform')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_field_features_items" name="apex_field_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_field_features_items_' . $page_slug, "Customer Onboarding | Digital KYC with photo capture, ID scanning, and biometric enrollment in the field.\nGPS Tracking | Location tracking for visit verification and route optimization.\nCollection Management | Daily collection lists, receipt generation, and real-time payment posting.\nOffline Capability | Full functionality without internet. Sync automatically when connected.\nLoan Applications | Complete loan applications in the field with document capture.\nPerformance Dashboards | Real-time visibility into field team performance and productivity.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Field Operations Use Cases Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎯 Field Operations Use Cases Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the field operations use cases and roles displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_field_usecases_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_field_usecases_badge" name="apex_field_usecases_badge" 
                               value="<?php echo esc_attr(get_option('apex_field_usecases_badge_' . $page_slug, 'Field Operations Use Cases')); ?>" 
                               class="regular-text" placeholder="e.g., Field Operations Use Cases">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_usecases_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_field_usecases_heading" name="apex_field_usecases_heading" 
                               value="<?php echo esc_attr(get_option('apex_field_usecases_heading_' . $page_slug, 'Tools for Every Field Role')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_usecases_items">Use Case Items</label></th>
                    <td>
                        <textarea id="apex_field_usecases_items" name="apex_field_usecases_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_field_usecases_items_' . $page_slug, "Loan Officers | Client visits, loan applications, credit assessments, and document collection\nCollection Agents | Daily collection routes, payment receipts, and arrears management\nCustomer Acquisition | New member registration, KYC verification, and account opening\nGroup Coordinators | Chama meetings, group savings collection, and member management\nSupervisors | Team monitoring, performance tracking, and field visit verification")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_field_usecases_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_field_usecases_image" name="apex_field_usecases_image" 
                               value="<?php echo esc_url(get_option('apex_field_usecases_image_' . $page_slug, 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-enterprise-integration'): ?>
        <!-- Enterprise Integration Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_integration_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_integration_hero_badge" name="apex_integration_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_integration_hero_badge_' . $page_slug, 'Enterprise Integration')); ?>" 
                               class="regular-text" placeholder="e.g., Enterprise Integration">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_integration_hero_heading" name="apex_integration_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_integration_hero_heading_' . $page_slug, 'Connect Your Entire Ecosystem')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_integration_hero_description" name="apex_integration_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_integration_hero_description_' . $page_slug, 'Seamlessly integrate with payment networks, credit bureaus, government systems, and third-party services through our comprehensive API platform.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_integration_hero_image" name="apex_integration_hero_image" 
                               value="<?php echo esc_url(get_option('apex_integration_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_integration_hero_stats" name="apex_integration_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_integration_hero_stats_' . $page_slug, "50+ | Pre-Built Integrations\n99.9% | API Uptime\n<200ms | Response Time\n24/7 | Monitoring")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | Pre-Built Integrations</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Integration Categories Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔗 Integration Categories Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the integration categories displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_integration_categories_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_integration_categories_badge" name="apex_integration_categories_badge" 
                               value="<?php echo esc_attr(get_option('apex_integration_categories_badge_' . $page_slug, 'Integration Categories')); ?>" 
                               class="regular-text" placeholder="e.g., Integration Categories">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_categories_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_integration_categories_heading" name="apex_integration_categories_heading" 
                               value="<?php echo esc_attr(get_option('apex_integration_categories_heading_' . $page_slug, 'Connect With Everything You Need')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_categories_items">Integration Categories</label></th>
                    <td>
                        <textarea id="apex_integration_categories_items" name="apex_integration_categories_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_integration_categories_items_' . $page_slug, "Payment Networks | M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT, and more.\nCredit Bureaus | TransUnion, Metropol, CRB Africa, First Central for credit checks and reporting.\nIdentity Verification | National ID systems, IPRS, NIRA, Smile Identity for KYC verification.\nAccounting Systems | SAP, Oracle, QuickBooks, Sage, and custom ERP integrations.\nCommunication | SMS gateways, email services, WhatsApp Business API for notifications.\nCustom APIs | RESTful APIs with OpenAPI documentation for custom integrations.")); ?></textarea>
                        <p class="description">Enter one integration per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Integration Architecture Section -->
        <div style="margin-bottom: 30px;">
            <h4>🏗️ Integration Architecture Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the integration architecture features displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_integration_arch_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_integration_arch_badge" name="apex_integration_arch_badge" 
                               value="<?php echo esc_attr(get_option('apex_integration_arch_badge_' . $page_slug, 'Integration Architecture')); ?>" 
                               class="regular-text" placeholder="e.g., Integration Architecture">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_arch_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_integration_arch_heading" name="apex_integration_arch_heading" 
                               value="<?php echo esc_attr(get_option('apex_integration_arch_heading_' . $page_slug, 'Enterprise-Grade Connectivity')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_arch_items">Architecture Features</label></th>
                    <td>
                        <textarea id="apex_integration_arch_items" name="apex_integration_arch_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_integration_arch_items_' . $page_slug, "API Gateway | Centralized API management with rate limiting, authentication, and monitoring\nMessage Queue | Asynchronous processing for high-volume transactions and event-driven workflows\nData Transformation | Built-in ETL capabilities for format conversion between systems\nWebhook Support | Real-time event notifications to external systems\nSandbox Environment | Test integrations safely before deploying to production")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_integration_arch_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_integration_arch_image" name="apex_integration_arch_image" 
                               value="<?php echo esc_url(get_option('apex_integration_arch_image_' . $page_slug, 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-payment-switch-ledger'): ?>
        <!-- Payment Switch & General Ledger Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_payment_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_payment_hero_badge" name="apex_payment_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_payment_hero_badge_' . $page_slug, 'Payment Switch & General Ledger')); ?>" 
                               class="regular-text" placeholder="e.g., Payment Switch & General Ledger">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_payment_hero_heading" name="apex_payment_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_payment_hero_heading_' . $page_slug, 'Process Payments, Balance Books')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_payment_hero_description" name="apex_payment_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_payment_hero_description_' . $page_slug, 'A unified payment processing platform with integrated general ledger for real-time settlement and accurate financial reporting.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_payment_hero_image" name="apex_payment_hero_image" 
                               value="<?php echo esc_url(get_option('apex_payment_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_payment_hero_stats" name="apex_payment_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_payment_hero_stats_' . $page_slug, "\$5B+ | Annual Volume\n10M+ | Transactions/Month\n<1s | Settlement Time\n100% | Reconciliation")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>$5B+ | Annual Volume</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_payment_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_payment_features_badge" name="apex_payment_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_payment_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_payment_features_heading" name="apex_payment_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_payment_features_heading_' . $page_slug, 'Complete Payment & Accounting Solution')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_payment_features_items" name="apex_payment_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_payment_features_items_' . $page_slug, "Multi-Channel Payments | Process payments from mobile, web, POS, ATM, and agent channels through a single switch.\nReal-Time Settlement | Instant settlement with automatic posting to the general ledger.\nChart of Accounts | Flexible chart of accounts supporting multiple currencies and reporting hierarchies.\nAuto-Reconciliation | Automated reconciliation with external systems and exception handling workflows.\nFinancial Reports | Balance sheets, income statements, trial balance, and custom financial reports.\nFraud Detection | Real-time transaction monitoring with rule-based and ML-powered fraud detection.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Supported Payment Rails Section -->
        <div style="margin-bottom: 30px;">
            <h4>💳 Supported Payment Rails Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the payment rails information displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_payment_rails_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_payment_rails_badge" name="apex_payment_rails_badge" 
                               value="<?php echo esc_attr(get_option('apex_payment_rails_badge_' . $page_slug, 'Supported Payment Rails')); ?>" 
                               class="regular-text" placeholder="e.g., Supported Payment Rails">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_rails_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_payment_rails_heading" name="apex_payment_rails_heading" 
                               value="<?php echo esc_attr(get_option('apex_payment_rails_heading_' . $page_slug, 'Connect to Every Payment Network')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_rails_items">Payment Rails Items</label></th>
                    <td>
                        <textarea id="apex_payment_rails_items" name="apex_payment_rails_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_payment_rails_items_' . $page_slug, "Mobile Money | M-Pesa, Airtel Money, MTN MoMo, Orange Money, and regional wallets\nCard Networks | Visa, Mastercard, UnionPay, and local card schemes\nBank Transfers | RTGS, EFT, SWIFT, and domestic clearing systems\nQR Payments | Static and dynamic QR codes for merchant payments\nBill Aggregators | Utility payments, government services, and merchant collections")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_payment_rails_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_payment_rails_image" name="apex_payment_rails_image" 
                               value="<?php echo esc_url(get_option('apex_payment_rails_image_' . $page_slug, 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'solutions-reporting-analytics'): ?>
        <!-- Reporting & Analytics Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reporting_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reporting_hero_badge" name="apex_reporting_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_reporting_hero_badge_' . $page_slug, 'Reporting & Analytics')); ?>" 
                               class="regular-text" placeholder="e.g., Reporting & Analytics">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_reporting_hero_heading" name="apex_reporting_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_reporting_hero_heading_' . $page_slug, 'Data-Driven Decision Making')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_reporting_hero_description" name="apex_reporting_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_reporting_hero_description_' . $page_slug, 'Real-time dashboards, regulatory reports, and business intelligence tools to help you understand your business and make informed decisions.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_reporting_hero_image" name="apex_reporting_hero_image" 
                               value="<?php echo esc_url(get_option('apex_reporting_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_reporting_hero_stats" name="apex_reporting_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_reporting_hero_stats_' . $page_slug, "100+ | Report Templates\nReal-Time | Data Updates\n50+ | KPI Metrics\n1-Click | Regulatory Reports")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>100+ | Report Templates</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Features Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the key features grid displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reporting_features_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reporting_features_badge" name="apex_reporting_features_badge" 
                               value="<?php echo esc_attr(get_option('apex_reporting_features_badge_' . $page_slug, 'Key Features')); ?>" 
                               class="regular-text" placeholder="e.g., Key Features">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_features_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_reporting_features_heading" name="apex_reporting_features_heading" 
                               value="<?php echo esc_attr(get_option('apex_reporting_features_heading_' . $page_slug, 'Complete Business Intelligence Suite')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_features_items">Feature Items</label></th>
                    <td>
                        <textarea id="apex_reporting_features_items" name="apex_reporting_features_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_reporting_features_items_' . $page_slug, "Executive Dashboards | Real-time KPI dashboards for management with drill-down capabilities.\nRegulatory Reports | Pre-built Central Bank reports, SASRA returns, and compliance reports.\nPortfolio Analytics | Loan portfolio analysis, PAR tracking, and risk concentration reports.\nCustomer Insights | Customer segmentation, behavior analysis, and lifetime value tracking.\nCustom Report Builder | Drag-and-drop report builder for creating custom reports without IT help.\nScheduled Reports | Automated report generation and email delivery on your schedule.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Regulatory Compliance Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Regulatory Compliance Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the regulatory compliance information displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reporting_compliance_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reporting_compliance_badge" name="apex_reporting_compliance_badge" 
                               value="<?php echo esc_attr(get_option('apex_reporting_compliance_badge_' . $page_slug, 'Regulatory Compliance')); ?>" 
                               class="regular-text" placeholder="e.g., Regulatory Compliance">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_compliance_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_reporting_compliance_heading" name="apex_reporting_compliance_heading" 
                               value="<?php echo esc_attr(get_option('apex_reporting_compliance_heading_' . $page_slug, 'Meet Every Reporting Requirement')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_compliance_items">Compliance Items</label></th>
                    <td>
                        <textarea id="apex_reporting_compliance_items" name="apex_reporting_compliance_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_reporting_compliance_items_' . $page_slug, "Central Bank Returns | Automated CBK, BOU, BOT, and other central bank regulatory submissions\nSASRA Compliance | SACCO-specific reports including prudential returns and financial statements\nAML/CFT Reports | Suspicious transaction reports, CTRs, and compliance monitoring\nIFRS 9 Reporting | Expected credit loss calculations and impairment reporting\nTax Compliance | Withholding tax reports, excise duty, and tax authority submissions")); ?></textarea>
                        <p class="description">Enter one item per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reporting_compliance_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_reporting_compliance_image" name="apex_reporting_compliance_image" 
                               value="<?php echo esc_url(get_option('apex_reporting_compliance_image_' . $page_slug, 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'industry-overview'): ?>
        <!-- Industry Overview Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_industry_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_industry_hero_badge" name="apex_industry_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_industry_hero_badge_' . $page_slug, 'Industries We Serve')); ?>" 
                               class="regular-text" placeholder="e.g., Industries We Serve">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_industry_hero_heading" name="apex_industry_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_industry_hero_heading_' . $page_slug, 'Tailored Solutions for Every Financial Institution')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_industry_hero_description" name="apex_industry_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_industry_hero_description_' . $page_slug, 'From microfinance institutions to commercial banks, we understand the unique challenges each sector faces. Our solutions are designed to meet your specific needs.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_industry_hero_image" name="apex_industry_hero_image" 
                               value="<?php echo esc_url(get_option('apex_industry_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_industry_hero_stats" name="apex_industry_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_industry_hero_stats_' . $page_slug, "100+ | Institutions Served\n5 | Industry Verticals\n15+ | Countries\n10M+ | End Users")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>100+ | Institutions Served</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Sectors Section -->
        <div style="margin-bottom: 30px;">
            <h4>🏢 Industry Sectors Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the industry sectors cards displayed on the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_industry_sectors_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_industry_sectors_badge" name="apex_industry_sectors_badge" 
                               value="<?php echo esc_attr(get_option('apex_industry_sectors_badge_' . $page_slug, 'Our Expertise')); ?>" 
                               class="regular-text" placeholder="e.g., Our Expertise">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_sectors_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_industry_sectors_heading" name="apex_industry_sectors_heading" 
                               value="<?php echo esc_attr(get_option('apex_industry_sectors_heading_' . $page_slug, 'Industries We Specialize In')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_sectors_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_industry_sectors_description" name="apex_industry_sectors_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_industry_sectors_description_' . $page_slug, "We've built deep expertise across the financial services landscape, enabling us to deliver solutions that truly understand your business.")); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Sector Cards -->
        <div style="margin-bottom: 30px;">
            <h4>📋 Industry Sector Cards</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 4 industry sector cards (MFI, SACCOs, Banks, Government).</strong></p>
            </div>
            <table class="form-table">
                <!-- MFI Card -->
                <tr>
                    <th scope="row"><label for="apex_industry_card1_title">Card 1 - Title</label></th>
                    <td>
                        <input type="text" id="apex_industry_card1_title" name="apex_industry_card1_title" 
                               value="<?php echo esc_attr(get_option('apex_industry_card1_title_' . $page_slug, 'Microfinance Institutions')); ?>" 
                               class="large-text" placeholder="Card title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card1_desc">Card 1 - Description</label></th>
                    <td>
                        <textarea id="apex_industry_card1_desc" name="apex_industry_card1_desc" 
                                  class="large-text" rows="2" 
                                  placeholder="Card description"><?php echo esc_textarea(get_option('apex_industry_card1_desc_' . $page_slug, 'Empower underserved communities with digital-first microfinance solutions that reduce costs and expand reach.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card1_stats">Card 1 - Stats</label></th>
                    <td>
                        <input type="text" id="apex_industry_card1_stats" name="apex_industry_card1_stats" 
                               value="<?php echo esc_attr(get_option('apex_industry_card1_stats_' . $page_slug, '50+ | MFI Clients,5M+ | Borrowers Served')); ?>" 
                               class="large-text" placeholder="Format: Value | Label,Value | Label">
                        <p class="description">Format: <code>Value | Label,Value | Label</code> (comma-separated pairs)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card1_link">Card 1 - Link URL</label></th>
                    <td>
                        <input type="text" id="apex_industry_card1_link" name="apex_industry_card1_link" 
                               value="<?php echo esc_attr(get_option('apex_industry_card1_link_' . $page_slug, '/industry/mfis')); ?>" 
                               class="large-text" placeholder="/industry/mfis">
                    </td>
                </tr>
                
                <!-- SACCO Card -->
                <tr>
                    <th scope="row"><label for="apex_industry_card2_title">Card 2 - Title</label></th>
                    <td>
                        <input type="text" id="apex_industry_card2_title" name="apex_industry_card2_title" 
                               value="<?php echo esc_attr(get_option('apex_industry_card2_title_' . $page_slug, 'SACCOs & Credit Unions')); ?>" 
                               class="large-text" placeholder="Card title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card2_desc">Card 2 - Description</label></th>
                    <td>
                        <textarea id="apex_industry_card2_desc" name="apex_industry_card2_desc" 
                                  class="large-text" rows="2" 
                                  placeholder="Card description"><?php echo esc_textarea(get_option('apex_industry_card2_desc_' . $page_slug, 'Modern member management and savings solutions designed for cooperative financial institutions.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card2_stats">Card 2 - Stats</label></th>
                    <td>
                        <input type="text" id="apex_industry_card2_stats" name="apex_industry_card2_stats" 
                               value="<?php echo esc_attr(get_option('apex_industry_card2_stats_' . $page_slug, '40+ | SACCOs,2M+ | Members')); ?>" 
                               class="large-text" placeholder="Format: Value | Label,Value | Label">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card2_link">Card 2 - Link URL</label></th>
                    <td>
                        <input type="text" id="apex_industry_card2_link" name="apex_industry_card2_link" 
                               value="<?php echo esc_attr(get_option('apex_industry_card2_link_' . $page_slug, '/industry/credit-unions')); ?>" 
                               class="large-text" placeholder="/industry/credit-unions">
                    </td>
                </tr>
                
                <!-- Banks Card -->
                <tr>
                    <th scope="row"><label for="apex_industry_card3_title">Card 3 - Title</label></th>
                    <td>
                        <input type="text" id="apex_industry_card3_title" name="apex_industry_card3_title" 
                               value="<?php echo esc_attr(get_option('apex_industry_card3_title_' . $page_slug, 'Commercial Banks')); ?>" 
                               class="large-text" placeholder="Card title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card3_desc">Card 3 - Description</label></th>
                    <td>
                        <textarea id="apex_industry_card3_desc" name="apex_industry_card3_desc" 
                                  class="large-text" rows="2" 
                                  placeholder="Card description"><?php echo esc_textarea(get_option('apex_industry_card3_desc_' . $page_slug, 'Enterprise-grade core banking and digital channel solutions for banks of all sizes.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card3_stats">Card 3 - Stats</label></th>
                    <td>
                        <input type="text" id="apex_industry_card3_stats" name="apex_industry_card3_stats" 
                               value="<?php echo esc_attr(get_option('apex_industry_card3_stats_' . $page_slug, '15+ | Banks,3M+ | Customers')); ?>" 
                               class="large-text" placeholder="Format: Value | Label,Value | Label">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card3_link">Card 3 - Link URL</label></th>
                    <td>
                        <input type="text" id="apex_industry_card3_link" name="apex_industry_card3_link" 
                               value="<?php echo esc_attr(get_option('apex_industry_card3_link_' . $page_slug, '/industry/banks-microfinance')); ?>" 
                               class="large-text" placeholder="/industry/banks-microfinance">
                    </td>
                </tr>
                
                <!-- Government Card -->
                <tr>
                    <th scope="row"><label for="apex_industry_card4_title">Card 4 - Title</label></th>
                    <td>
                        <input type="text" id="apex_industry_card4_title" name="apex_industry_card4_title" 
                               value="<?php echo esc_attr(get_option('apex_industry_card4_title_' . $page_slug, 'Digital Government & NGOs')); ?>" 
                               class="large-text" placeholder="Card title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card4_desc">Card 4 - Description</label></th>
                    <td>
                        <textarea id="apex_industry_card4_desc" name="apex_industry_card4_desc" 
                                  class="large-text" rows="2" 
                                  placeholder="Card description"><?php echo esc_textarea(get_option('apex_industry_card4_desc_' . $page_slug, 'Secure disbursement and collection platforms for government programs and development organizations.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card4_stats">Card 4 - Stats</label></th>
                    <td>
                        <input type="text" id="apex_industry_card4_stats" name="apex_industry_card4_stats" 
                               value="<?php echo esc_attr(get_option('apex_industry_card4_stats_' . $page_slug, '10+ | Programs,$500M+ | Disbursed')); ?>" 
                               class="large-text" placeholder="Format: Value | Label,Value | Label">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_card4_link">Card 4 - Link URL</label></th>
                    <td>
                        <input type="text" id="apex_industry_card4_link" name="apex_industry_card4_link" 
                               value="<?php echo esc_attr(get_option('apex_industry_card4_link_' . $page_slug, '/industry/digital-government')); ?>" 
                               class="large-text" placeholder="/industry/digital-government">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Why Choose Us Section -->
        <div style="margin-bottom: 30px;">
            <h4>✨ Why Choose Us Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the "Why Choose Us" content with features and image.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_industry_why_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_industry_why_badge" name="apex_industry_why_badge" 
                               value="<?php echo esc_attr(get_option('apex_industry_why_badge_' . $page_slug, 'Why Choose Us')); ?>" 
                               class="regular-text" placeholder="e.g., Why Choose Us">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_why_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_industry_why_heading" name="apex_industry_why_heading" 
                               value="<?php echo esc_attr(get_option('apex_industry_why_heading_' . $page_slug, 'Built for African Financial Services')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_why_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_industry_why_description" name="apex_industry_why_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_industry_why_description_' . $page_slug, "We understand the unique challenges of operating in African markets—from infrastructure limitations to regulatory complexity. Our solutions are designed from the ground up to address these realities.")); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_why_image">Section Image URL</label></th>
                    <td>
                        <input type="url" id="apex_industry_why_image" name="apex_industry_why_image" 
                               value="<?php echo esc_url(get_option('apex_industry_why_image_' . $page_slug, 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_why_features">Feature Items</label></th>
                    <td>
                        <textarea id="apex_industry_why_features" name="apex_industry_why_features" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (one per line)"><?php echo esc_textarea(get_option('apex_industry_why_features_' . $page_slug, "Modular Architecture | Start with what you need and add capabilities as you grow. No need to pay for features you don't use.\nRegulatory Compliance | Built-in compliance with Central Bank regulations across multiple African jurisdictions.\nOffline-First Design | Our mobile solutions work seamlessly in low-connectivity environments common in rural areas.\n24/7 Local Support | Round-the-clock support from teams based in Africa who understand your context.")); ?></textarea>
                        <p class="description">Enter one feature per line. Format: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Stats Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Stats Section</h4>
            <div style="background: #e0f7fa; padding: 15px; margin-bottom: 20px; border: 1px solid #00bcd4; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the platform statistics displayed at the bottom.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_industry_stats_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_industry_stats_heading" name="apex_industry_stats_heading" 
                               value="<?php echo esc_attr(get_option('apex_industry_stats_heading_' . $page_slug, 'Trusted Across the Continent')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_stats_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_industry_stats_description" name="apex_industry_stats_description" 
                               value="<?php echo esc_attr(get_option('apex_industry_stats_description_' . $page_slug, 'Our track record speaks for itself.')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_stats_items">Stats Items</label></th>
                    <td>
                        <textarea id="apex_industry_stats_items" name="apex_industry_stats_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_industry_stats_items_' . $page_slug, "$5B+ | Transactions Processed Annually\n99.9% | Platform Uptime\n40% | Average Cost Reduction\n3x | Customer Growth Rate")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Testimonial Section -->
        <div style="margin-bottom: 30px;">
            <h4>💬 Testimonial Section</h4>
            <div style="background: #fce4ec; padding: 15px; margin-bottom: 20px; border: 1px solid #e91e63; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the testimonial quote and author information.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_industry_testimonial_quote">Testimonial Quote</label></th>
                    <td>
                        <textarea id="apex_industry_testimonial_quote" name="apex_industry_testimonial_quote" 
                                  class="large-text" rows="4" 
                                  placeholder="Enter the testimonial quote"><?php echo esc_textarea(get_option('apex_industry_testimonial_quote_' . $page_slug, "Apex Softwares truly understands the African financial services landscape. Their solutions have helped us reach customers we never thought possible while dramatically reducing our operational costs.")); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_testimonial_author">Author Name</label></th>
                    <td>
                        <input type="text" id="apex_industry_testimonial_author" name="apex_industry_testimonial_author" 
                               value="<?php echo esc_attr(get_option('apex_industry_testimonial_author_' . $page_slug, 'James Mwangi')); ?>" 
                               class="regular-text" placeholder="Author name">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_testimonial_title">Author Title</label></th>
                    <td>
                        <input type="text" id="apex_industry_testimonial_title" name="apex_industry_testimonial_title" 
                               value="<?php echo esc_attr(get_option('apex_industry_testimonial_title_' . $page_slug, 'CEO, Kenya National SACCO')); ?>" 
                               class="regular-text" placeholder="e.g., CEO, Company Name">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_industry_testimonial_image">Author Image URL</label></th>
                    <td>
                        <input type="url" id="apex_industry_testimonial_image" name="apex_industry_testimonial_image" 
                               value="<?php echo esc_url(get_option('apex_industry_testimonial_image_' . $page_slug, 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'industry-mfis'): ?>
        <!-- Industry MFIs Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_mfi_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_mfi_hero_badge" name="apex_mfi_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_mfi_hero_badge_' . $page_slug, 'Microfinance Institutions')); ?>" 
                               class="regular-text" placeholder="e.g., Microfinance Institutions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_mfi_hero_heading" name="apex_mfi_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_mfi_hero_heading_' . $page_slug, 'Empowering MFIs to Reach More, Serve Better')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_mfi_hero_description" name="apex_mfi_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_mfi_hero_description_' . $page_slug, 'Digital-first solutions designed specifically for microfinance institutions. Reduce operational costs, expand your reach, and deliver exceptional service to underserved communities.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_mfi_hero_image" name="apex_mfi_hero_image" 
                               value="<?php echo esc_url(get_option('apex_mfi_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_mfi_hero_stats" name="apex_mfi_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_mfi_hero_stats_' . $page_slug, "50+ | MFI Clients\n5M+ | Borrowers Served\n90% | Faster Processing\n45% | Cost Reduction")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | MFI Clients</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Challenges Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚠️ Industry Challenges Section</h4>
            <div style="background: #ffebee; padding: 15px; margin-bottom: 20px; border: 1px solid #e53935; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the challenges MFIs face. Enter 4 challenges below.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_mfi_challenges_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_mfi_challenges_badge" name="apex_mfi_challenges_badge" 
                               value="<?php echo esc_attr(get_option('apex_mfi_challenges_badge_' . $page_slug, 'Your Challenges')); ?>" 
                               class="regular-text" placeholder="e.g., Your Challenges">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_challenges_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_mfi_challenges_heading" name="apex_mfi_challenges_heading" 
                               value="<?php echo esc_attr(get_option('apex_mfi_challenges_heading_' . $page_slug, 'We Understand MFI Challenges')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_challenges_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_mfi_challenges_description" name="apex_mfi_challenges_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_mfi_challenges_description_' . $page_slug, 'Microfinance institutions face unique operational challenges. Our solutions are designed to address each one.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_challenges_items">Challenges List</label></th>
                    <td>
                        <textarea id="apex_mfi_challenges_items" name="apex_mfi_challenges_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line, 4 items)"><?php echo esc_textarea(get_option('apex_mfi_challenges_items_' . $page_slug, "Slow Loan Processing | Manual processes delay disbursements and frustrate borrowers who need quick access to funds.\nHigh Operating Costs | Paper-based operations and manual data entry drive up costs and reduce profitability.\nLimited Geographic Reach | Serving remote communities is expensive with traditional branch-based models.\nCredit Risk Management | Assessing creditworthiness without traditional credit history is challenging.")); ?></textarea>
                        <p class="description">Enter 4 challenges. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Solutions Section -->
        <div style="margin-bottom: 30px;">
            <h4>✅ Industry Solutions Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays 4 MFI solutions with features lists.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_mfi_solutions_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_mfi_solutions_badge" name="apex_mfi_solutions_badge" 
                               value="<?php echo esc_attr(get_option('apex_mfi_solutions_badge_' . $page_slug, 'Our Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., Our Solutions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_solutions_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_mfi_solutions_heading" name="apex_mfi_solutions_heading" 
                               value="<?php echo esc_attr(get_option('apex_mfi_solutions_heading_' . $page_slug, 'Purpose-Built for Microfinance')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_solutions_items">Solutions List</label></th>
                    <td>
                        <textarea id="apex_mfi_solutions_items" name="apex_mfi_solutions_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4 (4 solutions)"><?php echo esc_textarea(get_option('apex_mfi_solutions_items_' . $page_slug, "01 | Digital Loan Origination | Automate the entire loan lifecycle from application to disbursement. Reduce processing time from days to minutes with digital workflows and automated credit scoring. | Mobile loan applications, Automated credit scoring, Digital document collection, Instant disbursement to mobile money\n02 | Agent Banking Network | Extend your reach without building branches. Our agent banking platform lets you serve customers through a network of local agents in their communities. | Agent onboarding and management, Real-time transaction processing, Commission management, Agent performance analytics\n03 | Mobile Banking App | Give your customers 24/7 access to their accounts. Our mobile app works even in low-connectivity areas with offline-first design. | Account management, Loan repayments, Mobile money integration, Push notifications\n04 | Group Lending Management | Manage group loans efficiently with tools designed for solidarity lending models popular in microfinance. | Group formation and management, Meeting scheduling, Group savings tracking, Peer guarantee management")); ?></textarea>
                        <p class="description">Enter 4 solutions. Format per line: <code>Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Case Study Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Case Study Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays a success story case study with results.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_mfi_case_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_mfi_case_badge" name="apex_mfi_case_badge" 
                               value="<?php echo esc_attr(get_option('apex_mfi_case_badge_' . $page_slug, 'Success Story')); ?>" 
                               class="regular-text" placeholder="e.g., Success Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_case_heading">Case Study Heading</label></th>
                    <td>
                        <input type="text" id="apex_mfi_case_heading" name="apex_mfi_case_heading" 
                               value="<?php echo esc_attr(get_option('apex_mfi_case_heading_' . $page_slug, 'How Umoja MFI Scaled to 500,000 Customers')); ?>" 
                               class="large-text" placeholder="Enter the case study heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_case_description">Case Study Description</label></th>
                    <td>
                        <textarea id="apex_mfi_case_description" name="apex_mfi_case_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the case study description"><?php echo esc_textarea(get_option('apex_mfi_case_description_' . $page_slug, 'Umoja Microfinance was struggling with manual processes that limited their growth. After implementing our digital lending platform, they transformed their operations.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_case_results">Case Study Results</label></th>
                    <td>
                        <textarea id="apex_mfi_case_results" name="apex_mfi_case_results" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (3 results, one per line)"><?php echo esc_textarea(get_option('apex_mfi_case_results_' . $page_slug, "500K | Active Borrowers\n90% | Faster Processing\n60% | Cost Reduction")); ?></textarea>
                        <p class="description">Enter 3 results. Format per line: <code>Value | Label</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_case_image">Case Study Image URL</label></th>
                    <td>
                        <input type="url" id="apex_mfi_case_image" name="apex_mfi_case_image" 
                               value="<?php echo esc_url(get_option('apex_mfi_case_image_' . $page_slug, 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mfi_case_link">Case Study Link URL</label></th>
                    <td>
                        <input type="text" id="apex_mfi_case_link" name="apex_mfi_case_link" 
                               value="<?php echo esc_attr(get_option('apex_mfi_case_link_' . $page_slug, '/insights/success-stories')); ?>" 
                               class="large-text" placeholder="/insights/success-stories">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'industry-credit-unions'): ?>
        <!-- Industry Credit Unions Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_credit_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_credit_hero_badge" name="apex_credit_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_credit_hero_badge_' . $page_slug, 'SACCOs & Credit Unions')); ?>" 
                               class="regular-text" placeholder="e.g., SACCOs & Credit Unions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_credit_hero_heading" name="apex_credit_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_credit_hero_heading_' . $page_slug, 'Modern Solutions for Member-Owned Institutions')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_credit_hero_description" name="apex_credit_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_credit_hero_description_' . $page_slug, 'Empower your members with digital services while preserving the cooperative values that make SACCOs special. Our solutions are designed for the unique needs of member-owned financial institutions.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_credit_hero_image" name="apex_credit_hero_image" 
                               value="<?php echo esc_url(get_option('apex_credit_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_credit_hero_stats" name="apex_credit_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_credit_hero_stats_' . $page_slug, "40+ | SACCO Clients\n2M+ | Members Served\n300% | Avg. Growth\n4.8/5 | Satisfaction")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>40+ | SACCO Clients</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Challenges Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚠️ Industry Challenges Section</h4>
            <div style="background: #ffebee; padding: 15px; margin-bottom: 20px; border: 1px solid #e53935; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the challenges SACCOs face. Enter 4 challenges below.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_credit_challenges_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_credit_challenges_badge" name="apex_credit_challenges_badge" 
                               value="<?php echo esc_attr(get_option('apex_credit_challenges_badge_' . $page_slug, 'Your Challenges')); ?>" 
                               class="regular-text" placeholder="e.g., Your Challenges">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_challenges_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_credit_challenges_heading" name="apex_credit_challenges_heading" 
                               value="<?php echo esc_attr(get_option('apex_credit_challenges_heading_' . $page_slug, 'We Understand SACCO Challenges')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_challenges_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_credit_challenges_description" name="apex_credit_challenges_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_credit_challenges_description_' . $page_slug, "SACCOs face unique challenges balancing member service with operational efficiency. We've built solutions that address each one.")); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_challenges_items">Challenges List</label></th>
                    <td>
                        <textarea id="apex_credit_challenges_items" name="apex_credit_challenges_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line, 4 items)"><?php echo esc_textarea(get_option('apex_credit_challenges_items_' . $page_slug, "Member Expectations | Members expect digital services comparable to commercial banks while maintaining personal relationships.\nRegulatory Compliance | Keeping up with evolving SASRA and Central Bank regulations requires constant system updates.\nDividend Management | Complex dividend calculations and distribution across different share classes is time-consuming.\nLegacy Systems | Outdated systems limit growth and make it difficult to offer modern digital services.")); ?></textarea>
                        <p class="description">Enter 4 challenges. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Solutions Section -->
        <div style="margin-bottom: 30px;">
            <h4>✅ Industry Solutions Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays 4 SACCO solutions with features lists.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_credit_solutions_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_credit_solutions_badge" name="apex_credit_solutions_badge" 
                               value="<?php echo esc_attr(get_option('apex_credit_solutions_badge_' . $page_slug, 'Our Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., Our Solutions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_solutions_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_credit_solutions_heading" name="apex_credit_solutions_heading" 
                               value="<?php echo esc_attr(get_option('apex_credit_solutions_heading_' . $page_slug, 'Purpose-Built for SACCOs')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_solutions_items">Solutions List</label></th>
                    <td>
                        <textarea id="apex_credit_solutions_items" name="apex_credit_solutions_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4 (4 solutions)"><?php echo esc_textarea(get_option('apex_credit_solutions_items_' . $page_slug, "01 | Member Management | Complete member lifecycle management from registration to exit. Track shares, savings, loans, and guarantees in one unified system. | Digital member onboarding, Share capital management, Guarantor tracking, Member portal access\n02 | Savings Products | Flexible savings product configuration to match your SACCO's unique offerings, from regular savings to fixed deposits. | Multiple savings accounts, Interest calculation automation, Standing orders, Goal-based savings\n03 | Loan Management | Streamline loan processing with automated eligibility checks, approval workflows, and disbursement. | Multiple loan products, Guarantor management, Automated eligibility, Check-off integration\n04 | Mobile & USSD Banking | Give members 24/7 access to their accounts through mobile app and USSD for feature phones. | Balance inquiries, Mini statements, Loan applications, Fund transfers")); ?></textarea>
                        <p class="description">Enter 4 solutions. Format per line: <code>Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Case Study Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Case Study Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays a success story case study with results.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_credit_case_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_credit_case_badge" name="apex_credit_case_badge" 
                               value="<?php echo esc_attr(get_option('apex_credit_case_badge_' . $page_slug, 'Success Story')); ?>" 
                               class="regular-text" placeholder="e.g., Success Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_case_heading">Case Study Heading</label></th>
                    <td>
                        <input type="text" id="apex_credit_case_heading" name="apex_credit_case_heading" 
                               value="<?php echo esc_attr(get_option('apex_credit_case_heading_' . $page_slug, "Kenya National SACCO's Digital Transformation")); ?>" 
                               class="large-text" placeholder="Enter the case study heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_case_description">Case Study Description</label></th>
                    <td>
                        <textarea id="apex_credit_case_description" name="apex_credit_case_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the case study description"><?php echo esc_textarea(get_option('apex_credit_case_description_' . $page_slug, 'Kenya National SACCO was losing members to commercial banks offering digital services. After implementing our platform, they became a digital leader in the SACCO sector.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_case_results">Case Study Results</label></th>
                    <td>
                        <textarea id="apex_credit_case_results" name="apex_credit_case_results" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (3 results, one per line)"><?php echo esc_textarea(get_option('apex_credit_case_results_' . $page_slug, "300% | Membership Growth\n65% | Cost Reduction\n4.8/5 | Member Satisfaction")); ?></textarea>
                        <p class="description">Enter 3 results. Format per line: <code>Value | Label</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_case_image">Case Study Image URL</label></th>
                    <td>
                        <input type="url" id="apex_credit_case_image" name="apex_credit_case_image" 
                               value="<?php echo esc_url(get_option('apex_credit_case_image_' . $page_slug, 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_credit_case_link">Case Study Link URL</label></th>
                    <td>
                        <input type="text" id="apex_credit_case_link" name="apex_credit_case_link" 
                               value="<?php echo esc_attr(get_option('apex_credit_case_link_' . $page_slug, '/insights/success-stories')); ?>" 
                               class="large-text" placeholder="/insights/success-stories">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'industry-banks-microfinance'): ?>
        <!-- Industry Banks Microfinance Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_bank_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_bank_hero_badge" name="apex_bank_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_bank_hero_badge_' . $page_slug, 'Commercial Banks')); ?>" 
                               class="regular-text" placeholder="e.g., Commercial Banks">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_bank_hero_heading" name="apex_bank_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_bank_hero_heading_' . $page_slug, 'Enterprise-Grade Banking Technology')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_bank_hero_description" name="apex_bank_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_bank_hero_description_' . $page_slug, 'Modernize your core banking infrastructure and deliver exceptional digital experiences. Our solutions help banks compete effectively in an increasingly digital landscape.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_bank_hero_image" name="apex_bank_hero_image" 
                               value="<?php echo esc_url(get_option('apex_bank_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_bank_hero_stats" name="apex_bank_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_bank_hero_stats_' . $page_slug, "15+ | Bank Clients\n3M+ | Customers Served\n99.99% | Uptime SLA\n10x | Faster Transactions")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>15+ | Bank Clients</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Challenges Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚠️ Industry Challenges Section</h4>
            <div style="background: #ffebee; padding: 15px; margin-bottom: 20px; border: 1px solid #e53935; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the challenges Banks face. Enter 4 challenges below.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_bank_challenges_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_bank_challenges_badge" name="apex_bank_challenges_badge" 
                               value="<?php echo esc_attr(get_option('apex_bank_challenges_badge_' . $page_slug, 'Your Challenges')); ?>" 
                               class="regular-text" placeholder="e.g., Your Challenges">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_challenges_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_bank_challenges_heading" name="apex_bank_challenges_heading" 
                               value="<?php echo esc_attr(get_option('apex_bank_challenges_heading_' . $page_slug, 'We Understand Banking Challenges')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_challenges_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_bank_challenges_description" name="apex_bank_challenges_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_bank_challenges_description_' . $page_slug, 'Commercial banks face intense competition and rapidly evolving customer expectations. Our solutions address these challenges head-on.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_challenges_items">Challenges List</label></th>
                    <td>
                        <textarea id="apex_bank_challenges_items" name="apex_bank_challenges_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line, 4 items)"><?php echo esc_textarea(get_option('apex_bank_challenges_items_' . $page_slug, "Legacy System Constraints | Aging core banking systems limit agility and make it difficult to launch new products quickly.\nFintech Competition | Agile fintechs are capturing market share with superior digital experiences.\nRegulatory Pressure | Increasing regulatory requirements demand robust compliance and reporting capabilities.\nCost Optimization | Pressure to reduce cost-to-income ratios while maintaining service quality.")); ?></textarea>
                        <p class="description">Enter 4 challenges. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Solutions Section -->
        <div style="margin-bottom: 30px;">
            <h4>✅ Industry Solutions Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays 4 Banking solutions with features lists.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_bank_solutions_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_bank_solutions_badge" name="apex_bank_solutions_badge" 
                               value="<?php echo esc_attr(get_option('apex_bank_solutions_badge_' . $page_slug, 'Our Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., Our Solutions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_solutions_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_bank_solutions_heading" name="apex_bank_solutions_heading" 
                               value="<?php echo esc_attr(get_option('apex_bank_solutions_heading_' . $page_slug, 'Enterprise Banking Platform')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_solutions_items">Solutions List</label></th>
                    <td>
                        <textarea id="apex_bank_solutions_items" name="apex_bank_solutions_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4 (4 solutions)"><?php echo esc_textarea(get_option('apex_bank_solutions_items_' . $page_slug, "01 | Modern Core Banking | Cloud-native core banking system designed for high transaction volumes, real-time processing, and rapid product innovation. | Real-time transaction processing, Multi-currency support, Flexible product configuration, API-first architecture\n02 | Digital Channels | Comprehensive digital banking suite including mobile app, internet banking, and USSD for complete customer coverage. | White-label mobile app, Responsive internet banking, USSD banking, Chatbot integration\n03 | Payment Hub | Unified payment processing platform supporting all payment types and channels with real-time settlement. | RTGS/EFT integration, Card processing, Mobile money interoperability, Bill payments\n04 | Analytics & Reporting | Real-time business intelligence and regulatory reporting to drive decisions and ensure compliance. | Real-time dashboards, Regulatory reports, Customer analytics, Risk monitoring")); ?></textarea>
                        <p class="description">Enter 4 solutions. Format per line: <code>Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Case Study Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Case Study Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays a success story case study with results.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_bank_case_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_bank_case_badge" name="apex_bank_case_badge" 
                               value="<?php echo esc_attr(get_option('apex_bank_case_badge_' . $page_slug, 'Success Story')); ?>" 
                               class="regular-text" placeholder="e.g., Success Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_case_heading">Case Study Heading</label></th>
                    <td>
                        <input type="text" id="apex_bank_case_heading" name="apex_bank_case_heading" 
                               value="<?php echo esc_attr(get_option('apex_bank_case_heading_' . $page_slug, "Unity Bank's Core Banking Transformation")); ?>" 
                               class="large-text" placeholder="Enter the case study heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_case_description">Case Study Description</label></th>
                    <td>
                        <textarea id="apex_bank_case_description" name="apex_bank_case_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the case study description"><?php echo esc_textarea(get_option('apex_bank_case_description_' . $page_slug, 'Unity Bank Nigeria replaced their 15-year-old legacy core with ApexCore, achieving seamless migration and dramatically improved performance.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_case_results">Case Study Results</label></th>
                    <td>
                        <textarea id="apex_bank_case_results" name="apex_bank_case_results" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (3 results, one per line)"><?php echo esc_textarea(get_option('apex_bank_case_results_' . $page_slug, "Zero | Downtime Migration\n10x | Faster Transactions\n50% | Cost Reduction")); ?></textarea>
                        <p class="description">Enter 3 results. Format per line: <code>Value | Label</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_case_image">Case Study Image URL</label></th>
                    <td>
                        <input type="url" id="apex_bank_case_image" name="apex_bank_case_image" 
                               value="<?php echo esc_url(get_option('apex_bank_case_image_' . $page_slug, 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_bank_case_link">Case Study Link URL</label></th>
                    <td>
                        <input type="text" id="apex_bank_case_link" name="apex_bank_case_link" 
                               value="<?php echo esc_attr(get_option('apex_bank_case_link_' . $page_slug, '/insights/success-stories')); ?>" 
                               class="large-text" placeholder="/insights/success-stories">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'industry-digital-government'): ?>
        <!-- Industry Digital Government Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_gov_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_gov_hero_badge" name="apex_gov_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_gov_hero_badge_' . $page_slug, 'Digital Government & NGOs')); ?>" 
                               class="regular-text" placeholder="e.g., Digital Government & NGOs">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_gov_hero_heading" name="apex_gov_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_gov_hero_heading_' . $page_slug, 'Secure Financial Solutions for Public Programs')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_gov_hero_description" name="apex_gov_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_gov_hero_description_' . $page_slug, 'Enable efficient, transparent, and accountable financial operations for government programs and development organizations. Our platforms ensure funds reach beneficiaries quickly and securely.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_gov_hero_image" name="apex_gov_hero_image" 
                               value="<?php echo esc_url(get_option('apex_gov_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_gov_hero_stats" name="apex_gov_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_gov_hero_stats_' . $page_slug, "10+ | Programs Supported\n\$500M+ | Funds Disbursed\n1M+ | Beneficiaries\n100% | Audit Trail")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>10+ | Programs Supported</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Challenges Section -->
        <div style="margin-bottom: 30px;">
            <h4>⚠️ Industry Challenges Section</h4>
            <div style="background: #ffebee; padding: 15px; margin-bottom: 20px; border: 1px solid #e53935; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the challenges Government/NGO programs face. Enter 4 challenges below.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_gov_challenges_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_gov_challenges_badge" name="apex_gov_challenges_badge" 
                               value="<?php echo esc_attr(get_option('apex_gov_challenges_badge_' . $page_slug, 'Your Challenges')); ?>" 
                               class="regular-text" placeholder="e.g., Your Challenges">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_challenges_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_gov_challenges_heading" name="apex_gov_challenges_heading" 
                               value="<?php echo esc_attr(get_option('apex_gov_challenges_heading_' . $page_slug, 'We Understand Public Sector Challenges')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_challenges_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_gov_challenges_description" name="apex_gov_challenges_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_gov_challenges_description_' . $page_slug, 'Government programs and NGOs face unique challenges in financial management. Our solutions address these with purpose-built features.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_challenges_items">Challenges List</label></th>
                    <td>
                        <textarea id="apex_gov_challenges_items" name="apex_gov_challenges_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (one per line, 4 items)"><?php echo esc_textarea(get_option('apex_gov_challenges_items_' . $page_slug, "Accountability & Transparency | Donors and stakeholders demand complete visibility into how funds are used.\nBeneficiary Identification | Ensuring funds reach intended beneficiaries without fraud or duplication.\nLast-Mile Delivery | Reaching beneficiaries in remote areas with limited banking infrastructure.\nReporting Requirements | Complex reporting requirements from multiple stakeholders and donors.")); ?></textarea>
                        <p class="description">Enter 4 challenges. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Industry Solutions Section -->
        <div style="margin-bottom: 30px;">
            <h4>✅ Industry Solutions Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays 4 Government solutions with features lists.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_gov_solutions_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_gov_solutions_badge" name="apex_gov_solutions_badge" 
                               value="<?php echo esc_attr(get_option('apex_gov_solutions_badge_' . $page_slug, 'Our Solutions')); ?>" 
                               class="regular-text" placeholder="e.g., Our Solutions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_solutions_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_gov_solutions_heading" name="apex_gov_solutions_heading" 
                               value="<?php echo esc_attr(get_option('apex_gov_solutions_heading_' . $page_slug, 'Purpose-Built for Public Programs')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_solutions_items">Solutions List</label></th>
                    <td>
                        <textarea id="apex_gov_solutions_items" name="apex_gov_solutions_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4 (4 solutions)"><?php echo esc_textarea(get_option('apex_gov_solutions_items_' . $page_slug, "01 | Beneficiary Management | Comprehensive beneficiary registration and verification system with biometric integration to prevent fraud and duplication. | Biometric registration, Deduplication checks, Eligibility verification, Beneficiary portal\n02 | Disbursement Platform | Multi-channel disbursement supporting mobile money, bank transfers, and cash through agent networks. | Bulk disbursements, Mobile money integration, Agent cash-out, Real-time tracking\n03 | Collection Management | Efficient collection of taxes, fees, and contributions with multiple payment channels and reconciliation. | Multi-channel collection, Automated reconciliation, Receipt generation, Arrears management\n04 | Audit & Reporting | Complete audit trail and customizable reporting for donors, government, and internal stakeholders. | Complete audit trail, Donor reports, Real-time dashboards, Custom report builder")); ?></textarea>
                        <p class="description">Enter 4 solutions. Format per line: <code>Number | Title | Description | Feature 1, Feature 2, Feature 3, Feature 4</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Use Cases Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎯 Use Cases Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays 6 use cases for Government/NGO programs.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_gov_usecases_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_gov_usecases_badge" name="apex_gov_usecases_badge" 
                               value="<?php echo esc_attr(get_option('apex_gov_usecases_badge_' . $page_slug, 'Use Cases')); ?>" 
                               class="regular-text" placeholder="e.g., Use Cases">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_usecases_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_gov_usecases_heading" name="apex_gov_usecases_heading" 
                               value="<?php echo esc_attr(get_option('apex_gov_usecases_heading_' . $page_slug, 'Programs We Support')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_usecases_items">Use Cases List</label></th>
                    <td>
                        <textarea id="apex_gov_usecases_items" name="apex_gov_usecases_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (6 use cases)"><?php echo esc_textarea(get_option('apex_gov_usecases_items_' . $page_slug, "Social Protection Programs | Cash transfer programs, pension disbursements, and social safety net payments.\nAgricultural Subsidies | Farmer registration, input subsidy distribution, and crop payment programs.\nEducation Grants | Scholarship disbursements, school fee payments, and education stipends.\nHealth Programs | Community health worker payments, patient support, and health insurance.\nRevenue Collection | Tax collection, license fees, and utility payments for government agencies.\nHumanitarian Aid | Emergency cash transfers, refugee assistance, and disaster relief programs.")); ?></textarea>
                        <p class="description">Enter 6 use cases. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Case Study Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Case Study Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays a success story case study with results.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_gov_case_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_gov_case_badge" name="apex_gov_case_badge" 
                               value="<?php echo esc_attr(get_option('apex_gov_case_badge_' . $page_slug, 'Success Story')); ?>" 
                               class="regular-text" placeholder="e.g., Success Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_case_heading">Case Study Heading</label></th>
                    <td>
                        <input type="text" id="apex_gov_case_heading" name="apex_gov_case_heading" 
                               value="<?php echo esc_attr(get_option('apex_gov_case_heading_' . $page_slug, 'National Social Protection Program')); ?>" 
                               class="large-text" placeholder="Enter the case study heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_case_description">Case Study Description</label></th>
                    <td>
                        <textarea id="apex_gov_case_description" name="apex_gov_case_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the case study description"><?php echo esc_textarea(get_option('apex_gov_case_description_' . $page_slug, 'A national government partnered with us to digitize their social protection program, reaching over 500,000 vulnerable households with monthly cash transfers.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_case_results">Case Study Results</label></th>
                    <td>
                        <textarea id="apex_gov_case_results" name="apex_gov_case_results" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (3 results, one per line)"><?php echo esc_textarea(get_option('apex_gov_case_results_' . $page_slug, "500K | Households Reached\n98% | Successful Disbursement\n70% | Cost Reduction")); ?></textarea>
                        <p class="description">Enter 3 results. Format per line: <code>Value | Label</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_case_image">Case Study Image URL</label></th>
                    <td>
                        <input type="url" id="apex_gov_case_image" name="apex_gov_case_image" 
                               value="<?php echo esc_url(get_option('apex_gov_case_image_' . $page_slug, 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_gov_case_link">Case Study Link URL</label></th>
                    <td>
                        <input type="text" id="apex_gov_case_link" name="apex_gov_case_link" 
                               value="<?php echo esc_attr(get_option('apex_gov_case_link_' . $page_slug, '/insights/success-stories')); ?>" 
                               class="large-text" placeholder="/insights/success-stories">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'insights-blog'): ?>
        <!-- Insights Blog Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_blog_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_blog_hero_badge" name="apex_blog_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_blog_hero_badge_' . $page_slug, 'Insights & Thought Leadership')); ?>" 
                               class="regular-text" placeholder="e.g., Insights & Thought Leadership">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_blog_hero_heading" name="apex_blog_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_blog_hero_heading_' . $page_slug, 'The Apex Blog')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_blog_hero_description" name="apex_blog_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_blog_hero_description_' . $page_slug, 'Expert insights, industry trends, and practical guides on digital banking, financial technology, and driving innovation in African financial services.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_blog_hero_image" name="apex_blog_hero_image" 
                               value="<?php echo esc_url(get_option('apex_blog_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_blog_hero_stats" name="apex_blog_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_blog_hero_stats_' . $page_slug, "200+ | Articles Published\n50K+ | Monthly Readers\n15+ | Expert Contributors\n8 | Topic Categories")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>200+ | Articles Published</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Featured Article Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Featured Article Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the featured article card (Editor's Pick). Select a published post to feature — its title, excerpt, image, date, category, and author will be pulled automatically.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_blog_featured_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_blog_featured_badge" name="apex_blog_featured_badge" 
                               value="<?php echo esc_attr(get_option('apex_blog_featured_badge_' . $page_slug, "Editor's Pick")); ?>" 
                               class="regular-text" placeholder="e.g., Editor's Pick">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_featured_post_id">Select Featured Post</label></th>
                    <td>
                        <?php
                        $selected_post_id = intval(get_option('apex_blog_featured_post_id_' . $page_slug, 0));
                        $published_posts = get_posts([
                            'post_type'      => 'post',
                            'post_status'    => 'publish',
                            'posts_per_page' => -1,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        ]);
                        ?>
                        <select id="apex_blog_featured_post_id" name="apex_blog_featured_post_id" class="regular-text" style="min-width: 400px;" onchange="apexUpdateFeaturedPreview(this)">
                            <option value="0">— Select a published post —</option>
                            <?php foreach ($published_posts as $p) : ?>
                                <option value="<?php echo intval($p->ID); ?>" <?php selected($selected_post_id, $p->ID); ?>
                                    data-thumb="<?php echo esc_attr(get_the_post_thumbnail_url($p->ID, 'medium') ?: ''); ?>"
                                    data-date="<?php echo esc_attr(get_the_date('F j, Y', $p->ID)); ?>"
                                    data-category="<?php $cats = get_the_category($p->ID); echo $cats ? esc_attr($cats[0]->name) : ''; ?>"
                                    data-excerpt="<?php echo esc_attr(wp_trim_words($p->post_excerpt ?: wp_strip_all_tags($p->post_content), 30)); ?>"
                                    data-author="<?php echo esc_attr(get_the_author_meta('display_name', $p->post_author)); ?>"
                                    data-avatar="<?php echo esc_attr(get_avatar_url($p->post_author, ['size' => 100])); ?>"
                                    data-link="<?php echo esc_attr(get_permalink($p->ID)); ?>"
                                    data-readtime="<?php $wc = str_word_count(wp_strip_all_tags($p->post_content)); echo esc_attr(max(1, ceil($wc / 200)) . ' min read'); ?>"
                                ><?php echo esc_html($p->post_title); ?> (<?php echo get_the_date('M j, Y', $p->ID); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Choose a published post to feature as "Editor's Pick". All article details will be pulled automatically from the post.</p>
                    </td>
                </tr>
            </table>

            <?php if ($selected_post_id && get_post($selected_post_id)) :
                $fp = get_post($selected_post_id);
                $fp_cats = get_the_category($selected_post_id);
                $fp_thumb = get_the_post_thumbnail_url($selected_post_id, 'medium');
                $fp_excerpt = wp_trim_words($fp->post_excerpt ?: wp_strip_all_tags($fp->post_content), 30);
                $fp_author = get_the_author_meta('display_name', $fp->post_author);
                $fp_avatar = get_avatar_url($fp->post_author, ['size' => 100]);
                $fp_wc = str_word_count(wp_strip_all_tags($fp->post_content));
                $fp_readtime = max(1, ceil($fp_wc / 200)) . ' min read';
            ?>
            <div id="apex-featured-preview" style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-top: 15px;">
                <h5 style="margin-top:0;">📰 Featured Post Preview</h5>
                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <?php if ($fp_thumb) : ?>
                    <div style="flex-shrink:0;"><img src="<?php echo esc_url($fp_thumb); ?>" style="width:200px; height:130px; object-fit:cover; border-radius:6px;" alt=""></div>
                    <?php endif; ?>
                    <div>
                        <p style="margin:0 0 5px;"><strong>Title:</strong> <?php echo esc_html($fp->post_title); ?></p>
                        <p style="margin:0 0 5px;"><strong>Category:</strong> <?php echo $fp_cats ? esc_html($fp_cats[0]->name) : 'Uncategorized'; ?></p>
                        <p style="margin:0 0 5px;"><strong>Date:</strong> <?php echo get_the_date('F j, Y', $selected_post_id); ?></p>
                        <p style="margin:0 0 5px;"><strong>Read Time:</strong> <?php echo esc_html($fp_readtime); ?></p>
                        <p style="margin:0 0 5px;"><strong>Author:</strong> <?php echo esc_html($fp_author); ?></p>
                        <p style="margin:0 0 5px;"><strong>Excerpt:</strong> <?php echo esc_html($fp_excerpt); ?></p>
                        <p style="margin:0;"><a href="<?php echo esc_url(get_permalink($selected_post_id)); ?>" target="_blank">View Post →</a></p>
                    </div>
                </div>
            </div>
            <?php else : ?>
            <div id="apex-featured-preview" style="background: #fff8e1; border: 1px solid #ffe082; border-radius: 8px; padding: 15px; margin-top: 15px;">
                <p style="margin:0;"><em>No post selected. Choose a published post above to see a preview and feature it on the blog page.</em></p>
            </div>
            <?php endif; ?>
        </div>

        <script>
        function apexUpdateFeaturedPreview(sel) {
            var opt = sel.options[sel.selectedIndex];
            var preview = document.getElementById('apex-featured-preview');
            if (!preview) return;
            if (opt.value === '0') {
                preview.innerHTML = '<p style="margin:0;"><em>No post selected. Choose a published post above to see a preview and feature it on the blog page.</em></p>';
                preview.style.background = '#fff8e1';
                preview.style.border = '1px solid #ffe082';
                return;
            }
            preview.style.background = '#f9f9f9';
            preview.style.border = '1px solid #ddd';
            var thumb = opt.getAttribute('data-thumb');
            var imgHtml = thumb ? '<div style="flex-shrink:0;"><img src="' + thumb + '" style="width:200px;height:130px;object-fit:cover;border-radius:6px;" alt=""></div>' : '';
            preview.innerHTML = '<h5 style="margin-top:0;">📰 Featured Post Preview</h5>' +
                '<div style="display:flex;gap:20px;align-items:flex-start;">' + imgHtml +
                '<div>' +
                '<p style="margin:0 0 5px;"><strong>Title:</strong> ' + opt.text.replace(/ \(.*\)$/, '') + '</p>' +
                '<p style="margin:0 0 5px;"><strong>Category:</strong> ' + (opt.getAttribute('data-category') || 'Uncategorized') + '</p>' +
                '<p style="margin:0 0 5px;"><strong>Date:</strong> ' + (opt.getAttribute('data-date') || '') + '</p>' +
                '<p style="margin:0 0 5px;"><strong>Read Time:</strong> ' + (opt.getAttribute('data-readtime') || '') + '</p>' +
                '<p style="margin:0 0 5px;"><strong>Author:</strong> ' + (opt.getAttribute('data-author') || '') + '</p>' +
                '<p style="margin:0 0 5px;"><strong>Excerpt:</strong> ' + (opt.getAttribute('data-excerpt') || '') + '</p>' +
                '<p style="margin:0;"><a href="' + (opt.getAttribute('data-link') || '#') + '" target="_blank">View Post →</a></p>' +
                '</div></div>';
        }
        </script>


        <!-- Newsletter Section -->
        <div style="margin-bottom: 30px;">
            <h4>📧 Newsletter Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the newsletter signup form.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_blog_newsletter_heading">Heading</label></th>
                    <td>
                        <input type="text" id="apex_blog_newsletter_heading" name="apex_blog_newsletter_heading" 
                               value="<?php echo esc_attr(get_option('apex_blog_newsletter_heading_' . $page_slug, 'Get Insights Delivered')); ?>" 
                               class="large-text" placeholder="Enter the newsletter heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_newsletter_description">Description</label></th>
                    <td>
                        <textarea id="apex_blog_newsletter_description" name="apex_blog_newsletter_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the newsletter description"><?php echo esc_textarea(get_option('apex_blog_newsletter_description_' . $page_slug, 'Subscribe to our weekly newsletter for the latest articles, industry news, and exclusive insights from our team of experts.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_newsletter_placeholder">Email Placeholder</label></th>
                    <td>
                        <input type="text" id="apex_blog_newsletter_placeholder" name="apex_blog_newsletter_placeholder" 
                               value="<?php echo esc_attr(get_option('apex_blog_newsletter_placeholder_' . $page_slug, 'Enter your email address')); ?>" 
                               class="large-text" placeholder="e.g., Enter your email address">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_newsletter_button">Button Text</label></th>
                    <td>
                        <input type="text" id="apex_blog_newsletter_button" name="apex_blog_newsletter_button" 
                               value="<?php echo esc_attr(get_option('apex_blog_newsletter_button_' . $page_slug, 'Subscribe')); ?>" 
                               class="regular-text" placeholder="e.g., Subscribe">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_blog_newsletter_note">Note Text</label></th>
                    <td>
                        <input type="text" id="apex_blog_newsletter_note" name="apex_blog_newsletter_note" 
                               value="<?php echo esc_attr(get_option('apex_blog_newsletter_note_' . $page_slug, 'Join 10,000+ subscribers. Unsubscribe at any time.')); ?>" 
                               class="large-text" placeholder="e.g., Join 10,000+ subscribers. Unsubscribe at any time.">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'insights-whitepapers-reports'): ?>
        <!-- Insights Whitepapers & Reports Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reports_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reports_hero_badge" name="apex_reports_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_reports_hero_badge_' . $page_slug, 'Research & Resources')); ?>" 
                               class="regular-text" placeholder="e.g., Research & Resources">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_reports_hero_heading" name="apex_reports_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_reports_hero_heading_' . $page_slug, 'Whitepapers & Reports')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_reports_hero_description" name="apex_reports_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_reports_hero_description_' . $page_slug, 'In-depth research, industry analysis, and practical guides to help you make informed decisions about your digital transformation journey.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_reports_hero_image" name="apex_reports_hero_image" 
                               value="<?php echo esc_url(get_option('apex_reports_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_reports_hero_stats" name="apex_reports_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_reports_hero_stats_' . $page_slug, "30+ | Publications\n15K+ | Downloads\n10+ | Research Partners\n5 | Annual Reports")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>30+ | Publications</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Featured Report Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Featured Report Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the featured report card.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reports_featured_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_badge" name="apex_reports_featured_badge" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_badge_' . $page_slug, 'Featured Report')); ?>" 
                               class="regular-text" placeholder="e.g., Featured Report">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_image">Report Image URL</label></th>
                    <td>
                        <input type="url" id="apex_reports_featured_image" name="apex_reports_featured_image" 
                               value="<?php echo esc_url(get_option('apex_reports_featured_image_' . $page_slug, 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_type">Report Type</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_type" name="apex_reports_featured_type" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_type_' . $page_slug, 'Annual Report')); ?>" 
                               class="regular-text" placeholder="e.g., Annual Report">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_date">Date</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_date" name="apex_reports_featured_date" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_date_' . $page_slug, 'January 2026')); ?>" 
                               class="regular-text" placeholder="e.g., January 2026">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_title">Report Title</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_title" name="apex_reports_featured_title" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_title_' . $page_slug, 'The State of Digital Banking in Africa 2026')); ?>" 
                               class="large-text" placeholder="Enter the report title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_excerpt">Report Excerpt</label></th>
                    <td>
                        <textarea id="apex_reports_featured_excerpt" name="apex_reports_featured_excerpt" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the report excerpt"><?php echo esc_textarea(get_option('apex_reports_featured_excerpt_' . $page_slug, 'Our comprehensive annual report analyzing digital banking trends, adoption rates, and opportunities across 15 African markets. Based on surveys of 500+ financial institutions and analysis of 10 million+ transactions.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_highlights">Key Findings (4 items)</label></th>
                    <td>
                        <textarea id="apex_reports_featured_highlights" name="apex_reports_featured_highlights" 
                                  class="large-text" rows="6" 
                                  placeholder="Enter one highlight per line"><?php echo esc_textarea(get_option('apex_reports_featured_highlights_' . $page_slug, "Mobile banking adoption grew 45% year-over-year\nAI-powered services now used by 60% of institutions\nAgent banking networks expanded to reach 50M+ users\nCloud adoption accelerating with 70% planning migration")); ?></textarea>
                        <p class="description">Enter 4 key findings. One per line.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_pages">Pages</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_pages" name="apex_reports_featured_pages" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_pages_' . $page_slug, '86')); ?>" 
                               class="regular-text" placeholder="e.g., 86">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_format">Format</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_format" name="apex_reports_featured_format" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_format_' . $page_slug, 'PDF')); ?>" 
                               class="regular-text" placeholder="e.g., PDF">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_featured_link">Download Link</label></th>
                    <td>
                        <input type="text" id="apex_reports_featured_link" name="apex_reports_featured_link" 
                               value="<?php echo esc_attr(get_option('apex_reports_featured_link_' . $page_slug, '#')); ?>" 
                               class="large-text" placeholder="#">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Categories Section -->
        <div style="margin-bottom: 30px;">
            <h4>📚 Categories Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays the report categories.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reports_categories_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_reports_categories_heading" name="apex_reports_categories_heading" 
                               value="<?php echo esc_attr(get_option('apex_reports_categories_heading_' . $page_slug, 'Browse by Category')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_categories_items">Categories List</label></th>
                    <td>
                        <textarea id="apex_reports_categories_items" name="apex_reports_categories_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: ID | Title | Count (4 categories)"><?php echo esc_textarea(get_option('apex_reports_categories_items_' . $page_slug, "industry-reports | Industry Reports | 8 publications\nwhitepapers | Whitepapers | 12 publications\nguides | Implementation Guides | 6 publications\nbenchmarks | Benchmark Studies | 4 publications")); ?></textarea>
                        <p class="description">Enter 4 categories. Format per line: <code>ID | Title | Count</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Custom Research Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔬 Custom Research Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the custom research CTA.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reports_custom_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reports_custom_badge" name="apex_reports_custom_badge" 
                               value="<?php echo esc_attr(get_option('apex_reports_custom_badge_' . $page_slug, 'Custom Research')); ?>" 
                               class="regular-text" placeholder="e.g., Custom Research">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_custom_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_reports_custom_heading" name="apex_reports_custom_heading" 
                               value="<?php echo esc_attr(get_option('apex_reports_custom_heading_' . $page_slug, 'Need Custom Research?')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_custom_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_reports_custom_description" name="apex_reports_custom_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_reports_custom_description_' . $page_slug, 'Our research team can conduct custom studies tailored to your specific needs, including market analysis, competitive benchmarking, and feasibility studies.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_custom_services">Services (3 items)</label></th>
                    <td>
                        <textarea id="apex_reports_custom_services" name="apex_reports_custom_services" 
                                  class="large-text" rows="6" 
                                  placeholder="Format: Title | Description (3 services)"><?php echo esc_textarea(get_option('apex_reports_custom_services_' . $page_slug, "Market Analysis | Deep-dive into specific markets or segments\nCompetitive Benchmarking | Compare your performance against peers\nFeasibility Studies | Assess viability of new initiatives")); ?></textarea>
                        <p class="description">Enter 3 services. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_custom_image">Image URL</label></th>
                    <td>
                        <input type="url" id="apex_reports_custom_image" name="apex_reports_custom_image" 
                               value="<?php echo esc_url(get_option('apex_reports_custom_image_' . $page_slug, 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=500')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_custom_link">CTA Link</label></th>
                    <td>
                        <input type="text" id="apex_reports_custom_link" name="apex_reports_custom_link" 
                               value="<?php echo esc_attr(get_option('apex_reports_custom_link_' . $page_slug, '/contact')); ?>" 
                               class="large-text" placeholder="/contact">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Newsletter Section -->
        <div style="margin-bottom: 30px;">
            <h4>📧 Newsletter Section</h4>
            <div style="background: #fce4ec; padding: 15px; margin-bottom: 20px; border: 1px solid #e91e63; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the newsletter signup form.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reports_newsletter_heading">Heading</label></th>
                    <td>
                        <input type="text" id="apex_reports_newsletter_heading" name="apex_reports_newsletter_heading" 
                               value="<?php echo esc_attr(get_option('apex_reports_newsletter_heading_' . $page_slug, 'Get New Reports First')); ?>" 
                               class="large-text" placeholder="Enter the newsletter heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_newsletter_description">Description</label></th>
                    <td>
                        <textarea id="apex_reports_newsletter_description" name="apex_reports_newsletter_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the newsletter description"><?php echo esc_textarea(get_option('apex_reports_newsletter_description_' . $page_slug, 'Subscribe to be notified when we publish new research, whitepapers, and industry reports.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_newsletter_placeholder">Email Placeholder</label></th>
                    <td>
                        <input type="text" id="apex_reports_newsletter_placeholder" name="apex_reports_newsletter_placeholder" 
                               value="<?php echo esc_attr(get_option('apex_reports_newsletter_placeholder_' . $page_slug, 'Enter your email address')); ?>" 
                               class="large-text" placeholder="e.g., Enter your email address">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_newsletter_button">Button Text</label></th>
                    <td>
                        <input type="text" id="apex_reports_newsletter_button" name="apex_reports_newsletter_button" 
                               value="<?php echo esc_attr(get_option('apex_reports_newsletter_button_' . $page_slug, 'Subscribe')); ?>" 
                               class="regular-text" placeholder="e.g., Subscribe">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reports_newsletter_note">Note Text</label></th>
                    <td>
                        <input type="text" id="apex_reports_newsletter_note" name="apex_reports_newsletter_note" 
                               value="<?php echo esc_attr(get_option('apex_reports_newsletter_note_' . $page_slug, 'Join 5,000+ subscribers. We respect your privacy.')); ?>" 
                               class="large-text" placeholder="e.g., Join 5,000+ subscribers. We respect your privacy.">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'partners'): ?>
        <!-- Partners Page Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_partners_hero_badge" name="apex_partners_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_partners_hero_badge_' . $page_slug, 'Partners')); ?>" 
                               class="regular-text" placeholder="e.g., Partners">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_hero_heading" name="apex_partners_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_hero_heading_' . $page_slug, 'Partner with Us to Transform African Fintech')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_partners_hero_description" name="apex_partners_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_partners_hero_description_' . $page_slug, 'Join our growing ecosystem of partners and help drive financial inclusion across Africa. We offer flexible partnership models tailored to your business.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_partners_hero_image" name="apex_partners_hero_image" 
                               value="<?php echo esc_url(get_option('apex_partners_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_partners_hero_stats" name="apex_partners_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_partners_hero_stats_' . $page_slug, "50+ | Partners\n15+ | Countries\n100+ | Joint Projects\n$1B+ | Transactions Processed")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | Partners</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Benefits Section -->
        <div style="margin-bottom: 30px;">
            <h4>✨ Benefits Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the "Why Partner with Apex?" benefits grid.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_benefits_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_benefits_heading" name="apex_partners_benefits_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_benefits_heading_' . $page_slug, 'Why Partner with Apex?')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_benefits_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_partners_benefits_description" name="apex_partners_benefits_description" 
                               value="<?php echo esc_attr(get_option('apex_partners_benefits_description_' . $page_slug, "We're committed to mutual growth and success")); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_benefits_items">Benefits (4 items)</label></th>
                    <td>
                        <textarea id="apex_partners_benefits_items" name="apex_partners_benefits_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (4 items)"><?php echo esc_textarea(get_option('apex_partners_benefits_items_' . $page_slug, "Market Leadership | Partner with Africa's leading fintech company serving 50+ financial institutions across 15 countries.\nRevenue Sharing | Attractive revenue models with competitive commissions and flexible terms designed for mutual benefit.\nDedicated Support | Access to our dedicated partner support team, training programs, and marketing resources.\nTechnical Integration | Comprehensive APIs, SDKs, and integration support to ensure seamless deployment.")); ?></textarea>
                        <p class="description">Enter 4 benefits. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Partnership Models Section -->
        <div style="margin-bottom: 30px;">
            <h4>🤝 Partnership Models Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 4 partnership model cards.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_models_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_models_heading" name="apex_partners_models_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_models_heading_' . $page_slug, 'Partnership Models')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_models_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_partners_models_description" name="apex_partners_models_description" 
                               value="<?php echo esc_attr(get_option('apex_partners_models_description_' . $page_slug, 'Choose the partnership model that fits your business')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_models_items">Partnership Models (4 cards)</label></th>
                    <td>
                        <textarea id="apex_partners_models_items" name="apex_partners_models_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description | Feature 1 | Feature 2 | Feature 3 | Feature 4 (4 models)"><?php echo esc_textarea(get_option('apex_partners_models_items_' . $page_slug, "Reseller Partner | Sell our solutions to your clients and earn attractive commissions. Ideal for IT consultants, system integrators, and VARs. | Competitive commission rates | Marketing support | Training and certification | Lead generation support\nTechnology Partner | Integrate our solutions with your technology stack and create comprehensive offerings for your customers. | API access and documentation | Joint go-to-market | Co-marketing opportunities | Technical collaboration\nReferral Partner | Refer clients to us and earn referral fees. Low commitment with high rewards for qualified referrals. | Referral commissions | Easy onboarding | Tracking and reporting | No sales commitment\nStrategic Partner | Deep integration and collaboration for long-term strategic partnerships. For large enterprises and institutions. | Custom integration | Revenue sharing | Co-development | Priority support")); ?></textarea>
                        <p class="description">Enter 4 partnership models. Format per line: <code>Title | Description | Feature 1 | Feature 2 | Feature 3 | Feature 4</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Onboarding Process Section -->
        <div style="margin-bottom: 30px;">
            <h4>📋 Onboarding Process Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 5-step onboarding process.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_process_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_process_heading" name="apex_partners_process_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_process_heading_' . $page_slug, 'Partner Onboarding Process')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_process_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_partners_process_description" name="apex_partners_process_description" 
                               value="<?php echo esc_attr(get_option('apex_partners_process_description_' . $page_slug, 'Simple, transparent, and efficient')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_process_steps">Process Steps (5 steps)</label></th>
                    <td>
                        <textarea id="apex_partners_process_steps" name="apex_partners_process_steps" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (5 steps)"><?php echo esc_textarea(get_option('apex_partners_process_steps_' . $page_slug, "Apply Online | Submit your partnership application through our online portal with your business details.\nReview & Approval | Our team reviews your application and contacts you within 5 business days.\nAgreement Signing | Review and sign the partnership agreement tailored to your chosen model.\nOnboarding & Training | Complete onboarding training and access partner resources and tools.\nStart Selling | Begin selling and earning with full support from our partner team.")); ?></textarea>
                        <p class="description">Enter 5 process steps. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Partner Logos Section -->
        <div style="margin-bottom: 30px;">
            <h4>🏢 Partner Logos Section</h4>
            <div style="background: #e0f2f1; padding: 15px; margin-bottom: 20px; border: 1px solid #009688; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the partner logos grid.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_logos_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_logos_heading" name="apex_partners_logos_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_logos_heading_' . $page_slug, 'Our Partners')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_logos_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_partners_logos_description" name="apex_partners_logos_description" 
                               value="<?php echo esc_attr(get_option('apex_partners_logos_description_' . $page_slug, 'Trusted by leading organizations across Africa')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_logos_items">Partner Logos (8 logos)</label></th>
                    <td>
                        <textarea id="apex_partners_logos_items" name="apex_partners_logos_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: URL | Name (8 logos)"><?php echo esc_textarea(get_option('apex_partners_logos_items_' . $page_slug, "https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Microsoft_Azure.svg/150px-Microsoft_Azure.svg.png | Microsoft Azure\nhttps://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Amazon_Web_Services_Logo.svg/150px-Amazon_Web_Services_Logo.svg.png | Amazon Web Services\nhttps://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/150px-Visa_Inc._logo.svg.png | Visa\nhttps://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/150px-Mastercard-logo.svg.png | Mastercard\nhttps://upload.wikimedia.org/wikipedia/commons/1/15/M-PESA_LOGO-01.svg | M-Pesa (Safaricom)\nhttps://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Oracle_logo.svg/150px-Oracle_logo.svg.png | Oracle\nhttps://upload.wikimedia.org/wikipedia/commons/thumb/5/51/IBM_logo.svg/150px-IBM_logo.svg.png | IBM\nhttps://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Google_Cloud_logo.svg/150px-Google_Cloud_logo.svg.png | Google Cloud")); ?></textarea>
                        <p class="description">Enter 8 partner logos. Format per line: <code>Image URL | Partner Name</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Testimonial Section -->
        <div style="margin-bottom: 30px;">
            <h4>💬 Testimonial Section</h4>
            <div style="background: #fce4ec; padding: 15px; margin-bottom: 20px; border: 1px solid #e91e63; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the partner success story testimonial.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_partners_testimonial_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_partners_testimonial_badge" name="apex_partners_testimonial_badge" 
                               value="<?php echo esc_attr(get_option('apex_partners_testimonial_badge_' . $page_slug, 'Partner Success Story')); ?>" 
                               class="regular-text" placeholder="e.g., Partner Success Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_testimonial_heading">Heading</label></th>
                    <td>
                        <input type="text" id="apex_partners_testimonial_heading" name="apex_partners_testimonial_heading" 
                               value="<?php echo esc_attr(get_option('apex_partners_testimonial_heading_' . $page_slug, 'How TechCorp Africa Grew Revenue by 300%')); ?>" 
                               class="large-text" placeholder="Enter the testimonial heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_testimonial_quote">Testimonial Quote</label></th>
                    <td>
                        <textarea id="apex_partners_testimonial_quote" name="apex_partners_testimonial_quote" 
                                  class="large-text" rows="4" 
                                  placeholder="Enter the testimonial quote"><?php echo esc_textarea(get_option('apex_partners_testimonial_quote_' . $page_slug, '"Partnering with Apex has been transformative for our business. Their comprehensive solutions, excellent support, and attractive revenue model helped us expand our client base and triple our revenue in just two years."')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_testimonial_author_name">Author Name</label></th>
                    <td>
                        <input type="text" id="apex_partners_testimonial_author_name" name="apex_partners_testimonial_author_name" 
                               value="<?php echo esc_attr(get_option('apex_partners_testimonial_author_name_' . $page_slug, 'John Kamau')); ?>" 
                               class="large-text" placeholder="Enter the author name">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_testimonial_author_title">Author Title</label></th>
                    <td>
                        <input type="text" id="apex_partners_testimonial_author_title" name="apex_partners_testimonial_author_title" 
                               value="<?php echo esc_attr(get_option('apex_partners_testimonial_author_title_' . $page_slug, 'CEO, TechCorp Africa')); ?>" 
                               class="large-text" placeholder="Enter the author title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_partners_testimonial_author_image">Author Image URL</label></th>
                    <td>
                        <input type="url" id="apex_partners_testimonial_author_image" name="apex_partners_testimonial_author_image" 
                               value="<?php echo esc_url(get_option('apex_partners_testimonial_author_image_' . $page_slug, 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100')); ?>" 
                               class="large-text" placeholder="https://example.com/author.jpg">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'developers'): ?>
        <!-- Developers Page Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_dev_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_dev_hero_badge" name="apex_dev_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_dev_hero_badge_' . $page_slug, 'Developers')); ?>" 
                               class="regular-text" placeholder="e.g., Developers">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_dev_hero_heading" name="apex_dev_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_dev_hero_heading_' . $page_slug, 'Build with Our APIs')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_dev_hero_description" name="apex_dev_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_dev_hero_description_' . $page_slug, 'Integrate our powerful APIs to build custom solutions. Comprehensive documentation, SDKs, and developer tools to help you succeed.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_dev_hero_image" name="apex_dev_hero_image" 
                               value="<?php echo esc_url(get_option('apex_dev_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_dev_hero_stats" name="apex_dev_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_dev_hero_stats_' . $page_slug, "50+ | API Endpoints\n5 | SDKs Available\n99.9% | Uptime SLA\n24/7 | API Support")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | API Endpoints</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- APIs Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔌 Our APIs Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 6 API cards displayed.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_dev_apis_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_dev_apis_heading" name="apex_dev_apis_heading" 
                               value="<?php echo esc_attr(get_option('apex_dev_apis_heading_' . $page_slug, 'Our APIs')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_apis_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_dev_apis_description" name="apex_dev_apis_description" 
                               value="<?php echo esc_attr(get_option('apex_dev_apis_description_' . $page_slug, 'RESTful APIs designed for developers')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_apis_items">API Items (6 items)</label></th>
                    <td>
                        <textarea id="apex_dev_apis_items" name="apex_dev_apis_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description (6 items)"><?php echo esc_textarea(get_option('apex_dev_apis_items_' . $page_slug, "Core Banking API | Full access to core banking functionality including accounts, transactions, loans, and customer management.\nMobile Banking API | Build custom mobile apps with our comprehensive mobile banking API for iOS and Android.\nAgent Banking API | Manage agent networks, process transactions, and monitor agent performance programmatically.\nAuthentication API | Secure authentication and authorization with OAuth 2.0 and JWT token support.\nWebhooks API | Subscribe to real-time events and build automated workflows with our webhook system.\nReports API | Generate custom reports, export data, and access analytics programmatically.")); ?></textarea>
                        <p class="description">Enter 6 APIs. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- SDKs Section -->
        <div style="margin-bottom: 30px;">
            <h4>📦 Official SDKs Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 5 SDK cards displayed.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_dev_sdks_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_dev_sdks_heading" name="apex_dev_sdks_heading" 
                               value="<?php echo esc_attr(get_option('apex_dev_sdks_heading_' . $page_slug, 'Official SDKs')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_sdks_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_dev_sdks_description" name="apex_dev_sdks_description" 
                               value="<?php echo esc_attr(get_option('apex_dev_sdks_description_' . $page_slug, 'Get started quickly with our official SDKs')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_sdks_items">SDK Items (5 items)</label></th>
                    <td>
                        <textarea id="apex_dev_sdks_items" name="apex_dev_sdks_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description | Install Command (5 items)"><?php echo esc_textarea(get_option('apex_dev_sdks_items_' . $page_slug, "JavaScript SDK | For web applications and Node.js backend development | npm install @apex-softwares/sdk\nPython SDK | For Python applications and Django integration | pip install apex-softwares-sdk\nPHP SDK | For PHP applications and Laravel integration | composer require apex-softwares/sdk\nJava SDK | For Java applications and Spring Boot integration | implementation 'com.apex:sdk'\nGo SDK | For Go applications and microservices | go get github.com/apex-softwares/sdk")); ?></textarea>
                        <p class="description">Enter 5 SDKs. Format per line: <code>Title | Description | Install Command</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Quick Start Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Quick Start Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the quick start steps and code example.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_dev_quick_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_dev_quick_heading" name="apex_dev_quick_heading" 
                               value="<?php echo esc_attr(get_option('apex_dev_quick_heading_' . $page_slug, 'Quick Start')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_quick_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_dev_quick_description" name="apex_dev_quick_description" 
                               value="<?php echo esc_attr(get_option('apex_dev_quick_description_' . $page_slug, 'Get up and running in minutes')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_quick_steps">Quick Start Steps (4 steps)</label></th>
                    <td>
                        <textarea id="apex_dev_quick_steps" name="apex_dev_quick_steps" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description (4 steps)"><?php echo esc_textarea(get_option('apex_dev_quick_steps_' . $page_slug, "Create an Account | Sign up for a developer account to get your API credentials\nGet Your API Keys | Generate API keys from your developer dashboard\nInstall an SDK | Install our SDK for your preferred programming language\nMake Your First Call | Start making API calls with our quick start examples")); ?></textarea>
                        <p class="description">Enter 4 steps. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_quick_code">Code Example</label></th>
                    <td>
                        <textarea id="apex_dev_quick_code" name="apex_dev_quick_code" 
                                  class="large-text" rows="12" 
                                  placeholder="Enter the code example"><?php echo esc_textarea(get_option('apex_dev_quick_code_' . $page_slug, "// Install SDK\nnpm install @apex-softwares/sdk\n\n// Initialize\nconst Apex = require('@apex-softwares/sdk');\nconst client = new Apex({\n  apiKey: 'your-api-key',\n  environment: 'sandbox'\n});\n\n// Make your first call\nconst accounts = await client.accounts.list();\nconsole.log(accounts);")); ?></textarea>
                        <p class="description">Enter the code example shown in the Quick Start section</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Developer Support Section -->
        <div style="margin-bottom: 30px;">
            <h4>🛠️ Developer Support Section</h4>
            <div style="background: #e0f2f1; padding: 15px; margin-bottom: 20px; border: 1px solid #009688; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 4 developer support cards.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_dev_support_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_dev_support_heading" name="apex_dev_support_heading" 
                               value="<?php echo esc_attr(get_option('apex_dev_support_heading_' . $page_slug, 'Developer Support')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_support_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_dev_support_description" name="apex_dev_support_description" 
                               value="<?php echo esc_attr(get_option('apex_dev_support_description_' . $page_slug, "We're here to help you succeed")); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_dev_support_items">Support Items (4 items)</label></th>
                    <td>
                        <textarea id="apex_dev_support_items" name="apex_dev_support_items" 
                                  class="large-text" rows="8" 
                                  placeholder="Format: Title | Description | Link Text (4 items)"><?php echo esc_textarea(get_option('apex_dev_support_items_' . $page_slug, "Documentation | Comprehensive API documentation with examples and use cases | Read Docs →\nCommunity Forum | Connect with other developers and share solutions | Join Forum →\nGitHub | Open source SDKs, examples, and integration templates | View on GitHub →\nContact Support | Direct access to our developer support team | Get Help →")); ?></textarea>
                        <p class="description">Enter 4 support items. Format per line: <code>Title | Description | Link Text</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'knowledge-base'): ?>
        <!-- Knowledge Base Page Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_kb_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_kb_hero_badge" name="apex_kb_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_kb_hero_badge_' . $page_slug, 'Knowledge Base')); ?>" 
                               class="regular-text" placeholder="e.g., Knowledge Base">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_kb_hero_heading" name="apex_kb_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_kb_hero_heading_' . $page_slug, 'Comprehensive Documentation & Guides')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_kb_hero_description" name="apex_kb_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_kb_hero_description_' . $page_slug, 'Find detailed guides, tutorials, and documentation to help you get the most out of our products.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_kb_hero_image" name="apex_kb_hero_image" 
                               value="<?php echo esc_url(get_option('apex_kb_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_kb_hero_stats" name="apex_kb_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_kb_hero_stats_' . $page_slug, "200+ | Articles\n50+ | Video Tutorials\n100% | Searchable\n24/7 | Access")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>200+ | Articles</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Search Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔍 Search Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the search form and popular searches.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_kb_search_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_kb_search_heading" name="apex_kb_search_heading" 
                               value="<?php echo esc_attr(get_option('apex_kb_search_heading_' . $page_slug, 'Search Our Knowledge Base')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_search_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_kb_search_description" name="apex_kb_search_description" 
                               value="<?php echo esc_attr(get_option('apex_kb_search_description_' . $page_slug, 'Find answers to your questions quickly')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_search_placeholder">Search Input Placeholder</label></th>
                    <td>
                        <input type="text" id="apex_kb_search_placeholder" name="apex_kb_search_placeholder" 
                               value="<?php echo esc_attr(get_option('apex_kb_search_placeholder_' . $page_slug, 'Search for articles, guides, tutorials...')); ?>" 
                               class="large-text" placeholder="Enter placeholder text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_search_button">Search Button Text</label></th>
                    <td>
                        <input type="text" id="apex_kb_search_button" name="apex_kb_search_button" 
                               value="<?php echo esc_attr(get_option('apex_kb_search_button_' . $page_slug, 'Search')); ?>" 
                               class="regular-text" placeholder="Enter button text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_search_suggestions">Popular Searches (4 items)</label></th>
                    <td>
                        <textarea id="apex_kb_search_suggestions" name="apex_kb_search_suggestions" 
                                  class="large-text" rows="5" 
                                  placeholder="Enter 4 popular search terms, one per line"><?php echo esc_textarea(get_option('apex_kb_search_suggestions_' . $page_slug, "Getting started\nMobile banking setup\nAPI integration\nSecurity settings")); ?></textarea>
                        <p class="description">Enter 4 popular search terms, one per line</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Categories Section -->
        <div style="margin-bottom: 30px;">
            <h4>📁 Categories Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 8 category cards displayed.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_kb_categories_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_kb_categories_heading" name="apex_kb_categories_heading" 
                               value="<?php echo esc_attr(get_option('apex_kb_categories_heading_' . $page_slug, 'Browse by Category')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_categories_items">Category Items (8 items)</label></th>
                    <td>
                        <textarea id="apex_kb_categories_items" name="apex_kb_categories_items" 
                                  class="large-text" rows="16" 
                                  placeholder="Format: Title | Description | Article Count (8 items)"><?php echo esc_textarea(get_option('apex_kb_categories_items_' . $page_slug, "Getting Started | Quick start guides and onboarding documentation | 25 articles\nCore Banking | Comprehensive guides for ApexCore platform | 45 articles\nMobile Banking | Mobile app setup and configuration guides | 38 articles\nAgent Banking | Agent network setup and management | 22 articles\nSecurity | Security configuration and best practices | 18 articles\nIntegrations | API documentation and integration guides | 32 articles\nReports | Reporting and analytics configuration | 15 articles\nBilling | Account management and billing guides | 8 articles")); ?></textarea>
                        <p class="description">Enter 8 categories. Format per line: <code>Title | Description | Article Count</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Popular Articles Section -->
        <div style="margin-bottom: 30px;">
            <h4>📄 Popular Articles Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 6 popular article items displayed.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_kb_articles_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_kb_articles_heading" name="apex_kb_articles_heading" 
                               value="<?php echo esc_attr(get_option('apex_kb_articles_heading_' . $page_slug, 'Popular Articles')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_articles_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_kb_articles_description" name="apex_kb_articles_description" 
                               value="<?php echo esc_attr(get_option('apex_kb_articles_description_' . $page_slug, 'Most viewed articles this week')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_articles_items">Article Items (6 items)</label></th>
                    <td>
                        <textarea id="apex_kb_articles_items" name="apex_kb_articles_items" 
                                  class="large-text" rows="14" 
                                  placeholder="Format: Title | Description | Category | Read Time (6 items)"><?php echo esc_textarea(get_option('apex_kb_articles_items_' . $page_slug, "Getting Started with ApexCore | A comprehensive guide to setting up your core banking platform | Getting Started • 15 min read\nConfiguring Mobile Banking App | Step-by-step guide to customize your mobile banking experience | Mobile Banking • 12 min read\nSecurity Best Practices | Essential security configurations for your platform | Security • 10 min read\nAPI Integration Guide | How to integrate your systems with our APIs | Integrations • 20 min read\nSetting Up Agent Banking | Complete guide to deploying your agent network | Agent Banking • 18 min read\nCreating Custom Reports | Build custom reports to meet your regulatory requirements | Reports • 14 min read")); ?></textarea>
                        <p class="description">Enter 6 articles. Format per line: <code>Title | Description | Category • Read Time</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Video Tutorials Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎥 Video Tutorials Section</h4>
            <div style="background: #e0f2f1; padding: 15px; margin-bottom: 20px; border: 1px solid #009688; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the 4 video tutorial items displayed.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_kb_videos_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_kb_videos_heading" name="apex_kb_videos_heading" 
                               value="<?php echo esc_attr(get_option('apex_kb_videos_heading_' . $page_slug, 'Video Tutorials')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_videos_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_kb_videos_description" name="apex_kb_videos_description" 
                               value="<?php echo esc_attr(get_option('apex_kb_videos_description_' . $page_slug, 'Learn visually with our video guides')); ?>" 
                               class="large-text" placeholder="Enter the section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_kb_videos_items">Video Items (4 items)</label></th>
                    <td>
                        <textarea id="apex_kb_videos_items" name="apex_kb_videos_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Duration | Thumbnail URL (4 items)"><?php echo esc_textarea(get_option('apex_kb_videos_items_' . $page_slug, "Platform Overview | 5:32 | https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400\nUser Management | 8:15 | https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400\nProduct Configuration | 12:45 | https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400\nReporting Dashboard | 6:20 | https://images.unsplash.com/photo-1551434678-e076c223a692?w=400")); ?></textarea>
                        <p class="description">Enter 4 videos. Format per line: <code>Title | Duration | Thumbnail URL</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'faq'): ?>
        <!-- FAQ Page Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_faq_hero_badge" name="apex_faq_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_faq_hero_badge_' . $page_slug, 'FAQ')); ?>" 
                               class="regular-text" placeholder="e.g., FAQ">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_faq_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_faq_hero_heading" name="apex_faq_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_faq_hero_heading_' . $page_slug, 'Frequently Asked Questions')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_faq_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_faq_hero_description" name="apex_faq_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_faq_hero_description_' . $page_slug, 'Find answers to common questions about our products, services, and company.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_faq_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_faq_hero_image" name="apex_faq_hero_image" 
                               value="<?php echo esc_url(get_option('apex_faq_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_faq_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_faq_hero_stats" name="apex_faq_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_faq_hero_stats_' . $page_slug, "50+ | Questions Answered\n24/7 | Support Available\n5min | Avg. Read Time\n100% | Coverage")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | Questions Answered</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- General Questions Section -->
        <div style="margin-bottom: 30px;">
            <h4>❓ General Questions (4 items)</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the General Questions FAQ items.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_general_items">General FAQ Items</label></th>
                    <td>
                        <textarea id="apex_faq_general_items" name="apex_faq_general_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Question | Answer (4 items)"><?php echo esc_textarea(get_option('apex_faq_general_items_' . $page_slug, "What is Apex Softwares? | Apex Softwares is a leading African fintech company providing core banking, mobile banking, and financial technology solutions to financial institutions across 15+ African countries. We help SACCOs, MFIs, and commercial banks modernize their operations and reach more customers.\nWhich countries do you operate in? | We currently operate in Kenya, Uganda, Tanzania, Nigeria, Ghana, Rwanda, South Africa, and 8 other African countries. We're continuously expanding our presence across the continent.\nHow long have you been in business? | Apex Softwares was founded in 2010. We have over 14 years of experience serving financial institutions across Africa, with a proven track record of successful implementations and satisfied clients.\nHow do I get started with Apex? | Getting started is easy! Simply contact our sales team to schedule a demo. We'll discuss your specific needs and provide a customized proposal. Implementation typically takes 3-6 months depending on the scope of the project.")); ?></textarea>
                        <p class="description">Enter 4 FAQ items. Format per line: <code>Question | Answer</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Products & Services Section -->
        <div style="margin-bottom: 30px;">
            <h4>🛠️ Products & Services (4 items)</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the Products & Services FAQ items.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_products_items">Products & Services FAQ Items</label></th>
                    <td>
                        <textarea id="apex_faq_products_items" name="apex_faq_products_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Question | Answer (4 items)"><?php echo esc_textarea(get_option('apex_faq_products_items_' . $page_slug, "What products do you offer? | We offer a comprehensive suite of financial technology solutions including: Core Banking (ApexCore), Mobile Banking, Agent Banking, Internet Banking, Payment Switch, Loan Origination, Digital Field Agent, and Enterprise Integration platforms.\nCan your solutions integrate with existing systems? | Yes! Our solutions are designed with integration in mind. We support standard APIs and can build custom integrations with your existing core banking, payment, and third-party systems. Our enterprise integration platform handles complex integration scenarios.\nDo you offer cloud or on-premise deployment? | We offer both cloud and on-premise deployment options. Cloud deployment offers faster implementation and lower upfront costs, while on-premise gives you complete control over your infrastructure. We'll help you choose the best option for your needs.\nWhat about mobile app support? | Our mobile banking apps work on both iOS and Android. We also offer USSD banking for feature phones and offline-first design that works in low-connectivity areas common in rural Africa.")); ?></textarea>
                        <p class="description">Enter 4 FAQ items. Format per line: <code>Question | Answer</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Pricing Section -->
        <div style="margin-bottom: 30px;">
            <h4>💰 Pricing (4 items)</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the Pricing FAQ items.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_pricing_items">Pricing FAQ Items</label></th>
                    <td>
                        <textarea id="apex_faq_pricing_items" name="apex_faq_pricing_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Question | Answer (4 items)"><?php echo esc_textarea(get_option('apex_faq_pricing_items_' . $page_slug, "How is your pricing structured? | We offer flexible pricing models including licensing, subscription, and transaction-based options. Pricing depends on the products you need, your institution size, and deployment preference. Contact our sales team for a customized quote.\nAre there any hidden fees? | No, we believe in transparent pricing. All fees are clearly outlined in your proposal and contract. There are no hidden charges or surprise fees.\nWhat's included in the pricing? | Our pricing includes software licenses, implementation, training, ongoing support, and regular updates. We also provide access to our knowledge base, documentation, and customer portal.\nDo you offer discounts for smaller institutions? | Yes! We have special pricing for smaller institutions and startups. Our modular approach allows you to start with what you need and add capabilities as you grow.")); ?></textarea>
                        <p class="description">Enter 4 FAQ items. Format per line: <code>Question | Answer</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Technical Support Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔧 Technical Support (4 items)</h4>
            <div style="background: #e0f2f1; padding: 15px; margin-bottom: 20px; border: 1px solid #009688; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the Technical Support FAQ items.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_technical_items">Technical Support FAQ Items</label></th>
                    <td>
                        <textarea id="apex_faq_technical_items" name="apex_faq_technical_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Question | Answer (4 items)"><?php echo esc_textarea(get_option('apex_faq_technical_items_' . $page_slug, "What support options do you offer? | We offer 24/7 support for critical issues, business hours support for non-critical issues, and dedicated account managers for enterprise clients. Support is available via phone, email, live chat, and our customer portal.\nWhat's your response time? | We respond to all support inquiries within 2 hours during business hours. Critical issues are addressed immediately with 24/7 availability. Our average resolution time is under 4 hours for most issues.\nDo you provide training? | Yes! We provide comprehensive training during implementation including hands-on sessions, documentation, and train-the-trainer programs. We also offer ongoing training sessions and webinars.\nHow do you handle software updates? | We regularly release updates with new features, improvements, and security patches. Updates are included in your subscription and can be scheduled at your convenience. We provide advance notice for major releases.")); ?></textarea>
                        <p class="description">Enter 4 FAQ items. Format per line: <code>Question | Answer</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Security Section -->
        <div style="margin-bottom: 30px;">
            <h4>🔒 Security (4 items)</h4>
            <div style="background: #ffebee; padding: 15px; margin-bottom: 20px; border: 1px solid #f44336; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the Security FAQ items.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_security_items">Security FAQ Items</label></th>
                    <td>
                        <textarea id="apex_faq_security_items" name="apex_faq_security_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Question | Answer (4 items)"><?php echo esc_textarea(get_option('apex_faq_security_items_' . $page_slug, "How secure is your platform? | Security is our top priority. We use industry-standard encryption, regular security audits, penetration testing, and comply with Central Bank regulations across all our operating countries. Our platform is ISO 27001 certified.\nWhere is my data stored? | Data storage location depends on your deployment preference. For cloud deployments, we offer data residency options within Africa. We comply with all local data protection regulations including GDPR where applicable.\nWhat happens in case of a security incident? | We have a comprehensive incident response plan. In case of a security incident, we will notify affected parties within 24 hours, provide regular updates, and work with regulatory authorities as required. We maintain cyber insurance for additional protection.\nDo you offer disaster recovery? | Yes, we offer comprehensive disaster recovery with automated backups, geo-redundancy, and business continuity planning. Our cloud platform offers 99.99% uptime SLA.")); ?></textarea>
                        <p class="description">Enter 4 FAQ items. Format per line: <code>Question | Answer</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Billing Section -->
        <div style="margin-bottom: 30px;">
            <h4>💳 Billing (4 items)</h4>
            <div style="background: #e3f2fd; padding: 15px; margin-bottom: 20px; border: 1px solid #2196f3; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the Billing FAQ items.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_faq_billing_items">Billing FAQ Items</label></th>
                    <td>
                        <textarea id="apex_faq_billing_items" name="apex_faq_billing_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Question | Answer (4 items)"><?php echo esc_textarea(get_option('apex_faq_billing_items_' . $page_slug, "What payment methods do you accept? | We accept bank transfers, mobile money (M-Pesa, Airtel Money), and international wire transfers. For enterprise clients, we can set up net-30 payment terms.\nWhen are invoices sent? | Invoices are sent monthly for subscription-based pricing and upon project milestones for implementation projects. All invoices include detailed breakdown of charges.\nCan I cancel my subscription? | Yes, you can cancel your subscription with 30 days notice. We'll help you export your data and ensure a smooth transition. Early termination fees may apply depending on your contract terms.\nWhat's your refund policy? | Refunds are handled on a case-by-case basis. If you're not satisfied with our service, please contact our customer success team and we'll work to resolve any issues.")); ?></textarea>
                        <p class="description">Enter 4 FAQ items. Format per line: <code>Question | Answer</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'help-support'): ?>
        <!-- Help & Support Page Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_support_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_support_hero_badge" name="apex_support_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_support_hero_badge_' . $page_slug, 'Help & Support')); ?>" 
                               class="regular-text" placeholder="e.g., Help & Support">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_support_hero_heading" name="apex_support_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_support_hero_heading_' . $page_slug, "We're Here to Help")); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_support_hero_description" name="apex_support_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_support_hero_description_' . $page_slug, 'Get the support you need with our comprehensive help resources and dedicated support team available 24/7.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_support_hero_image" name="apex_support_hero_image" 
                               value="<?php echo esc_url(get_option('apex_support_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_support_hero_stats" name="apex_support_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_support_hero_stats_' . $page_slug, "24/7 | Support Available\n<2hrs | Response Time\n99.9% | Satisfaction\n15+ | Countries")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>24/7 | Support Available</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Support Channels Section -->
        <div style="margin-bottom: 30px;">
            <h4>📞 Support Channels (4 items)</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the support channels grid with icons, titles, descriptions, and links.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_support_channels_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_support_channels_heading" name="apex_support_channels_heading" 
                               value="<?php echo esc_attr(get_option('apex_support_channels_heading_' . $page_slug, 'How Can We Help?')); ?>" 
                               class="large-text" placeholder="e.g., How Can We Help?">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_channels_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_support_channels_description" name="apex_support_channels_description" 
                               value="<?php echo esc_attr(get_option('apex_support_channels_description_' . $page_slug, 'Choose the support channel that works best for you')); ?>" 
                               class="large-text" placeholder="Enter section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_channels_items">Support Channel Items</label></th>
                    <td>
                        <textarea id="apex_support_channels_items" name="apex_support_channels_items" 
                                  class="large-text" rows="12" 
                                  placeholder="Format: Title | Description | Link Text | URL | Icon (4 items)"><?php echo esc_textarea(get_option('apex_support_channels_items_' . $page_slug, "Knowledge Base | Find answers in our comprehensive documentation and guides. | Browse Articles → | #knowledge-base | book\nFAQ | Quick answers to common questions about our products and services. | View FAQ → | #faq | help-circle\nContact Support | Get personalized help from our support team via phone, email, or chat. | Contact Us → | #contact | phone\nDeveloper Resources | API documentation, SDKs, and integration guides for developers. | Explore APIs → | #developers | code")); ?></textarea>
                        <p class="description">Enter 4 support channels. Format per line: <code>Title | Description | Link Text | URL | Icon</code>. Icons: book, help-circle, phone, code, mail, message-circle, file-text</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Contact Section -->
        <div style="margin-bottom: 30px;">
            <h4>📧 Contact Methods (3 items)</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the contact methods with phone, email, and live chat.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_support_contact_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_support_contact_heading" name="apex_support_contact_heading" 
                               value="<?php echo esc_attr(get_option('apex_support_contact_heading_' . $page_slug, 'Contact Our Support Team')); ?>" 
                               class="large-text" placeholder="e.g., Contact Our Support Team">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_contact_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_support_contact_description" name="apex_support_contact_description" 
                               value="<?php echo esc_attr(get_option('apex_support_contact_description_' . $page_slug, "We're here to help you succeed")); ?>" 
                               class="large-text" placeholder="Enter section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_contact_items">Contact Items</label></th>
                    <td>
                        <textarea id="apex_support_contact_items" name="apex_support_contact_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description | Contact Value | Hours | Icon | Type (3 items)"><?php echo esc_textarea(get_option('apex_support_contact_items_' . $page_slug, "Phone Support | Speak directly with our support team | +254 700 000 000 | 24/7 for critical issues | phone | tel\nEmail Support | Send us your questions and we'll respond within 2 hours | support@apex-softwares.com | Response time: <2 hours | mail | mailto\nLive Chat | Chat with our support team in real-time | Start Live Chat | Available 24/7 | message-circle | button")); ?></textarea>
                        <p class="description">Enter 3 contact methods. Format per line: <code>Title | Description | Contact Value | Hours | Icon | Type</code>. Type: tel, mailto, button</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Popular Resources Section -->
        <div style="margin-bottom: 30px;">
            <h4>📚 Popular Resources (4 items)</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the popular resources grid.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_support_resources_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_support_resources_heading" name="apex_support_resources_heading" 
                               value="<?php echo esc_attr(get_option('apex_support_resources_heading_' . $page_slug, 'Popular Resources')); ?>" 
                               class="large-text" placeholder="e.g., Popular Resources">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_resources_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_support_resources_description" name="apex_support_resources_description" 
                               value="<?php echo esc_attr(get_option('apex_support_resources_description_' . $page_slug, 'Quick access to our most helpful resources')); ?>" 
                               class="large-text" placeholder="Enter section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_support_resources_items">Resource Items</label></th>
                    <td>
                        <textarea id="apex_support_resources_items" name="apex_support_resources_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description | Link Text (4 items)"><?php echo esc_textarea(get_option('apex_support_resources_items_' . $page_slug, "Getting Started Guide | Learn the basics of using our platform with our step-by-step guide. | Read Guide →\nVideo Tutorials | Watch our video tutorials to learn how to use specific features. | Watch Videos →\nSystem Status | Check the current status of all our services and any ongoing incidents. | Check Status →\nRelease Notes | Stay updated with the latest features and improvements. | View Updates →")); ?></textarea>
                        <p class="description">Enter 4 resources. Format per line: <code>Title | Description | Link Text</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'careers'): ?>
        <!-- Careers Page Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_careers_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_careers_hero_badge" name="apex_careers_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_careers_hero_badge_' . $page_slug, 'Join Our Team')); ?>" 
                               class="regular-text" placeholder="e.g., Join Our Team">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_careers_hero_heading" name="apex_careers_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_careers_hero_heading_' . $page_slug, 'Build the Future of African Fintech')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_careers_hero_description" name="apex_careers_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_careers_hero_description_' . $page_slug, "Join a team of passionate innovators transforming financial services across Africa. We're looking for talented individuals who want to make an impact.")); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_careers_hero_image" name="apex_careers_hero_image" 
                               value="<?php echo esc_url(get_option('apex_careers_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_careers_hero_stats" name="apex_careers_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_careers_hero_stats_' . $page_slug, "50+ | Team Members\n15+ | Countries\n4.5/5 | Glassdoor Rating\n100% | Remote Options")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | Team Members</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Why Work at Apex Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Why Work at Apex? (4 items)</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the benefits grid with icons and descriptions.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_careers_why_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_careers_why_heading" name="apex_careers_why_heading" 
                               value="<?php echo esc_attr(get_option('apex_careers_why_heading_' . $page_slug, 'Why Work at Apex?')); ?>" 
                               class="large-text" placeholder="e.g., Why Work at Apex?">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_why_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_careers_why_description" name="apex_careers_why_description" 
                               value="<?php echo esc_attr(get_option('apex_careers_why_description_' . $page_slug, "We're not just building software—we're building the future of financial services in Africa.")); ?>" 
                               class="large-text" placeholder="Enter section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_why_items">Benefits Items</label></th>
                    <td>
                        <textarea id="apex_careers_why_items" name="apex_careers_why_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description | Icon (4 items)"><?php echo esc_textarea(get_option('apex_careers_why_items_' . $page_slug, "Impactful Work | Build solutions that help millions access financial services and improve lives across Africa. | shield\nGlobal Impact | Work with clients across 15+ African countries and see your work make a real difference. | globe\nGrowth & Learning | Continuous learning opportunities, mentorship, and career growth paths. | users\nCompetitive Benefits | Competitive salary, equity, health insurance, and flexible work arrangements. | check-shield")); ?></textarea>
                        <p class="description">Enter 4 benefit items. Format per line: <code>Title | Description | Icon</code>. Icons: shield, globe, users, check-shield, heart, star, award, briefcase</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Open Positions Section -->
        <div style="margin-bottom: 30px;">
            <h4>💼 Open Positions (4 items)</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the job listings with location, type, and tags.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_careers_openings_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_careers_openings_heading" name="apex_careers_openings_heading" 
                               value="<?php echo esc_attr(get_option('apex_careers_openings_heading_' . $page_slug, 'Open Positions')); ?>" 
                               class="large-text" placeholder="e.g., Open Positions">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_openings_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_careers_openings_description" name="apex_careers_openings_description" 
                               value="<?php echo esc_attr(get_option('apex_careers_openings_description_' . $page_slug, 'Find your next opportunity')); ?>" 
                               class="large-text" placeholder="Enter section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_openings_items">Job Listings</label></th>
                    <td>
                        <textarea id="apex_careers_openings_items" name="apex_careers_openings_items" 
                                  class="large-text" rows="16" 
                                  placeholder="Format: Title | Location | Type | Description | Tags (comma-separated) (4 items)"><?php echo esc_textarea(get_option('apex_careers_openings_items_' . $page_slug, "Senior Full-Stack Developer | Nairobi, Kenya (Remote) | Full-time | We're looking for an experienced developer to help build our next-generation core banking platform. | PHP, React, PostgreSQL\nMobile Developer (iOS/Android) | Lagos, Nigeria (Remote) | Full-time | Build beautiful mobile banking experiences that work even in low-connectivity areas. | React Native, TypeScript, Mobile\nProduct Manager | Nairobi, Kenya | Full-time | Drive product strategy and work with cross-functional teams to deliver exceptional fintech products. | Product, Strategy, Agile\nDevOps Engineer | Remote | Full-time | Build and maintain our cloud infrastructure ensuring 99.99% uptime for critical banking systems. | AWS, Kubernetes, CI/CD")); ?></textarea>
                        <p class="description">Enter 4 job listings. Format per line: <code>Title | Location | Type | Description | Tags</code> (Tags comma-separated)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Our Culture Section -->
        <div style="margin-bottom: 30px;">
            <h4>🌟 Our Culture (4 items)</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the culture values grid.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_careers_culture_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_careers_culture_heading" name="apex_careers_culture_heading" 
                               value="<?php echo esc_attr(get_option('apex_careers_culture_heading_' . $page_slug, 'Our Culture')); ?>" 
                               class="large-text" placeholder="e.g., Our Culture">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_culture_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_careers_culture_description" name="apex_careers_culture_description" 
                               value="<?php echo esc_attr(get_option('apex_careers_culture_description_' . $page_slug, 'We believe in creating an environment where everyone can thrive')); ?>" 
                               class="large-text" placeholder="Enter section description">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_careers_culture_items">Culture Values</label></th>
                    <td>
                        <textarea id="apex_careers_culture_items" name="apex_careers_culture_items" 
                                  class="large-text" rows="10" 
                                  placeholder="Format: Title | Description (4 items)"><?php echo esc_textarea(get_option('apex_careers_culture_items_' . $page_slug, "Diversity & Inclusion | We celebrate diverse backgrounds and perspectives. Our team represents 10+ African countries.\nWork-Life Balance | Flexible hours, remote work options, and generous time off policies.\nContinuous Learning | Learning budget, conference attendance, and internal knowledge sharing sessions.\nTransparency | Open communication, regular town halls, and access to leadership.")); ?></textarea>
                        <p class="description">Enter 4 culture values. Format per line: <code>Title | Description</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'insights-webinars'): ?>
        <!-- Insights Webinars Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_hero_badge" name="apex_webinars_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_webinars_hero_badge_' . $page_slug, 'Webinars & Events')); ?>" 
                               class="regular-text" placeholder="e.g., Webinars & Events">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_webinars_hero_heading" name="apex_webinars_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_webinars_hero_heading_' . $page_slug, 'Learn from Industry Experts')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_webinars_hero_description" name="apex_webinars_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_webinars_hero_description_' . $page_slug, 'Join our webinars, workshops, and events to stay ahead of the curve in financial technology. Connect with peers and learn from industry leaders.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_webinars_hero_image" name="apex_webinars_hero_image" 
                               value="<?php echo esc_url(get_option('apex_webinars_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_webinars_hero_stats" name="apex_webinars_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_webinars_hero_stats_' . $page_slug, "50+ | Webinars Hosted\n10K+ | Attendees\n25+ | Expert Speakers\n12 | Annual Events")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>50+ | Webinars Hosted</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Upcoming Events Section -->
        <div style="margin-bottom: 30px;">
            <h4>📅 Upcoming Events Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the upcoming events header and the featured webinar.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_upcoming_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_upcoming_badge" name="apex_webinars_upcoming_badge" 
                               value="<?php echo esc_attr(get_option('apex_webinars_upcoming_badge_' . $page_slug, 'Upcoming Events')); ?>" 
                               class="regular-text" placeholder="e.g., Upcoming Events">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_upcoming_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_webinars_upcoming_heading" name="apex_webinars_upcoming_heading" 
                               value="<?php echo esc_attr(get_option('apex_webinars_upcoming_heading_' . $page_slug, "Don't Miss Out")); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_upcoming_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_webinars_upcoming_description" name="apex_webinars_upcoming_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_webinars_upcoming_description_' . $page_slug, 'Register for our upcoming webinars and events to learn from industry experts and connect with peers.')); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Featured Webinar Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Featured Webinar</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the featured webinar card.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_badge">Featured Badge</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_badge" name="apex_webinars_featured_badge" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_badge_' . $page_slug, 'Featured Webinar')); ?>" 
                               class="regular-text" placeholder="e.g., Featured Webinar">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_day">Day</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_day" name="apex_webinars_featured_day" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_day_' . $page_slug, '15')); ?>" 
                               class="regular-text" placeholder="e.g., 15">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_month">Month</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_month" name="apex_webinars_featured_month" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_month_' . $page_slug, 'FEB')); ?>" 
                               class="regular-text" placeholder="e.g., FEB">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_type">Type</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_type" name="apex_webinars_featured_type" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_type_' . $page_slug, 'Live Webinar')); ?>" 
                               class="regular-text" placeholder="e.g., Live Webinar">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_title">Title</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_title" name="apex_webinars_featured_title" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_title_' . $page_slug, 'The Future of Core Banking: Cloud-Native Architecture in 2026')); ?>" 
                               class="large-text" placeholder="Enter the webinar title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_description">Description</label></th>
                    <td>
                        <textarea id="apex_webinars_featured_description" name="apex_webinars_featured_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the webinar description"><?php echo esc_textarea(get_option('apex_webinars_featured_description_' . $page_slug, 'Explore how cloud-native core banking systems are revolutionizing the financial services industry. Learn about scalability, security, and cost benefits.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_time">Time</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_time" name="apex_webinars_featured_time" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_time_' . $page_slug, '2:00 PM EAT')); ?>" 
                               class="regular-text" placeholder="e.g., 2:00 PM EAT">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_duration">Duration</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_duration" name="apex_webinars_featured_duration" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_duration_' . $page_slug, '60 minutes')); ?>" 
                               class="regular-text" placeholder="e.g., 60 minutes">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_speakers">Speakers</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_speakers" name="apex_webinars_featured_speakers" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_speakers_' . $page_slug, 'Sarah Ochieng, John Kamau')); ?>" 
                               class="large-text" placeholder="e.g., Sarah Ochieng, John Kamau">
                        <p class="description">Comma-separated list of speaker names</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_image">Webinar Image URL</label></th>
                    <td>
                        <input type="url" id="apex_webinars_featured_image" name="apex_webinars_featured_image" 
                               value="<?php echo esc_url(get_option('apex_webinars_featured_image_' . $page_slug, 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_featured_link">Registration Link</label></th>
                    <td>
                        <input type="text" id="apex_webinars_featured_link" name="apex_webinars_featured_link" 
                               value="<?php echo esc_attr(get_option('apex_webinars_featured_link_' . $page_slug, '#')); ?>" 
                               class="large-text" placeholder="#">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Conference Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎪 Conference Section</h4>
            <div style="background: #f3e5f5; padding: 15px; margin-bottom: 20px; border: 1px solid #9c27b0; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the annual conference display.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_badge" name="apex_webinars_conf_badge" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_badge_' . $page_slug, 'Annual Conference')); ?>" 
                               class="regular-text" placeholder="e.g., Annual Conference">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_heading">Conference Name</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_heading" name="apex_webinars_conf_heading" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_heading_' . $page_slug, 'Apex Summit 2026')); ?>" 
                               class="large-text" placeholder="Enter conference name">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_description">Description</label></th>
                    <td>
                        <textarea id="apex_webinars_conf_description" name="apex_webinars_conf_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the conference description"><?php echo esc_textarea(get_option('apex_webinars_conf_description_' . $page_slug, 'Join us for our flagship annual conference bringing together 500+ financial technology leaders, innovators, and practitioners from across Africa.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_date">Date</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_date" name="apex_webinars_conf_date" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_date_' . $page_slug, 'June 15-17, 2026')); ?>" 
                               class="regular-text" placeholder="e.g., June 15-17, 2026">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_location">Location</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_location" name="apex_webinars_conf_location" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_location_' . $page_slug, 'Kenyatta International Convention Centre, Nairobi')); ?>" 
                               class="large-text" placeholder="Enter location">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_attendees">Attendees Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_attendees" name="apex_webinars_conf_attendees" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_attendees_' . $page_slug, '500+ Industry Leaders')); ?>" 
                               class="regular-text" placeholder="e.g., 500+ Industry Leaders">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_highlights">Highlights List</label></th>
                    <td>
                        <textarea id="apex_webinars_conf_highlights" name="apex_webinars_conf_highlights" 
                                  class="large-text" rows="6" 
                                  placeholder="Enter one highlight per line"><?php echo esc_textarea(get_option('apex_webinars_conf_highlights_' . $page_slug, "50+ Sessions across 5 tracks\nKeynotes from industry visionaries\nHands-on product workshops\nNetworking events and awards dinner\nExhibition hall with 30+ vendors")); ?></textarea>
                        <p class="description">Enter one highlight per line</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_image">Conference Image URL</label></th>
                    <td>
                        <input type="url" id="apex_webinars_conf_image" name="apex_webinars_conf_image" 
                               value="<?php echo esc_url(get_option('apex_webinars_conf_image_' . $page_slug, 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_register_link">Register Link</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_register_link" name="apex_webinars_conf_register_link" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_register_link_' . $page_slug, '#')); ?>" 
                               class="large-text" placeholder="#">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_conf_agenda_link">Agenda Link</label></th>
                    <td>
                        <input type="text" id="apex_webinars_conf_agenda_link" name="apex_webinars_conf_agenda_link" 
                               value="<?php echo esc_attr(get_option('apex_webinars_conf_agenda_link_' . $page_slug, '#')); ?>" 
                               class="large-text" placeholder="#">
                    </td>
                </tr>
            </table>
        </div>

        <!-- On-Demand Section -->
        <div style="margin-bottom: 30px;">
            <h4>📺 On-Demand Library Section</h4>
            <div style="background: #e3f2fd; padding: 15px; margin-bottom: 20px; border: 1px solid #2196f3; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the on-demand library header.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_ondemand_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_ondemand_badge" name="apex_webinars_ondemand_badge" 
                               value="<?php echo esc_attr(get_option('apex_webinars_ondemand_badge_' . $page_slug, 'On-Demand Library')); ?>" 
                               class="regular-text" placeholder="e.g., On-Demand Library">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_ondemand_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_webinars_ondemand_heading" name="apex_webinars_ondemand_heading" 
                               value="<?php echo esc_attr(get_option('apex_webinars_ondemand_heading_' . $page_slug, 'Watch Anytime')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_ondemand_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_webinars_ondemand_description" name="apex_webinars_ondemand_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_webinars_ondemand_description_' . $page_slug, 'Missed a webinar? Catch up with our library of recorded sessions covering a wide range of topics.')); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Speakers Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎤 Expert Speakers Section</h4>
            <div style="background: #fff8e1; padding: 15px; margin-bottom: 20px; border: 1px solid #ffc107; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the speakers display.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_speakers_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_speakers_badge" name="apex_webinars_speakers_badge" 
                               value="<?php echo esc_attr(get_option('apex_webinars_speakers_badge_' . $page_slug, 'Expert Speakers')); ?>" 
                               class="regular-text" placeholder="e.g., Expert Speakers">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_speakers_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_webinars_speakers_heading" name="apex_webinars_speakers_heading" 
                               value="<?php echo esc_attr(get_option('apex_webinars_speakers_heading_' . $page_slug, 'Learn from the Best')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_speakers_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_webinars_speakers_description" name="apex_webinars_speakers_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_webinars_speakers_description_' . $page_slug, 'Our webinars feature industry experts, thought leaders, and practitioners with deep experience in financial technology.')); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Newsletter Section -->
        <div style="margin-bottom: 30px;">
            <h4>📧 Newsletter Section</h4>
            <div style="background: #fce4ec; padding: 15px; margin-bottom: 20px; border: 1px solid #e91e63; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the newsletter signup form.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_webinars_newsletter_heading">Heading</label></th>
                    <td>
                        <input type="text" id="apex_webinars_newsletter_heading" name="apex_webinars_newsletter_heading" 
                               value="<?php echo esc_attr(get_option('apex_webinars_newsletter_heading_' . $page_slug, 'Never Miss an Event')); ?>" 
                               class="large-text" placeholder="Enter the newsletter heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_newsletter_description">Description</label></th>
                    <td>
                        <textarea id="apex_webinars_newsletter_description" name="apex_webinars_newsletter_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the newsletter description"><?php echo esc_textarea(get_option('apex_webinars_newsletter_description_' . $page_slug, 'Subscribe to get notified about upcoming webinars, workshops, and events.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_newsletter_placeholder">Email Placeholder</label></th>
                    <td>
                        <input type="text" id="apex_webinars_newsletter_placeholder" name="apex_webinars_newsletter_placeholder" 
                               value="<?php echo esc_attr(get_option('apex_webinars_newsletter_placeholder_' . $page_slug, 'Enter your email address')); ?>" 
                               class="large-text" placeholder="e.g., Enter your email address">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_newsletter_button">Button Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_newsletter_button" name="apex_webinars_newsletter_button" 
                               value="<?php echo esc_attr(get_option('apex_webinars_newsletter_button_' . $page_slug, 'Subscribe')); ?>" 
                               class="regular-text" placeholder="e.g., Subscribe">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_webinars_newsletter_note">Note Text</label></th>
                    <td>
                        <input type="text" id="apex_webinars_newsletter_note" name="apex_webinars_newsletter_note" 
                               value="<?php echo esc_attr(get_option('apex_webinars_newsletter_note_' . $page_slug, 'We respect your privacy. Unsubscribe at any time.')); ?>" 
                               class="large-text" placeholder="e.g., We respect your privacy. Unsubscribe at any time.">
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'insights-success-stories'): ?>
        <!-- Insights Success Stories Specific Sections -->
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the main hero banner with badge, heading, description, and stats.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_stories_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_stories_hero_badge" name="apex_stories_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_stories_hero_badge_' . $page_slug, 'Success Stories')); ?>" 
                               class="regular-text" placeholder="e.g., Success Stories">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_stories_hero_heading" name="apex_stories_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_stories_hero_heading_' . $page_slug, 'Real Results, Real Impact')); ?>" 
                               class="large-text" placeholder="Enter the main heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_stories_hero_description" name="apex_stories_hero_description" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the description"><?php echo esc_textarea(get_option('apex_stories_hero_description_' . $page_slug, 'Discover how financial institutions across Africa are transforming their operations, reaching more customers, and driving growth with Apex Softwares solutions.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_stories_hero_image" name="apex_stories_hero_image" 
                               value="<?php echo esc_url(get_option('apex_stories_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_hero_stats">Hero Stats</label></th>
                    <td>
                        <textarea id="apex_stories_hero_stats" name="apex_stories_hero_stats" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (one per line)"><?php echo esc_textarea(get_option('apex_stories_hero_stats_' . $page_slug, "100+ | Success Stories\n15+ | Countries\n40% | Avg. Cost Reduction\n3x | Customer Growth")); ?></textarea>
                        <p class="description">Enter one stat per line. Format: <code>Value | Label</code> (e.g., <code>100+ | Success Stories</code>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Featured Story Section -->
        <div style="margin-bottom: 30px;">
            <h4>⭐ Featured Story Section</h4>
            <div style="background: #fff3e0; padding: 15px; margin-bottom: 20px; border: 1px solid #ff9800; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the featured success story card.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_stories_featured_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_stories_featured_badge" name="apex_stories_featured_badge" 
                               value="<?php echo esc_attr(get_option('apex_stories_featured_badge_' . $page_slug, 'Featured Story')); ?>" 
                               class="regular-text" placeholder="e.g., Featured Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_image">Story Image URL</label></th>
                    <td>
                        <input type="url" id="apex_stories_featured_image" name="apex_stories_featured_image" 
                               value="<?php echo esc_url(get_option('apex_stories_featured_image_' . $page_slug, 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_logo">Company Logo Text</label></th>
                    <td>
                        <input type="text" id="apex_stories_featured_logo" name="apex_stories_featured_logo" 
                               value="<?php echo esc_attr(get_option('apex_stories_featured_logo_' . $page_slug, 'Kenya National SACCO')); ?>" 
                               class="regular-text" placeholder="e.g., Kenya National SACCO">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_category">Category</label></th>
                    <td>
                        <input type="text" id="apex_stories_featured_category" name="apex_stories_featured_category" 
                               value="<?php echo esc_attr(get_option('apex_stories_featured_category_' . $page_slug, 'SACCO')); ?>" 
                               class="regular-text" placeholder="e.g., SACCO">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_title">Story Title</label></th>
                    <td>
                        <input type="text" id="apex_stories_featured_title" name="apex_stories_featured_title" 
                               value="<?php echo esc_attr(get_option('apex_stories_featured_title_' . $page_slug, 'How Kenya National SACCO Grew Membership by 300% with Digital Transformation')); ?>" 
                               class="large-text" placeholder="Enter the story title">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_excerpt">Story Excerpt</label></th>
                    <td>
                        <textarea id="apex_stories_featured_excerpt" name="apex_stories_featured_excerpt" 
                                  class="large-text" rows="3" 
                                  placeholder="Enter the story excerpt"><?php echo esc_textarea(get_option('apex_stories_featured_excerpt_' . $page_slug, 'Kenya National SACCO faced declining membership and high operational costs. By implementing ApexCore and our mobile banking solution, they transformed their member experience and achieved remarkable growth.')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_results">Results (3 items)</label></th>
                    <td>
                        <textarea id="apex_stories_featured_results" name="apex_stories_featured_results" 
                                  class="large-text" rows="4" 
                                  placeholder="Format: Value | Label (3 results, one per line)"><?php echo esc_textarea(get_option('apex_stories_featured_results_' . $page_slug, "300% | Membership Growth\n65% | Cost Reduction\n4.8/5 | Member Satisfaction")); ?></textarea>
                        <p class="description">Enter 3 results. Format per line: <code>Value | Label</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_featured_link">Story Link URL</label></th>
                    <td>
                        <input type="text" id="apex_stories_featured_link" name="apex_stories_featured_link" 
                               value="<?php echo esc_attr(get_option('apex_stories_featured_link_' . $page_slug, '#')); ?>" 
                               class="large-text" placeholder="#">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Impact Stats Section -->
        <div style="margin-bottom: 30px;">
            <h4>📊 Impact Stats Section</h4>
            <div style="background: #e8f5e9; padding: 15px; margin-bottom: 20px; border: 1px solid #4caf50; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section displays impact statistics at the bottom of the page.</strong></p>
            </div>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_stories_impact_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_stories_impact_badge" name="apex_stories_impact_badge" 
                               value="<?php echo esc_attr(get_option('apex_stories_impact_badge_' . $page_slug, 'Our Impact')); ?>" 
                               class="regular-text" placeholder="e.g., Our Impact">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_impact_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_stories_impact_heading" name="apex_stories_impact_heading" 
                               value="<?php echo esc_attr(get_option('apex_stories_impact_heading_' . $page_slug, 'Driving Financial Inclusion Across Africa')); ?>" 
                               class="large-text" placeholder="Enter the section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_impact_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_stories_impact_description" name="apex_stories_impact_description" 
                                  class="large-text" rows="2" 
                                  placeholder="Enter the section description"><?php echo esc_textarea(get_option('apex_stories_impact_description_' . $page_slug, "Together with our clients, we're making a measurable difference in communities across the continent.")); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_stories_impact_items">Impact Stats (4 items)</label></th>
                    <td>
                        <textarea id="apex_stories_impact_items" name="apex_stories_impact_items" 
                                  class="large-text" rows="6" 
                                  placeholder="Format: Value | Label (4 items)"><?php echo esc_textarea(get_option('apex_stories_impact_items_' . $page_slug, "10M+ | End Users Served\n\$5B+ | Transactions Processed\n2M+ | Previously Unbanked Reached\n500K+ | Small Businesses Empowered")); ?></textarea>
                        <p class="description">Enter 4 impact stats. Format per line: <code>Value | Label</code></p>
                    </td>
                </tr>
            </table>
        </div>

        <?php elseif ($page_slug === 'request-demo'): ?>
        <!-- Request Demo Specific Sections -->

        <!-- Form Section -->
        <div style="margin-bottom: 30px;">
            <h4>📝 Demo Request Form Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This section controls the heading and description shown above the request demo form.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_demo_form_heading">Form Heading</label></th>
                    <td>
                        <input type="text" id="apex_demo_form_heading" name="apex_demo_form_heading" 
                               value="<?php echo esc_attr(get_option('apex_demo_form_heading_' . $page_slug, 'Request Your Personalized Demo')); ?>" 
                               class="regular-text" placeholder="e.g., Request Your Personalized Demo">
                        <p class="description">The main heading above the demo request form</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_form_description">Form Description</label></th>
                    <td>
                        <textarea id="apex_demo_form_description" name="apex_demo_form_description" rows="3" class="large-text"
                                  placeholder="Fill out the form below and our team will contact you within 24 hours to schedule your demo."><?php 
                            echo esc_textarea(get_option('apex_demo_form_description_' . $page_slug, 'Fill out the form below and our team will contact you within 24 hours to schedule your demo.'));
                        ?></textarea>
                        <p class="description">Description text displayed below the form heading</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- What to Expect Section -->
        <div style="margin-bottom: 30px;">
            <h4>✅ What to Expect Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This sidebar section tells users what they can expect from the demo.</strong> Each item appears as a bullet point with an icon.</p>
                <p><strong>Format:</strong> One item per line — each line becomes a bullet point.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_demo_expect_title">Section Title</label></th>
                    <td>
                        <input type="text" id="apex_demo_expect_title" name="apex_demo_expect_title" 
                               value="<?php echo esc_attr(get_option('apex_demo_expect_title_' . $page_slug, 'What to Expect')); ?>" 
                               class="regular-text" placeholder="e.g., What to Expect">
                        <p class="description">Title for this sidebar section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_expect_items">Expect Items</label></th>
                    <td>
                        <textarea id="apex_demo_expect_items" name="apex_demo_expect_items" rows="8" class="large-text"
                                  placeholder="30-45 minute personalized demo&#10;Dedicated product expert&#10;Customized to your needs&#10;Q&A and discussion&#10;Pricing and licensing information"><?php 
                            echo esc_textarea(get_option('apex_demo_expect_items_' . $page_slug, "30-45 minute personalized demo\nDedicated product expert\nCustomized to your needs\nQ&A and discussion\nPricing and licensing information"));
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> One item per line. Each line becomes a bullet with an icon on the frontend.</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Need Help / Contact Section -->
        <div style="margin-bottom: 30px;">
            <h4>📞 Need Help Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This sidebar section shows contact details so users can reach out directly.</strong></p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_demo_help_title">Section Title</label></th>
                    <td>
                        <input type="text" id="apex_demo_help_title" name="apex_demo_help_title" 
                               value="<?php echo esc_attr(get_option('apex_demo_help_title_' . $page_slug, 'Need Help?')); ?>" 
                               class="regular-text" placeholder="e.g., Need Help?">
                        <p class="description">The heading for the Need Help sidebar card</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_help_description">Description</label></th>
                    <td>
                        <input type="text" id="apex_demo_help_description" name="apex_demo_help_description" 
                               value="<?php echo esc_attr(get_option('apex_demo_help_description_' . $page_slug, 'Our team is ready to assist you.')); ?>" 
                               class="regular-text" placeholder="e.g., Our team is ready to assist you.">
                        <p class="description">Short description shown below the Need Help title</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_phone">Phone Number</label></th>
                    <td>
                        <input type="text" id="apex_demo_phone" name="apex_demo_phone" 
                               value="<?php echo esc_attr(get_option('apex_demo_phone_' . $page_slug, '+254 700 000 000')); ?>" 
                               class="regular-text" placeholder="+254 700 000 000">
                        <p class="description">Contact phone number displayed in the sidebar</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_email">Email Address</label></th>
                    <td>
                        <input type="email" id="apex_demo_email" name="apex_demo_email" 
                               value="<?php echo esc_attr(get_option('apex_demo_email_' . $page_slug, 'sales@apex-softwares.com')); ?>" 
                               class="regular-text" placeholder="sales@apex-softwares.com">
                        <p class="description">Contact email address displayed in the sidebar</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Training Materials Section -->
        <div style="margin-bottom: 30px;">
            <h4>📄 Training Materials Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This sidebar section lists downloadable training materials / documents.</strong></p>
                <p><strong>Format:</strong> <code>Title | File URL | File Size</code> — one material per line.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_demo_materials_title">Section Title</label></th>
                    <td>
                        <input type="text" id="apex_demo_materials_title" name="apex_demo_materials_title" 
                               value="<?php echo esc_attr(get_option('apex_demo_materials_title_' . $page_slug, 'Training Materials')); ?>" 
                               class="regular-text" placeholder="e.g., Training Materials">
                        <p class="description">The heading for the training materials sidebar card</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_materials_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_demo_materials_description" name="apex_demo_materials_description" 
                               value="<?php echo esc_attr(get_option('apex_demo_materials_description_' . $page_slug, 'Download our product presentations and documentation.')); ?>" 
                               class="large-text" placeholder="Download our product presentations and documentation.">
                        <p class="description">Short description shown below the training materials title</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_materials_items">Materials List</label></th>
                    <td>
                        <textarea id="apex_demo_materials_items" name="apex_demo_materials_items" rows="8" class="large-text"
                                  placeholder="Product Overview Presentation | # | PDF • 2.5 MB&#10;Technical Documentation | # | PDF • 5.1 MB&#10;Implementation Guide | # | PDF • 3.8 MB&#10;Pricing & Licensing | # | PDF • 1.2 MB"><?php 
                            echo esc_textarea(get_option('apex_demo_materials_items_' . $page_slug, "Product Overview Presentation | # | PDF • 2.5 MB\nTechnical Documentation | # | PDF • 5.1 MB\nImplementation Guide | # | PDF • 3.8 MB\nPricing & Licensing | # | PDF • 1.2 MB"));
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Title | File URL | File Size (one material per line)</p>
                        <p class="description"><strong>Example:</strong> Product Overview Presentation | https://example.com/file.pdf | PDF • 2.5 MB</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Use # as the URL for placeholder links. Upload files to WordPress Media Library and paste their URLs here.
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Upcoming Webinars Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎥 Upcoming Webinars Section</h4>
            <div style="background: #e7f3ff; padding: 15px; margin-bottom: 20px; border: 1px solid #3498db; border-radius: 6px;">
                <h5>📋 Section Overview</h5>
                <p><strong>This sidebar section lists upcoming webinar/demo sessions.</strong></p>
                <p><strong>Format:</strong> <code>Day | Month | Title | Time | Registration Link</code> — one session per line.</p>
            </div>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_demo_webinars_title">Section Title</label></th>
                    <td>
                        <input type="text" id="apex_demo_webinars_title" name="apex_demo_webinars_title" 
                               value="<?php echo esc_attr(get_option('apex_demo_webinars_title_' . $page_slug, 'Upcoming Webinars')); ?>" 
                               class="regular-text" placeholder="e.g., Upcoming Webinars">
                        <p class="description">The heading for the upcoming webinars sidebar card</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_webinars_description">Section Description</label></th>
                    <td>
                        <input type="text" id="apex_demo_webinars_description" name="apex_demo_webinars_description" 
                               value="<?php echo esc_attr(get_option('apex_demo_webinars_description_' . $page_slug, 'Join our live demo sessions and Q&A.')); ?>" 
                               class="large-text" placeholder="Join our live demo sessions and Q&A.">
                        <p class="description">Short description shown below the webinars title</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_demo_webinars_items">Webinar Sessions</label></th>
                    <td>
                        <textarea id="apex_demo_webinars_items" name="apex_demo_webinars_items" rows="8" class="large-text"
                                  placeholder="15 | Feb | Core Banking Demo | 10:00 AM EAT | #&#10;22 | Feb | Mobile Banking Demo | 2:00 PM EAT | #&#10;01 | Mar | Agent Banking Demo | 10:00 AM EAT | #"><?php 
                            echo esc_textarea(get_option('apex_demo_webinars_items_' . $page_slug, "15 | Feb | Core Banking Demo | 10:00 AM EAT | #\n22 | Feb | Mobile Banking Demo | 2:00 PM EAT | #\n01 | Mar | Agent Banking Demo | 10:00 AM EAT | #"));
                        ?></textarea>
                        <p class="description"><strong>Format:</strong> Day | Month | Title | Time | Registration Link (one session per line)</p>
                        <p class="description"><strong>Example:</strong> 15 | Feb | Core Banking Demo | 10:00 AM EAT | https://example.com/register</p>
                        <div style="background: #f8f9fa; padding: 10px; margin-top: 10px; border-left: 3px solid #007cba;">
                            <strong>💡 Tip:</strong> Keep webinars current — remove past sessions and add upcoming ones regularly. Use # as the registration link for placeholder items.
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
        
        // Save Hero Section (common to other pages, not home or solutions pages)
        if ($page_slug !== 'home' && $page_slug !== 'solutions-overview' && $page_slug !== 'solutions-core-banking-microfinance' && $page_slug !== 'solutions-mobile-wallet-app' && $page_slug !== 'solutions-agency-branch-banking' && $page_slug !== 'solutions-internet-mobile-banking' && $page_slug !== 'solutions-loan-origination-workflows' && $page_slug !== 'solutions-digital-field-agent' && $page_slug !== 'solutions-enterprise-integration' && $page_slug !== 'solutions-payment-switch-ledger' && $page_slug !== 'solutions-reporting-analytics' && $page_slug !== 'industry-overview' && $page_slug !== 'industry-mfis' && $page_slug !== 'industry-credit-unions' && $page_slug !== 'industry-banks-microfinance' && $page_slug !== 'industry-digital-government' && $page_slug !== 'insights-blog' && $page_slug !== 'request-demo' && $page_slug !== 'insights-success-stories' && $page_slug !== 'insights-webinars' && $page_slug !== 'insights-whitepapers-reports' && $page_slug !== 'partners' && $page_slug !== 'developers' && $page_slug !== 'knowledge-base' && $page_slug !== 'faq' && $page_slug !== 'help-support' && $page_slug !== 'careers') {
            update_option('apex_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_hero_badge']));
            update_option('apex_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_hero_heading']));
            update_option('apex_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_description']));
            update_option('apex_hero_image_' . $page_slug, esc_url_raw($_POST['apex_hero_image']));
            update_option('apex_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_stats']));
        }
        
        if ($page_slug === 'home') {
            // Save Home Page specific sections
            
            // Hero Slides Section
            update_option('apex_hero_slides_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_slides']));
            update_option('apex_hero_tagline_' . $page_slug, sanitize_text_field($_POST['apex_hero_tagline']));
            update_option('apex_hero_cta_primary_' . $page_slug, sanitize_text_field($_POST['apex_hero_cta_primary']));
            update_option('apex_hero_cta_primary_url_' . $page_slug, esc_url_raw($_POST['apex_hero_cta_primary_url']));
            update_option('apex_hero_cta_secondary_' . $page_slug, sanitize_text_field($_POST['apex_hero_cta_secondary']));
            update_option('apex_hero_cta_secondary_url_' . $page_slug, esc_url_raw($_POST['apex_hero_cta_secondary_url']));
            update_option('apex_hero_banner_text_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_banner_text']));
            update_option('apex_hero_banner_link_text_' . $page_slug, sanitize_text_field($_POST['apex_hero_banner_link_text']));
            update_option('apex_hero_banner_link_url_' . $page_slug, esc_url_raw($_POST['apex_hero_banner_link_url']));
            
            // Who We Are Section
            update_option('apex_who_we_are_badge_' . $page_slug, sanitize_text_field($_POST['apex_who_we_are_badge']));
            update_option('apex_who_we_are_heading_' . $page_slug, sanitize_text_field($_POST['apex_who_we_are_heading']));
            update_option('apex_who_we_are_description_' . $page_slug, sanitize_textarea_field($_POST['apex_who_we_are_description']));
            update_option('apex_who_we_are_features_' . $page_slug, sanitize_textarea_field($_POST['apex_who_we_are_features']));
            update_option('apex_who_we_are_image_' . $page_slug, esc_url_raw($_POST['apex_who_we_are_image']));
            update_option('apex_who_we_are_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_who_we_are_cta_text']));
            update_option('apex_who_we_are_cta_url_' . $page_slug, esc_url_raw($_POST['apex_who_we_are_cta_url']));
            
            // What We Do Section
            update_option('apex_what_we_do_badge_' . $page_slug, sanitize_text_field($_POST['apex_what_we_do_badge']));
            update_option('apex_what_we_do_heading_' . $page_slug, sanitize_text_field($_POST['apex_what_we_do_heading']));
            update_option('apex_what_we_do_description_' . $page_slug, sanitize_textarea_field($_POST['apex_what_we_do_description']));
            update_option('apex_what_we_do_services_' . $page_slug, sanitize_textarea_field($_POST['apex_what_we_do_services']));
            update_option('apex_what_we_do_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_what_we_do_cta_text']));
            update_option('apex_what_we_do_cta_url_' . $page_slug, esc_url_raw($_POST['apex_what_we_do_cta_url']));
            
            // How We Do It Section
            update_option('apex_how_we_do_it_badge_' . $page_slug, sanitize_text_field($_POST['apex_how_we_do_it_badge']));
            update_option('apex_how_we_do_it_heading_' . $page_slug, sanitize_text_field($_POST['apex_how_we_do_it_heading']));
            update_option('apex_how_we_do_it_description_' . $page_slug, sanitize_textarea_field($_POST['apex_how_we_do_it_description']));
            update_option('apex_how_we_do_it_steps_' . $page_slug, sanitize_textarea_field($_POST['apex_how_we_do_it_steps']));
            update_option('apex_how_we_do_it_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_how_we_do_it_cta_text']));
            update_option('apex_how_we_do_it_cta_url_' . $page_slug, esc_url_raw($_POST['apex_how_we_do_it_cta_url']));
            
            // Statistics Section
            update_option('apex_statistics_heading_' . $page_slug, sanitize_text_field($_POST['apex_statistics_heading']));
            update_option('apex_statistics_subheading_' . $page_slug, sanitize_textarea_field($_POST['apex_statistics_subheading']));
            update_option('apex_statistics_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_statistics_stats']));
            update_option('apex_statistics_background_image_' . $page_slug, esc_url_raw($_POST['apex_statistics_background_image']));
            
            // Testimonials Section
            update_option('apex_testimonials_badge_' . $page_slug, sanitize_text_field($_POST['apex_testimonials_badge']));
            update_option('apex_testimonials_heading_' . $page_slug, sanitize_text_field($_POST['apex_testimonials_heading']));
            update_option('apex_testimonials_description_' . $page_slug, sanitize_textarea_field($_POST['apex_testimonials_description']));
            update_option('apex_testimonials_list_' . $page_slug, sanitize_textarea_field($_POST['apex_testimonials_list']));
            
            // Partners Section
            update_option('apex_partners_badge_' . $page_slug, sanitize_text_field($_POST['apex_partners_badge']));
            update_option('apex_partners_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_heading']));
            update_option('apex_partners_description_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_description']));
            update_option('apex_partners_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_partners_cta_text']));
            update_option('apex_partners_cta_url_' . $page_slug, esc_url_raw($_POST['apex_partners_cta_url']));
            
            // ROI Calculator Section
            update_option('apex_roi_badge_' . $page_slug, sanitize_text_field($_POST['apex_roi_badge']));
            update_option('apex_roi_heading_' . $page_slug, sanitize_text_field($_POST['apex_roi_heading']));
            update_option('apex_roi_description_' . $page_slug, sanitize_textarea_field($_POST['apex_roi_description']));
            update_option('apex_roi_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_roi_cta_text']));
            update_option('apex_roi_cta_url_' . $page_slug, esc_url_raw($_POST['apex_roi_cta_url']));
            
            // Case Studies Section
            update_option('apex_case_studies_badge_' . $page_slug, sanitize_text_field($_POST['apex_case_studies_badge']));
            update_option('apex_case_studies_heading_' . $page_slug, sanitize_text_field($_POST['apex_case_studies_heading']));
            update_option('apex_case_studies_description_' . $page_slug, sanitize_textarea_field($_POST['apex_case_studies_description']));
            update_option('apex_case_studies_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_case_studies_cta_text']));
            update_option('apex_case_studies_cta_url_' . $page_slug, esc_url_raw($_POST['apex_case_studies_cta_url']));
            
            // API Integration Section
            update_option('apex_api_badge_' . $page_slug, sanitize_text_field($_POST['apex_api_badge']));
            update_option('apex_api_heading_' . $page_slug, sanitize_text_field($_POST['apex_api_heading']));
            update_option('apex_api_description_' . $page_slug, sanitize_textarea_field($_POST['apex_api_description']));
            update_option('apex_api_primary_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_api_primary_cta_text']));
            update_option('apex_api_primary_cta_url_' . $page_slug, esc_url_raw($_POST['apex_api_primary_cta_url']));
            update_option('apex_api_secondary_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_api_secondary_cta_text']));
            update_option('apex_api_secondary_cta_url_' . $page_slug, esc_url_raw($_POST['apex_api_secondary_cta_url']));
            
            // Compliance & Security Section
            update_option('apex_compliance_badge_' . $page_slug, sanitize_text_field($_POST['apex_compliance_badge']));
            update_option('apex_compliance_heading_' . $page_slug, sanitize_text_field($_POST['apex_compliance_heading']));
            update_option('apex_compliance_description_' . $page_slug, sanitize_textarea_field($_POST['apex_compliance_description']));
            update_option('apex_compliance_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_compliance_cta_text']));
            update_option('apex_compliance_cta_url_' . $page_slug, esc_url_raw($_POST['apex_compliance_cta_url']));
            
            // What's New Section
            update_option('apex_whats_new_badge_' . $page_slug, sanitize_text_field($_POST['apex_whats_new_badge']));
            update_option('apex_whats_new_heading_' . $page_slug, sanitize_text_field($_POST['apex_whats_new_heading']));
            update_option('apex_whats_new_description_' . $page_slug, sanitize_textarea_field($_POST['apex_whats_new_description']));
            update_option('apex_whats_new_posts_per_page_' . $page_slug, sanitize_text_field($_POST['apex_whats_new_posts_per_page']));
            update_option('apex_whats_new_cta_text_' . $page_slug, sanitize_text_field($_POST['apex_whats_new_cta_text']));
            update_option('apex_whats_new_cta_url_' . $page_slug, esc_url_raw($_POST['apex_whats_new_cta_url']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Home page content saved successfully! All sections including hero slides, company information, services, testimonials, and more have been updated.</p></div>';
        } elseif ($page_slug === 'about-us-overview') {
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
            update_option('apex_contact_sales_email_' . $page_slug, sanitize_email($_POST['apex_contact_sales_email']));
            
            update_option('apex_contact_sidebar_items_' . $page_slug, sanitize_textarea_field($_POST['apex_contact_sidebar_items']));
            
            // Save Contact Details
            update_option('apex_contact_phone_' . $page_slug, sanitize_text_field($_POST['apex_contact_phone']));
            update_option('apex_contact_email_main_' . $page_slug, sanitize_email($_POST['apex_contact_email_main']));
            update_option('apex_contact_email_sales_' . $page_slug, sanitize_email($_POST['apex_contact_email_sales']));
            
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
            
            // Save Office Hours
            update_option('apex_offices_weekday_hours_' . $page_slug, sanitize_text_field($_POST['apex_offices_weekday_hours']));
            update_option('apex_offices_saturday_hours_' . $page_slug, sanitize_text_field($_POST['apex_offices_saturday_hours']));
            update_option('apex_offices_sunday_holiday_status_' . $page_slug, sanitize_text_field($_POST['apex_offices_sunday_holiday_status']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Contact Us content saved successfully! All sections with contact form, sidebar information, and office locations have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-overview') {
            // Save Solutions Overview specific sections
            
            // Hero Section
            update_option('apex_solutions_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_solutions_hero_badge']));
            update_option('apex_solutions_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_solutions_hero_heading']));
            update_option('apex_solutions_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_hero_description']));
            update_option('apex_solutions_hero_image_' . $page_slug, esc_url_raw($_POST['apex_solutions_hero_image']));
            update_option('apex_solutions_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_hero_stats']));
            
            // Solutions Grid Section
            update_option('apex_solutions_grid_badge_' . $page_slug, sanitize_text_field($_POST['apex_solutions_grid_badge']));
            update_option('apex_solutions_grid_heading_' . $page_slug, sanitize_text_field($_POST['apex_solutions_grid_heading']));
            update_option('apex_solutions_grid_description_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_grid_description']));
            update_option('apex_solutions_grid_items_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_grid_items']));
            
            // Benefits Section
            update_option('apex_solutions_benefits_badge_' . $page_slug, sanitize_text_field($_POST['apex_solutions_benefits_badge']));
            update_option('apex_solutions_benefits_heading_' . $page_slug, sanitize_text_field($_POST['apex_solutions_benefits_heading']));
            update_option('apex_solutions_benefits_items_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_benefits_items']));
            
            // Integration Section
            update_option('apex_solutions_integration_badge_' . $page_slug, sanitize_text_field($_POST['apex_solutions_integration_badge']));
            update_option('apex_solutions_integration_heading_' . $page_slug, sanitize_text_field($_POST['apex_solutions_integration_heading']));
            update_option('apex_solutions_integration_description_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_integration_description']));
            update_option('apex_solutions_integration_categories_' . $page_slug, sanitize_textarea_field($_POST['apex_solutions_integration_categories']));
            update_option('apex_solutions_integration_image_' . $page_slug, esc_url_raw($_POST['apex_solutions_integration_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Solutions Overview content saved successfully! All sections with hero, solutions grid, benefits, and integrations have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-core-banking-microfinance') {
            // Save Core Banking & Microfinance specific sections
            
            // Hero Section
            update_option('apex_corebank_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_corebank_hero_badge']));
            update_option('apex_corebank_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_corebank_hero_heading']));
            update_option('apex_corebank_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_corebank_hero_description']));
            update_option('apex_corebank_hero_image_' . $page_slug, esc_url_raw($_POST['apex_corebank_hero_image']));
            update_option('apex_corebank_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_corebank_hero_stats']));
            
            // Features Section
            update_option('apex_corebank_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_corebank_features_badge']));
            update_option('apex_corebank_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_corebank_features_heading']));
            update_option('apex_corebank_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_corebank_features_items']));
            
            // Technical Specifications Section
            update_option('apex_corebank_specs_badge_' . $page_slug, sanitize_text_field($_POST['apex_corebank_specs_badge']));
            update_option('apex_corebank_specs_heading_' . $page_slug, sanitize_text_field($_POST['apex_corebank_specs_heading']));
            update_option('apex_corebank_specs_items_' . $page_slug, sanitize_textarea_field($_POST['apex_corebank_specs_items']));
            update_option('apex_corebank_specs_image_' . $page_slug, esc_url_raw($_POST['apex_corebank_specs_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Core Banking & Microfinance content saved successfully! All sections with hero, features, and technical specifications have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-mobile-wallet-app') {
            // Save Mobile Wallet App specific sections
            
            // Hero Section
            update_option('apex_wallet_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_wallet_hero_badge']));
            update_option('apex_wallet_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_wallet_hero_heading']));
            update_option('apex_wallet_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_wallet_hero_description']));
            update_option('apex_wallet_hero_image_' . $page_slug, esc_url_raw($_POST['apex_wallet_hero_image']));
            update_option('apex_wallet_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_wallet_hero_stats']));
            
            // Features Section
            update_option('apex_wallet_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_wallet_features_badge']));
            update_option('apex_wallet_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_wallet_features_heading']));
            update_option('apex_wallet_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_wallet_features_items']));
            
            // White-Label Solution Section
            update_option('apex_wallet_whitelabel_badge_' . $page_slug, sanitize_text_field($_POST['apex_wallet_whitelabel_badge']));
            update_option('apex_wallet_whitelabel_heading_' . $page_slug, sanitize_text_field($_POST['apex_wallet_whitelabel_heading']));
            update_option('apex_wallet_whitelabel_items_' . $page_slug, sanitize_textarea_field($_POST['apex_wallet_whitelabel_items']));
            update_option('apex_wallet_whitelabel_image_' . $page_slug, esc_url_raw($_POST['apex_wallet_whitelabel_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Mobile Wallet App content saved successfully! All sections with hero, features, and white-label information have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-agency-branch-banking') {
            // Save Agency & Branch Banking specific sections
            
            // Hero Section
            update_option('apex_agency_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_agency_hero_badge']));
            update_option('apex_agency_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_agency_hero_heading']));
            update_option('apex_agency_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_agency_hero_description']));
            update_option('apex_agency_hero_image_' . $page_slug, esc_url_raw($_POST['apex_agency_hero_image']));
            update_option('apex_agency_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_agency_hero_stats']));
            
            // Features Section
            update_option('apex_agency_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_agency_features_badge']));
            update_option('apex_agency_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_agency_features_heading']));
            update_option('apex_agency_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_agency_features_items']));
            
            // Agent Network Models Section
            update_option('apex_agency_models_badge_' . $page_slug, sanitize_text_field($_POST['apex_agency_models_badge']));
            update_option('apex_agency_models_heading_' . $page_slug, sanitize_text_field($_POST['apex_agency_models_heading']));
            update_option('apex_agency_models_items_' . $page_slug, sanitize_textarea_field($_POST['apex_agency_models_items']));
            update_option('apex_agency_models_image_' . $page_slug, esc_url_raw($_POST['apex_agency_models_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Agency & Branch Banking content saved successfully! All sections with hero, features, and agent network models have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-internet-mobile-banking') {
            // Save Internet & Mobile Banking specific sections
            
            // Hero Section
            update_option('apex_internet_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_internet_hero_badge']));
            update_option('apex_internet_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_internet_hero_heading']));
            update_option('apex_internet_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_internet_hero_description']));
            update_option('apex_internet_hero_image_' . $page_slug, esc_url_raw($_POST['apex_internet_hero_image']));
            update_option('apex_internet_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_internet_hero_stats']));
            
            // Features Section
            update_option('apex_internet_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_internet_features_badge']));
            update_option('apex_internet_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_internet_features_heading']));
            update_option('apex_internet_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_internet_features_items']));
            
            // Channel Accessibility Section
            update_option('apex_internet_accessibility_badge_' . $page_slug, sanitize_text_field($_POST['apex_internet_accessibility_badge']));
            update_option('apex_internet_accessibility_heading_' . $page_slug, sanitize_text_field($_POST['apex_internet_accessibility_heading']));
            update_option('apex_internet_accessibility_items_' . $page_slug, sanitize_textarea_field($_POST['apex_internet_accessibility_items']));
            update_option('apex_internet_accessibility_image_' . $page_slug, esc_url_raw($_POST['apex_internet_accessibility_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Internet & Mobile Banking content saved successfully! All sections with hero, features, and channel accessibility have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-loan-origination-workflows') {
            // Save Loan Origination & Workflows specific sections
            
            // Hero Section
            update_option('apex_loan_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_loan_hero_badge']));
            update_option('apex_loan_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_loan_hero_heading']));
            update_option('apex_loan_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_loan_hero_description']));
            update_option('apex_loan_hero_image_' . $page_slug, esc_url_raw($_POST['apex_loan_hero_image']));
            update_option('apex_loan_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_loan_hero_stats']));
            
            // Features Section
            update_option('apex_loan_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_loan_features_badge']));
            update_option('apex_loan_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_loan_features_heading']));
            update_option('apex_loan_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_loan_features_items']));
            
            // Loan Product Types Section
            update_option('apex_loan_products_badge_' . $page_slug, sanitize_text_field($_POST['apex_loan_products_badge']));
            update_option('apex_loan_products_heading_' . $page_slug, sanitize_text_field($_POST['apex_loan_products_heading']));
            update_option('apex_loan_products_items_' . $page_slug, sanitize_textarea_field($_POST['apex_loan_products_items']));
            update_option('apex_loan_products_image_' . $page_slug, esc_url_raw($_POST['apex_loan_products_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Loan Origination & Workflows content saved successfully! All sections with hero, features, and loan product types have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-digital-field-agent') {
            // Save Digital Field Agent specific sections
            
            // Hero Section
            update_option('apex_field_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_field_hero_badge']));
            update_option('apex_field_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_field_hero_heading']));
            update_option('apex_field_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_field_hero_description']));
            update_option('apex_field_hero_image_' . $page_slug, esc_url_raw($_POST['apex_field_hero_image']));
            update_option('apex_field_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_field_hero_stats']));
            
            // Features Section
            update_option('apex_field_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_field_features_badge']));
            update_option('apex_field_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_field_features_heading']));
            update_option('apex_field_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_field_features_items']));
            
            // Field Operations Use Cases Section
            update_option('apex_field_usecases_badge_' . $page_slug, sanitize_text_field($_POST['apex_field_usecases_badge']));
            update_option('apex_field_usecases_heading_' . $page_slug, sanitize_text_field($_POST['apex_field_usecases_heading']));
            update_option('apex_field_usecases_items_' . $page_slug, sanitize_textarea_field($_POST['apex_field_usecases_items']));
            update_option('apex_field_usecases_image_' . $page_slug, esc_url_raw($_POST['apex_field_usecases_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Digital Field Agent content saved successfully! All sections with hero, features, and field operations use cases have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-enterprise-integration') {
            // Save Enterprise Integration specific sections
            
            // Hero Section
            update_option('apex_integration_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_integration_hero_badge']));
            update_option('apex_integration_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_integration_hero_heading']));
            update_option('apex_integration_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_integration_hero_description']));
            update_option('apex_integration_hero_image_' . $page_slug, esc_url_raw($_POST['apex_integration_hero_image']));
            update_option('apex_integration_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_integration_hero_stats']));
            
            // Integration Categories Section
            update_option('apex_integration_categories_badge_' . $page_slug, sanitize_text_field($_POST['apex_integration_categories_badge']));
            update_option('apex_integration_categories_heading_' . $page_slug, sanitize_text_field($_POST['apex_integration_categories_heading']));
            update_option('apex_integration_categories_items_' . $page_slug, sanitize_textarea_field($_POST['apex_integration_categories_items']));
            
            // Integration Architecture Section
            update_option('apex_integration_arch_badge_' . $page_slug, sanitize_text_field($_POST['apex_integration_arch_badge']));
            update_option('apex_integration_arch_heading_' . $page_slug, sanitize_text_field($_POST['apex_integration_arch_heading']));
            update_option('apex_integration_arch_items_' . $page_slug, sanitize_textarea_field($_POST['apex_integration_arch_items']));
            update_option('apex_integration_arch_image_' . $page_slug, esc_url_raw($_POST['apex_integration_arch_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Enterprise Integration content saved successfully! All sections with hero, integration categories, and architecture have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-payment-switch-ledger') {
            // Save Payment Switch & General Ledger specific sections
            
            // Hero Section
            update_option('apex_payment_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_payment_hero_badge']));
            update_option('apex_payment_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_payment_hero_heading']));
            update_option('apex_payment_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_payment_hero_description']));
            update_option('apex_payment_hero_image_' . $page_slug, esc_url_raw($_POST['apex_payment_hero_image']));
            update_option('apex_payment_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_payment_hero_stats']));
            
            // Features Section
            update_option('apex_payment_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_payment_features_badge']));
            update_option('apex_payment_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_payment_features_heading']));
            update_option('apex_payment_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_payment_features_items']));
            
            // Supported Payment Rails Section
            update_option('apex_payment_rails_badge_' . $page_slug, sanitize_text_field($_POST['apex_payment_rails_badge']));
            update_option('apex_payment_rails_heading_' . $page_slug, sanitize_text_field($_POST['apex_payment_rails_heading']));
            update_option('apex_payment_rails_items_' . $page_slug, sanitize_textarea_field($_POST['apex_payment_rails_items']));
            update_option('apex_payment_rails_image_' . $page_slug, esc_url_raw($_POST['apex_payment_rails_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Payment Switch & General Ledger content saved successfully! All sections with hero, features, and payment rails have been updated.</p></div>';
        } elseif ($page_slug === 'solutions-reporting-analytics') {
            // Save Reporting & Analytics specific sections
            
            // Hero Section
            update_option('apex_reporting_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_reporting_hero_badge']));
            update_option('apex_reporting_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_reporting_hero_heading']));
            update_option('apex_reporting_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_reporting_hero_description']));
            update_option('apex_reporting_hero_image_' . $page_slug, esc_url_raw($_POST['apex_reporting_hero_image']));
            update_option('apex_reporting_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_reporting_hero_stats']));
            
            // Features Section
            update_option('apex_reporting_features_badge_' . $page_slug, sanitize_text_field($_POST['apex_reporting_features_badge']));
            update_option('apex_reporting_features_heading_' . $page_slug, sanitize_text_field($_POST['apex_reporting_features_heading']));
            update_option('apex_reporting_features_items_' . $page_slug, sanitize_textarea_field($_POST['apex_reporting_features_items']));
            
            // Regulatory Compliance Section
            update_option('apex_reporting_compliance_badge_' . $page_slug, sanitize_text_field($_POST['apex_reporting_compliance_badge']));
            update_option('apex_reporting_compliance_heading_' . $page_slug, sanitize_text_field($_POST['apex_reporting_compliance_heading']));
            update_option('apex_reporting_compliance_items_' . $page_slug, sanitize_textarea_field($_POST['apex_reporting_compliance_items']));
            update_option('apex_reporting_compliance_image_' . $page_slug, esc_url_raw($_POST['apex_reporting_compliance_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Reporting & Analytics content saved successfully! All sections with hero, features, and regulatory compliance have been updated.</p></div>';
        } elseif ($page_slug === 'industry-overview') {
            // Save Industry Overview specific sections
            
            // Hero Section
            update_option('apex_industry_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_industry_hero_badge']));
            update_option('apex_industry_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_industry_hero_heading']));
            update_option('apex_industry_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_hero_description']));
            update_option('apex_industry_hero_image_' . $page_slug, esc_url_raw($_POST['apex_industry_hero_image']));
            update_option('apex_industry_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_hero_stats']));
            
            // Industry Sectors Section
            update_option('apex_industry_sectors_badge_' . $page_slug, sanitize_text_field($_POST['apex_industry_sectors_badge']));
            update_option('apex_industry_sectors_heading_' . $page_slug, sanitize_text_field($_POST['apex_industry_sectors_heading']));
            update_option('apex_industry_sectors_description_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_sectors_description']));
            
            // Industry Sector Cards
            for ($i = 1; $i <= 4; $i++) {
                update_option('apex_industry_card' . $i . '_title_' . $page_slug, sanitize_text_field($_POST['apex_industry_card' . $i . '_title']));
                update_option('apex_industry_card' . $i . '_desc_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_card' . $i . '_desc']));
                update_option('apex_industry_card' . $i . '_stats_' . $page_slug, sanitize_text_field($_POST['apex_industry_card' . $i . '_stats']));
                update_option('apex_industry_card' . $i . '_link_' . $page_slug, sanitize_text_field($_POST['apex_industry_card' . $i . '_link']));
            }
            
            // Why Choose Us Section
            update_option('apex_industry_why_badge_' . $page_slug, sanitize_text_field($_POST['apex_industry_why_badge']));
            update_option('apex_industry_why_heading_' . $page_slug, sanitize_text_field($_POST['apex_industry_why_heading']));
            update_option('apex_industry_why_description_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_why_description']));
            update_option('apex_industry_why_image_' . $page_slug, esc_url_raw($_POST['apex_industry_why_image']));
            update_option('apex_industry_why_features_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_why_features']));
            
            // Stats Section
            update_option('apex_industry_stats_heading_' . $page_slug, sanitize_text_field($_POST['apex_industry_stats_heading']));
            update_option('apex_industry_stats_description_' . $page_slug, sanitize_text_field($_POST['apex_industry_stats_description']));
            update_option('apex_industry_stats_items_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_stats_items']));
            
            // Testimonial Section
            update_option('apex_industry_testimonial_quote_' . $page_slug, sanitize_textarea_field($_POST['apex_industry_testimonial_quote']));
            update_option('apex_industry_testimonial_author_' . $page_slug, sanitize_text_field($_POST['apex_industry_testimonial_author']));
            update_option('apex_industry_testimonial_title_' . $page_slug, sanitize_text_field($_POST['apex_industry_testimonial_title']));
            update_option('apex_industry_testimonial_image_' . $page_slug, esc_url_raw($_POST['apex_industry_testimonial_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Industry Overview content saved successfully! All sections including hero, sectors, features, stats, and testimonial have been updated.</p></div>';
        } elseif ($page_slug === 'industry-mfis') {
            // Save Industry MFIs specific sections
            
            // Hero Section
            update_option('apex_mfi_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_mfi_hero_badge']));
            update_option('apex_mfi_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_mfi_hero_heading']));
            update_option('apex_mfi_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_hero_description']));
            update_option('apex_mfi_hero_image_' . $page_slug, esc_url_raw($_POST['apex_mfi_hero_image']));
            update_option('apex_mfi_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_hero_stats']));
            
            // Challenges Section
            update_option('apex_mfi_challenges_badge_' . $page_slug, sanitize_text_field($_POST['apex_mfi_challenges_badge']));
            update_option('apex_mfi_challenges_heading_' . $page_slug, sanitize_text_field($_POST['apex_mfi_challenges_heading']));
            update_option('apex_mfi_challenges_description_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_challenges_description']));
            update_option('apex_mfi_challenges_items_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_challenges_items']));
            
            // Solutions Section
            update_option('apex_mfi_solutions_badge_' . $page_slug, sanitize_text_field($_POST['apex_mfi_solutions_badge']));
            update_option('apex_mfi_solutions_heading_' . $page_slug, sanitize_text_field($_POST['apex_mfi_solutions_heading']));
            update_option('apex_mfi_solutions_items_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_solutions_items']));
            
            // Case Study Section
            update_option('apex_mfi_case_badge_' . $page_slug, sanitize_text_field($_POST['apex_mfi_case_badge']));
            update_option('apex_mfi_case_heading_' . $page_slug, sanitize_text_field($_POST['apex_mfi_case_heading']));
            update_option('apex_mfi_case_description_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_case_description']));
            update_option('apex_mfi_case_results_' . $page_slug, sanitize_textarea_field($_POST['apex_mfi_case_results']));
            update_option('apex_mfi_case_image_' . $page_slug, esc_url_raw($_POST['apex_mfi_case_image']));
            update_option('apex_mfi_case_link_' . $page_slug, sanitize_text_field($_POST['apex_mfi_case_link']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Microfinance Institutions (MFIs) content saved successfully! All sections including hero, challenges, solutions, and case study have been updated.</p></div>';
        } elseif ($page_slug === 'industry-credit-unions') {
            // Save Industry Credit Unions specific sections
            
            // Hero Section
            update_option('apex_credit_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_credit_hero_badge']));
            update_option('apex_credit_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_credit_hero_heading']));
            update_option('apex_credit_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_hero_description']));
            update_option('apex_credit_hero_image_' . $page_slug, esc_url_raw($_POST['apex_credit_hero_image']));
            update_option('apex_credit_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_hero_stats']));
            
            // Challenges Section
            update_option('apex_credit_challenges_badge_' . $page_slug, sanitize_text_field($_POST['apex_credit_challenges_badge']));
            update_option('apex_credit_challenges_heading_' . $page_slug, sanitize_text_field($_POST['apex_credit_challenges_heading']));
            update_option('apex_credit_challenges_description_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_challenges_description']));
            update_option('apex_credit_challenges_items_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_challenges_items']));
            
            // Solutions Section
            update_option('apex_credit_solutions_badge_' . $page_slug, sanitize_text_field($_POST['apex_credit_solutions_badge']));
            update_option('apex_credit_solutions_heading_' . $page_slug, sanitize_text_field($_POST['apex_credit_solutions_heading']));
            update_option('apex_credit_solutions_items_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_solutions_items']));
            
            // Case Study Section
            update_option('apex_credit_case_badge_' . $page_slug, sanitize_text_field($_POST['apex_credit_case_badge']));
            update_option('apex_credit_case_heading_' . $page_slug, sanitize_text_field($_POST['apex_credit_case_heading']));
            update_option('apex_credit_case_description_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_case_description']));
            update_option('apex_credit_case_results_' . $page_slug, sanitize_textarea_field($_POST['apex_credit_case_results']));
            update_option('apex_credit_case_image_' . $page_slug, esc_url_raw($_POST['apex_credit_case_image']));
            update_option('apex_credit_case_link_' . $page_slug, sanitize_text_field($_POST['apex_credit_case_link']));
            
            echo '<div class="notice notice-success is-dismissible"><p>SACCOs & Credit Unions content saved successfully! All sections including hero, challenges, solutions, and case study have been updated.</p></div>';
        } elseif ($page_slug === 'industry-banks-microfinance') {
            // Save Industry Banks specific sections
            
            // Hero Section
            update_option('apex_bank_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_bank_hero_badge']));
            update_option('apex_bank_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_bank_hero_heading']));
            update_option('apex_bank_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_hero_description']));
            update_option('apex_bank_hero_image_' . $page_slug, esc_url_raw($_POST['apex_bank_hero_image']));
            update_option('apex_bank_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_hero_stats']));
            
            // Challenges Section
            update_option('apex_bank_challenges_badge_' . $page_slug, sanitize_text_field($_POST['apex_bank_challenges_badge']));
            update_option('apex_bank_challenges_heading_' . $page_slug, sanitize_text_field($_POST['apex_bank_challenges_heading']));
            update_option('apex_bank_challenges_description_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_challenges_description']));
            update_option('apex_bank_challenges_items_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_challenges_items']));
            
            // Solutions Section
            update_option('apex_bank_solutions_badge_' . $page_slug, sanitize_text_field($_POST['apex_bank_solutions_badge']));
            update_option('apex_bank_solutions_heading_' . $page_slug, sanitize_text_field($_POST['apex_bank_solutions_heading']));
            update_option('apex_bank_solutions_items_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_solutions_items']));
            
            // Case Study Section
            update_option('apex_bank_case_badge_' . $page_slug, sanitize_text_field($_POST['apex_bank_case_badge']));
            update_option('apex_bank_case_heading_' . $page_slug, sanitize_text_field($_POST['apex_bank_case_heading']));
            update_option('apex_bank_case_description_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_case_description']));
            update_option('apex_bank_case_results_' . $page_slug, sanitize_textarea_field($_POST['apex_bank_case_results']));
            update_option('apex_bank_case_image_' . $page_slug, esc_url_raw($_POST['apex_bank_case_image']));
            update_option('apex_bank_case_link_' . $page_slug, sanitize_text_field($_POST['apex_bank_case_link']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Commercial Banks content saved successfully! All sections including hero, challenges, solutions, and case study have been updated.</p></div>';
        } elseif ($page_slug === 'industry-digital-government') {
            // Save Industry Digital Government specific sections
            
            // Hero Section
            update_option('apex_gov_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_gov_hero_badge']));
            update_option('apex_gov_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_gov_hero_heading']));
            update_option('apex_gov_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_hero_description']));
            update_option('apex_gov_hero_image_' . $page_slug, esc_url_raw($_POST['apex_gov_hero_image']));
            update_option('apex_gov_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_hero_stats']));
            
            // Challenges Section
            update_option('apex_gov_challenges_badge_' . $page_slug, sanitize_text_field($_POST['apex_gov_challenges_badge']));
            update_option('apex_gov_challenges_heading_' . $page_slug, sanitize_text_field($_POST['apex_gov_challenges_heading']));
            update_option('apex_gov_challenges_description_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_challenges_description']));
            update_option('apex_gov_challenges_items_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_challenges_items']));
            
            // Solutions Section
            update_option('apex_gov_solutions_badge_' . $page_slug, sanitize_text_field($_POST['apex_gov_solutions_badge']));
            update_option('apex_gov_solutions_heading_' . $page_slug, sanitize_text_field($_POST['apex_gov_solutions_heading']));
            update_option('apex_gov_solutions_items_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_solutions_items']));
            
            // Use Cases Section
            update_option('apex_gov_usecases_badge_' . $page_slug, sanitize_text_field($_POST['apex_gov_usecases_badge']));
            update_option('apex_gov_usecases_heading_' . $page_slug, sanitize_text_field($_POST['apex_gov_usecases_heading']));
            update_option('apex_gov_usecases_items_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_usecases_items']));
            
            // Case Study Section
            update_option('apex_gov_case_badge_' . $page_slug, sanitize_text_field($_POST['apex_gov_case_badge']));
            update_option('apex_gov_case_heading_' . $page_slug, sanitize_text_field($_POST['apex_gov_case_heading']));
            update_option('apex_gov_case_description_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_case_description']));
            update_option('apex_gov_case_results_' . $page_slug, sanitize_textarea_field($_POST['apex_gov_case_results']));
            update_option('apex_gov_case_image_' . $page_slug, esc_url_raw($_POST['apex_gov_case_image']));
            update_option('apex_gov_case_link_' . $page_slug, sanitize_text_field($_POST['apex_gov_case_link']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Digital Government & NGOs content saved successfully! All sections including hero, challenges, solutions, use cases, and case study have been updated.</p></div>';
        } elseif ($page_slug === 'insights-blog') {
            // Save Insights Blog specific sections
            
            // Hero Section
            update_option('apex_blog_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_blog_hero_badge']));
            update_option('apex_blog_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_blog_hero_heading']));
            update_option('apex_blog_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_blog_hero_description']));
            update_option('apex_blog_hero_image_' . $page_slug, esc_url_raw($_POST['apex_blog_hero_image']));
            update_option('apex_blog_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_blog_hero_stats']));
            
            // Featured Article Section
            update_option('apex_blog_featured_badge_' . $page_slug, sanitize_text_field($_POST['apex_blog_featured_badge']));
            update_option('apex_blog_featured_post_id_' . $page_slug, intval($_POST['apex_blog_featured_post_id']));
            // Categories Section - Removed (now uses WordPress category taxonomy dynamically)
            
            // Newsletter Section
            update_option('apex_blog_newsletter_heading_' . $page_slug, sanitize_text_field($_POST['apex_blog_newsletter_heading']));
            update_option('apex_blog_newsletter_description_' . $page_slug, sanitize_textarea_field($_POST['apex_blog_newsletter_description']));
            update_option('apex_blog_newsletter_placeholder_' . $page_slug, sanitize_text_field($_POST['apex_blog_newsletter_placeholder']));
            update_option('apex_blog_newsletter_button_' . $page_slug, sanitize_text_field($_POST['apex_blog_newsletter_button']));
            update_option('apex_blog_newsletter_note_' . $page_slug, sanitize_text_field($_POST['apex_blog_newsletter_note']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Blog content saved successfully! All sections including hero, featured article, categories, and newsletter have been updated.</p></div>';
        } elseif ($page_slug === 'insights-whitepapers-reports') {
            // Save Insights Whitepapers & Reports specific sections
            
            // Hero Section
            update_option('apex_reports_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_reports_hero_badge']));
            update_option('apex_reports_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_reports_hero_heading']));
            update_option('apex_reports_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_hero_description']));
            update_option('apex_reports_hero_image_' . $page_slug, esc_url_raw($_POST['apex_reports_hero_image']));
            update_option('apex_reports_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_hero_stats']));
            
            // Featured Report Section
            update_option('apex_reports_featured_badge_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_badge']));
            update_option('apex_reports_featured_image_' . $page_slug, esc_url_raw($_POST['apex_reports_featured_image']));
            update_option('apex_reports_featured_type_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_type']));
            update_option('apex_reports_featured_date_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_date']));
            update_option('apex_reports_featured_title_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_title']));
            update_option('apex_reports_featured_excerpt_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_featured_excerpt']));
            update_option('apex_reports_featured_highlights_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_featured_highlights']));
            update_option('apex_reports_featured_pages_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_pages']));
            update_option('apex_reports_featured_format_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_format']));
            update_option('apex_reports_featured_link_' . $page_slug, sanitize_text_field($_POST['apex_reports_featured_link']));
            
            // Categories Section
            update_option('apex_reports_categories_heading_' . $page_slug, sanitize_text_field($_POST['apex_reports_categories_heading']));
            update_option('apex_reports_categories_items_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_categories_items']));
            
            // Custom Research Section
            update_option('apex_reports_custom_badge_' . $page_slug, sanitize_text_field($_POST['apex_reports_custom_badge']));
            update_option('apex_reports_custom_heading_' . $page_slug, sanitize_text_field($_POST['apex_reports_custom_heading']));
            update_option('apex_reports_custom_description_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_custom_description']));
            update_option('apex_reports_custom_services_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_custom_services']));
            update_option('apex_reports_custom_image_' . $page_slug, esc_url_raw($_POST['apex_reports_custom_image']));
            update_option('apex_reports_custom_link_' . $page_slug, sanitize_text_field($_POST['apex_reports_custom_link']));
            
            // Newsletter Section
            update_option('apex_reports_newsletter_heading_' . $page_slug, sanitize_text_field($_POST['apex_reports_newsletter_heading']));
            update_option('apex_reports_newsletter_description_' . $page_slug, sanitize_textarea_field($_POST['apex_reports_newsletter_description']));
            update_option('apex_reports_newsletter_placeholder_' . $page_slug, sanitize_text_field($_POST['apex_reports_newsletter_placeholder']));
            update_option('apex_reports_newsletter_button_' . $page_slug, sanitize_text_field($_POST['apex_reports_newsletter_button']));
            update_option('apex_reports_newsletter_note_' . $page_slug, sanitize_text_field($_POST['apex_reports_newsletter_note']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Whitepapers & Reports content saved successfully! All sections including hero, featured report, categories, and newsletter have been updated.</p></div>';
        } elseif ($page_slug === 'partners') {
            // Save Partners Page specific sections
            
            // Hero Section
            update_option('apex_partners_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_partners_hero_badge']));
            update_option('apex_partners_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_hero_heading']));
            update_option('apex_partners_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_hero_description']));
            update_option('apex_partners_hero_image_' . $page_slug, esc_url_raw($_POST['apex_partners_hero_image']));
            update_option('apex_partners_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_hero_stats']));
            
            // Benefits Section
            update_option('apex_partners_benefits_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_benefits_heading']));
            update_option('apex_partners_benefits_description_' . $page_slug, sanitize_text_field($_POST['apex_partners_benefits_description']));
            update_option('apex_partners_benefits_items_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_benefits_items']));
            
            // Partnership Models Section
            update_option('apex_partners_models_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_models_heading']));
            update_option('apex_partners_models_description_' . $page_slug, sanitize_text_field($_POST['apex_partners_models_description']));
            update_option('apex_partners_models_items_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_models_items']));
            
            // Onboarding Process Section
            update_option('apex_partners_process_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_process_heading']));
            update_option('apex_partners_process_description_' . $page_slug, sanitize_text_field($_POST['apex_partners_process_description']));
            update_option('apex_partners_process_steps_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_process_steps']));
            
            // Partner Logos Section
            update_option('apex_partners_logos_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_logos_heading']));
            update_option('apex_partners_logos_description_' . $page_slug, sanitize_text_field($_POST['apex_partners_logos_description']));
            update_option('apex_partners_logos_items_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_logos_items']));
            
            // Testimonial Section
            update_option('apex_partners_testimonial_badge_' . $page_slug, sanitize_text_field($_POST['apex_partners_testimonial_badge']));
            update_option('apex_partners_testimonial_heading_' . $page_slug, sanitize_text_field($_POST['apex_partners_testimonial_heading']));
            update_option('apex_partners_testimonial_quote_' . $page_slug, sanitize_textarea_field($_POST['apex_partners_testimonial_quote']));
            update_option('apex_partners_testimonial_author_name_' . $page_slug, sanitize_text_field($_POST['apex_partners_testimonial_author_name']));
            update_option('apex_partners_testimonial_author_title_' . $page_slug, sanitize_text_field($_POST['apex_partners_testimonial_author_title']));
            update_option('apex_partners_testimonial_author_image_' . $page_slug, esc_url_raw($_POST['apex_partners_testimonial_author_image']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Partners content saved successfully! All sections including hero, benefits, partnership models, and testimonial have been updated.</p></div>';
        } elseif ($page_slug === 'developers') {
            // Save Developers Page specific sections
            
            // Hero Section
            update_option('apex_dev_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_dev_hero_badge']));
            update_option('apex_dev_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_dev_hero_heading']));
            update_option('apex_dev_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_hero_description']));
            update_option('apex_dev_hero_image_' . $page_slug, esc_url_raw($_POST['apex_dev_hero_image']));
            update_option('apex_dev_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_hero_stats']));
            
            // APIs Section
            update_option('apex_dev_apis_heading_' . $page_slug, sanitize_text_field($_POST['apex_dev_apis_heading']));
            update_option('apex_dev_apis_description_' . $page_slug, sanitize_text_field($_POST['apex_dev_apis_description']));
            update_option('apex_dev_apis_items_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_apis_items']));
            
            // SDKs Section
            update_option('apex_dev_sdks_heading_' . $page_slug, sanitize_text_field($_POST['apex_dev_sdks_heading']));
            update_option('apex_dev_sdks_description_' . $page_slug, sanitize_text_field($_POST['apex_dev_sdks_description']));
            update_option('apex_dev_sdks_items_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_sdks_items']));
            
            // Quick Start Section
            update_option('apex_dev_quick_heading_' . $page_slug, sanitize_text_field($_POST['apex_dev_quick_heading']));
            update_option('apex_dev_quick_description_' . $page_slug, sanitize_text_field($_POST['apex_dev_quick_description']));
            update_option('apex_dev_quick_steps_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_quick_steps']));
            update_option('apex_dev_quick_code_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_quick_code']));
            
            // Developer Support Section
            update_option('apex_dev_support_heading_' . $page_slug, sanitize_text_field($_POST['apex_dev_support_heading']));
            update_option('apex_dev_support_description_' . $page_slug, sanitize_text_field($_POST['apex_dev_support_description']));
            update_option('apex_dev_support_items_' . $page_slug, sanitize_textarea_field($_POST['apex_dev_support_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Developers content saved successfully! All sections including hero, APIs, SDKs, quick start, and support have been updated.</p></div>';
        } elseif ($page_slug === 'knowledge-base') {
            // Save Knowledge Base Page specific sections
            
            // Hero Section
            update_option('apex_kb_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_kb_hero_badge']));
            update_option('apex_kb_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_kb_hero_heading']));
            update_option('apex_kb_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_kb_hero_description']));
            update_option('apex_kb_hero_image_' . $page_slug, esc_url_raw($_POST['apex_kb_hero_image']));
            update_option('apex_kb_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_kb_hero_stats']));
            
            // Search Section
            update_option('apex_kb_search_heading_' . $page_slug, sanitize_text_field($_POST['apex_kb_search_heading']));
            update_option('apex_kb_search_description_' . $page_slug, sanitize_text_field($_POST['apex_kb_search_description']));
            update_option('apex_kb_search_placeholder_' . $page_slug, sanitize_text_field($_POST['apex_kb_search_placeholder']));
            update_option('apex_kb_search_button_' . $page_slug, sanitize_text_field($_POST['apex_kb_search_button']));
            update_option('apex_kb_search_suggestions_' . $page_slug, sanitize_textarea_field($_POST['apex_kb_search_suggestions']));
            
            // Categories Section
            update_option('apex_kb_categories_heading_' . $page_slug, sanitize_text_field($_POST['apex_kb_categories_heading']));
            update_option('apex_kb_categories_items_' . $page_slug, sanitize_textarea_field($_POST['apex_kb_categories_items']));
            
            // Popular Articles Section
            update_option('apex_kb_articles_heading_' . $page_slug, sanitize_text_field($_POST['apex_kb_articles_heading']));
            update_option('apex_kb_articles_description_' . $page_slug, sanitize_text_field($_POST['apex_kb_articles_description']));
            update_option('apex_kb_articles_items_' . $page_slug, sanitize_textarea_field($_POST['apex_kb_articles_items']));
            
            // Video Tutorials Section
            update_option('apex_kb_videos_heading_' . $page_slug, sanitize_text_field($_POST['apex_kb_videos_heading']));
            update_option('apex_kb_videos_description_' . $page_slug, sanitize_text_field($_POST['apex_kb_videos_description']));
            update_option('apex_kb_videos_items_' . $page_slug, sanitize_textarea_field($_POST['apex_kb_videos_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Knowledge Base content saved successfully! All sections including hero, search, categories, articles, and videos have been updated.</p></div>';
        } elseif ($page_slug === 'faq') {
            // Save FAQ Page specific sections
            
            // Hero Section
            update_option('apex_faq_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_faq_hero_badge']));
            update_option('apex_faq_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_faq_hero_heading']));
            update_option('apex_faq_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_hero_description']));
            update_option('apex_faq_hero_image_' . $page_slug, esc_url_raw($_POST['apex_faq_hero_image']));
            update_option('apex_faq_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_hero_stats']));
            
            // FAQ Section Items
            update_option('apex_faq_general_items_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_general_items']));
            update_option('apex_faq_products_items_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_products_items']));
            update_option('apex_faq_pricing_items_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_pricing_items']));
            update_option('apex_faq_technical_items_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_technical_items']));
            update_option('apex_faq_security_items_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_security_items']));
            update_option('apex_faq_billing_items_' . $page_slug, sanitize_textarea_field($_POST['apex_faq_billing_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>FAQ content saved successfully! All sections including hero and 6 FAQ categories have been updated.</p></div>';
        } elseif ($page_slug === 'help-support') {
            // Save Help & Support Page specific sections
            
            // Hero Section
            update_option('apex_support_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_support_hero_badge']));
            update_option('apex_support_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_support_hero_heading']));
            update_option('apex_support_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_support_hero_description']));
            update_option('apex_support_hero_image_' . $page_slug, esc_url_raw($_POST['apex_support_hero_image']));
            update_option('apex_support_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_support_hero_stats']));
            
            // Support Channels Section
            update_option('apex_support_channels_heading_' . $page_slug, sanitize_text_field($_POST['apex_support_channels_heading']));
            update_option('apex_support_channels_description_' . $page_slug, sanitize_text_field($_POST['apex_support_channels_description']));
            update_option('apex_support_channels_items_' . $page_slug, sanitize_textarea_field($_POST['apex_support_channels_items']));
            
            // Contact Section
            update_option('apex_support_contact_heading_' . $page_slug, sanitize_text_field($_POST['apex_support_contact_heading']));
            update_option('apex_support_contact_description_' . $page_slug, sanitize_text_field($_POST['apex_support_contact_description']));
            update_option('apex_support_contact_items_' . $page_slug, sanitize_textarea_field($_POST['apex_support_contact_items']));
            
            // Resources Section
            update_option('apex_support_resources_heading_' . $page_slug, sanitize_text_field($_POST['apex_support_resources_heading']));
            update_option('apex_support_resources_description_' . $page_slug, sanitize_text_field($_POST['apex_support_resources_description']));
            update_option('apex_support_resources_items_' . $page_slug, sanitize_textarea_field($_POST['apex_support_resources_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Help & Support content saved successfully! All sections including hero, channels, contact, and resources have been updated.</p></div>';
        } elseif ($page_slug === 'careers') {
            // Save Careers Page specific sections
            
            // Hero Section
            update_option('apex_careers_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_careers_hero_badge']));
            update_option('apex_careers_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_careers_hero_heading']));
            update_option('apex_careers_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_careers_hero_description']));
            update_option('apex_careers_hero_image_' . $page_slug, esc_url_raw($_POST['apex_careers_hero_image']));
            update_option('apex_careers_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_careers_hero_stats']));
            
            // Why Work at Apex Section
            update_option('apex_careers_why_heading_' . $page_slug, sanitize_text_field($_POST['apex_careers_why_heading']));
            update_option('apex_careers_why_description_' . $page_slug, sanitize_text_field($_POST['apex_careers_why_description']));
            update_option('apex_careers_why_items_' . $page_slug, sanitize_textarea_field($_POST['apex_careers_why_items']));
            
            // Open Positions Section
            update_option('apex_careers_openings_heading_' . $page_slug, sanitize_text_field($_POST['apex_careers_openings_heading']));
            update_option('apex_careers_openings_description_' . $page_slug, sanitize_text_field($_POST['apex_careers_openings_description']));
            update_option('apex_careers_openings_items_' . $page_slug, sanitize_textarea_field($_POST['apex_careers_openings_items']));
            
            // Our Culture Section
            update_option('apex_careers_culture_heading_' . $page_slug, sanitize_text_field($_POST['apex_careers_culture_heading']));
            update_option('apex_careers_culture_description_' . $page_slug, sanitize_text_field($_POST['apex_careers_culture_description']));
            update_option('apex_careers_culture_items_' . $page_slug, sanitize_textarea_field($_POST['apex_careers_culture_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Careers content saved successfully! All sections including hero, benefits, openings, and culture have been updated.</p></div>';
        } elseif ($page_slug === 'insights-webinars') {
            // Save Insights Webinars specific sections
            
            // Hero Section
            update_option('apex_webinars_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_webinars_hero_badge']));
            update_option('apex_webinars_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_webinars_hero_heading']));
            update_option('apex_webinars_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_hero_description']));
            update_option('apex_webinars_hero_image_' . $page_slug, esc_url_raw($_POST['apex_webinars_hero_image']));
            update_option('apex_webinars_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_hero_stats']));
            
            // Upcoming Events Section
            update_option('apex_webinars_upcoming_badge_' . $page_slug, sanitize_text_field($_POST['apex_webinars_upcoming_badge']));
            update_option('apex_webinars_upcoming_heading_' . $page_slug, sanitize_text_field($_POST['apex_webinars_upcoming_heading']));
            update_option('apex_webinars_upcoming_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_upcoming_description']));
            
            // Featured Webinar Section
            update_option('apex_webinars_featured_badge_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_badge']));
            update_option('apex_webinars_featured_day_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_day']));
            update_option('apex_webinars_featured_month_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_month']));
            update_option('apex_webinars_featured_type_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_type']));
            update_option('apex_webinars_featured_title_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_title']));
            update_option('apex_webinars_featured_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_featured_description']));
            update_option('apex_webinars_featured_time_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_time']));
            update_option('apex_webinars_featured_duration_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_duration']));
            update_option('apex_webinars_featured_speakers_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_speakers']));
            update_option('apex_webinars_featured_image_' . $page_slug, esc_url_raw($_POST['apex_webinars_featured_image']));
            update_option('apex_webinars_featured_link_' . $page_slug, sanitize_text_field($_POST['apex_webinars_featured_link']));
            
            // Conference Section
            update_option('apex_webinars_conf_badge_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_badge']));
            update_option('apex_webinars_conf_heading_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_heading']));
            update_option('apex_webinars_conf_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_conf_description']));
            update_option('apex_webinars_conf_date_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_date']));
            update_option('apex_webinars_conf_location_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_location']));
            update_option('apex_webinars_conf_attendees_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_attendees']));
            update_option('apex_webinars_conf_highlights_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_conf_highlights']));
            update_option('apex_webinars_conf_image_' . $page_slug, esc_url_raw($_POST['apex_webinars_conf_image']));
            update_option('apex_webinars_conf_register_link_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_register_link']));
            update_option('apex_webinars_conf_agenda_link_' . $page_slug, sanitize_text_field($_POST['apex_webinars_conf_agenda_link']));
            
            // On-Demand Section
            update_option('apex_webinars_ondemand_badge_' . $page_slug, sanitize_text_field($_POST['apex_webinars_ondemand_badge']));
            update_option('apex_webinars_ondemand_heading_' . $page_slug, sanitize_text_field($_POST['apex_webinars_ondemand_heading']));
            update_option('apex_webinars_ondemand_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_ondemand_description']));
            
            // Speakers Section
            update_option('apex_webinars_speakers_badge_' . $page_slug, sanitize_text_field($_POST['apex_webinars_speakers_badge']));
            update_option('apex_webinars_speakers_heading_' . $page_slug, sanitize_text_field($_POST['apex_webinars_speakers_heading']));
            update_option('apex_webinars_speakers_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_speakers_description']));
            
            // Newsletter Section
            update_option('apex_webinars_newsletter_heading_' . $page_slug, sanitize_text_field($_POST['apex_webinars_newsletter_heading']));
            update_option('apex_webinars_newsletter_description_' . $page_slug, sanitize_textarea_field($_POST['apex_webinars_newsletter_description']));
            update_option('apex_webinars_newsletter_placeholder_' . $page_slug, sanitize_text_field($_POST['apex_webinars_newsletter_placeholder']));
            update_option('apex_webinars_newsletter_button_' . $page_slug, sanitize_text_field($_POST['apex_webinars_newsletter_button']));
            update_option('apex_webinars_newsletter_note_' . $page_slug, sanitize_text_field($_POST['apex_webinars_newsletter_note']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Webinars content saved successfully! All sections including hero, upcoming events, conference, and speakers have been updated.</p></div>';
        } elseif ($page_slug === 'insights-success-stories') {
            // Save Insights Success Stories specific sections
            
            // Hero Section
            update_option('apex_stories_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_stories_hero_badge']));
            update_option('apex_stories_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_stories_hero_heading']));
            update_option('apex_stories_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_stories_hero_description']));
            update_option('apex_stories_hero_image_' . $page_slug, esc_url_raw($_POST['apex_stories_hero_image']));
            update_option('apex_stories_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_stories_hero_stats']));
            
            // Featured Story Section
            update_option('apex_stories_featured_badge_' . $page_slug, sanitize_text_field($_POST['apex_stories_featured_badge']));
            update_option('apex_stories_featured_image_' . $page_slug, esc_url_raw($_POST['apex_stories_featured_image']));
            update_option('apex_stories_featured_logo_' . $page_slug, sanitize_text_field($_POST['apex_stories_featured_logo']));
            update_option('apex_stories_featured_category_' . $page_slug, sanitize_text_field($_POST['apex_stories_featured_category']));
            update_option('apex_stories_featured_title_' . $page_slug, sanitize_text_field($_POST['apex_stories_featured_title']));
            update_option('apex_stories_featured_excerpt_' . $page_slug, sanitize_textarea_field($_POST['apex_stories_featured_excerpt']));
            update_option('apex_stories_featured_results_' . $page_slug, sanitize_textarea_field($_POST['apex_stories_featured_results']));
            update_option('apex_stories_featured_link_' . $page_slug, sanitize_text_field($_POST['apex_stories_featured_link']));
            
            // Impact Stats Section
            update_option('apex_stories_impact_badge_' . $page_slug, sanitize_text_field($_POST['apex_stories_impact_badge']));
            update_option('apex_stories_impact_heading_' . $page_slug, sanitize_text_field($_POST['apex_stories_impact_heading']));
            update_option('apex_stories_impact_description_' . $page_slug, sanitize_textarea_field($_POST['apex_stories_impact_description']));
            update_option('apex_stories_impact_items_' . $page_slug, sanitize_textarea_field($_POST['apex_stories_impact_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Success Stories content saved successfully! All sections including hero, featured story, and impact stats have been updated.</p></div>';
        } elseif ($page_slug === 'request-demo') {
            // Save Request Demo specific sections
            update_option('apex_demo_form_heading_' . $page_slug, sanitize_text_field($_POST['apex_demo_form_heading']));
            update_option('apex_demo_form_description_' . $page_slug, sanitize_textarea_field($_POST['apex_demo_form_description']));
            
            update_option('apex_demo_expect_title_' . $page_slug, sanitize_text_field($_POST['apex_demo_expect_title']));
            update_option('apex_demo_expect_items_' . $page_slug, sanitize_textarea_field($_POST['apex_demo_expect_items']));
            
            update_option('apex_demo_help_title_' . $page_slug, sanitize_text_field($_POST['apex_demo_help_title']));
            update_option('apex_demo_help_description_' . $page_slug, sanitize_text_field($_POST['apex_demo_help_description']));
            update_option('apex_demo_phone_' . $page_slug, sanitize_text_field($_POST['apex_demo_phone']));
            update_option('apex_demo_email_' . $page_slug, sanitize_email($_POST['apex_demo_email']));
            
            update_option('apex_demo_materials_title_' . $page_slug, sanitize_text_field($_POST['apex_demo_materials_title']));
            update_option('apex_demo_materials_description_' . $page_slug, sanitize_text_field($_POST['apex_demo_materials_description']));
            update_option('apex_demo_materials_items_' . $page_slug, sanitize_textarea_field($_POST['apex_demo_materials_items']));
            
            update_option('apex_demo_webinars_title_' . $page_slug, sanitize_text_field($_POST['apex_demo_webinars_title']));
            update_option('apex_demo_webinars_description_' . $page_slug, sanitize_text_field($_POST['apex_demo_webinars_description']));
            update_option('apex_demo_webinars_items_' . $page_slug, sanitize_textarea_field($_POST['apex_demo_webinars_items']));
            
            echo '<div class="notice notice-success is-dismissible"><p>Request Demo content saved successfully! All sections with form, sidebar, training materials, and webinars have been updated.</p></div>';
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
                        <th scope="row"><label>Business Hours</label></th>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div>
                                    <label for="apex_footer_weekday_hours" style="display: block; font-weight: 600; margin-bottom: 5px;">Weekdays (Mon - Fri):</label>
                                    <input type="text" id="apex_footer_weekday_hours" name="apex_footer_weekday_hours" 
                                           value="<?php echo esc_attr(get_option('apex_footer_weekday_hours', '8am - 6pm')); ?>" 
                                           class="regular-text" placeholder="e.g., 8am - 6pm">
                                </div>
                                <div>
                                    <label for="apex_footer_saturday_hours" style="display: block; font-weight: 600; margin-bottom: 5px;">Saturday:</label>
                                    <input type="text" id="apex_footer_saturday_hours" name="apex_footer_saturday_hours" 
                                           value="<?php echo esc_attr(get_option('apex_footer_saturday_hours', '8am - 1pm')); ?>" 
                                           class="regular-text" placeholder="e.g., 8am - 1pm">
                                </div>
                                <div>
                                    <label for="apex_footer_sunday_holiday_status" style="display: block; font-weight: 600; margin-bottom: 5px;">Sunday & Holidays:</label>
                                    <input type="text" id="apex_footer_sunday_holiday_status" name="apex_footer_sunday_holiday_status" 
                                           value="<?php echo esc_attr(get_option('apex_footer_sunday_holiday_status', 'Closed')); ?>" 
                                           class="regular-text" placeholder="e.g., Closed">
                                </div>
                            </div>
                            <p class="description">Enter your business operating hours for each time period</p>
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
        
        // Save Business Hours
        update_option('apex_footer_weekday_hours', sanitize_text_field($_POST['apex_footer_weekday_hours']));
        update_option('apex_footer_saturday_hours', sanitize_text_field($_POST['apex_footer_saturday_hours']));
        update_option('apex_footer_sunday_holiday_status', sanitize_text_field($_POST['apex_footer_sunday_holiday_status']));
        
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
        'insights/success-stories' => 'page-insights-success-stories.php',
        'insights/webinars' => 'page-insights-webinars.php',
        'insights/whitepapers-reports' => 'page-insights-whitepapers-reports.php',
    ];
    
    // Check for exact match first (strip trailing slash)
    $clean_uri = rtrim($request_uri, '/');
    
    // Check for paginated URLs like insights/blog/page/2
    $paged = 1;
    if (preg_match('#^(insights/[a-z-]+)/page/(\d+)/?$#', $clean_uri, $matches)) {
        $clean_uri = $matches[1];
        $paged = intval($matches[2]);
    }
    
    if (isset($insights_templates[$clean_uri])) {
        // Reset 404 status and set proper headers
        global $wp_query;
        $wp_query->is_404 = false;
        $wp_query->is_page = true;
        status_header(200);
        header('HTTP/1.1 200 OK');
        
        // Set the paged query var so WP_Query can use it
        set_query_var('paged', $paged);
        $GLOBALS['paged'] = $paged;
        
        // Load the template directly
        $template = get_template_directory() . '/' . $insights_templates[$clean_uri];
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


// Helper function to estimate reading time
function reading_time() {
    $content = get_the_content();
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assuming 200 words per minute
    return $reading_time;
}

// Custom rewrite rules for blog posts
function apex_blog_rewrite_rules() {
    add_rewrite_rule('^insights/blog/([^/]+)/?$', 'index.php?name=$matches[1]', 'top');
    
    // One-time flush of rewrite rules
    if (!get_option('apex_blog_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('apex_blog_rewrite_flushed', true);
    }
}
add_action('init', 'apex_blog_rewrite_rules');

// Flush rewrite rules on theme activation (for development)
function apex_flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'apex_flush_rewrite_rules_on_activation');

// Redirect old URLs to new structure
function apex_redirect_old_post_urls() {
    if (is_single() && !is_admin() && get_post_type() == 'post') {
        $current_url = $_SERVER['REQUEST_URI'];
        $post_slug = get_post_field('post_name', get_the_ID());
        $old_pattern = '/' . get_the_date('Y/m/d') . '/' . $post_slug . '/';
        
        if (strpos($current_url, $old_pattern) !== false) {
            $new_url = home_url('/insights/blog/' . $post_slug . '/');
            wp_redirect($new_url, 301);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_redirect_old_post_urls');

// Custom permalink for posts
function apex_custom_post_link($permalink, $post) {
    if ($post->post_type == 'post') {
        $permalink = home_url('/insights/blog/' . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_link', 'apex_custom_post_link', 10, 2);

// Custom single template for insight blog posts
function apex_single_template($template) {
    if (is_single() && get_post_type() == 'post') {
        $custom_template = locate_template('single-insight-blog.php');
        if ($custom_template) {
            return $custom_template;
        }
    }
    return $template;
}
add_filter('single_template', 'apex_single_template');
