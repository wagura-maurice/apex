<?php
/**
 * Direct SMTP Email Test Script
 * This script tests Mailtrap SMTP directly without WordPress
 */

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Direct SMTP Email Test</h1>";
echo "<p>Testing Mailtrap SMTP connection directly...</p>";

// Include PHPMailer directly
require_once '/var/www/html/apex/wp-includes/PHPMailer/PHPMailer.php';
require_once '/var/www/html/apex/wp-includes/PHPMailer/SMTP.php';
require_once '/var/www/html/apex/wp-includes/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'be6e87f82be3a7';
    $mail->Password   = '2b1dadf3db173f';
    $mail->SMTPSecure = ''; // No encryption for Mailtrap
    $mail->Port       = 2525;

    // Recipients
    $mail->setFrom('test@apex-softwares.com', 'Apex Test');
    $mail->addAddress('info@apex-softwares.com', 'Apex Info');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Direct SMTP Test - ' . date('Y-m-d H:i:s');
    $mail->Body    = '<h1>Direct SMTP Test</h1><p>This email was sent directly via PHPMailer SMTP.</p><p>Time: ' . date('Y-m-d H:i:s') . '</p>';
    $mail->AltBody = 'Direct SMTP Test - This email was sent directly via PHPMailer SMTP. Time: ' . date('Y-m-d H:i:s');

    echo "<p>Attempting to send email...</p>";

    $result = $mail->send();

    if ($result) {
        echo '<p style="color: green; font-weight: bold;">✓ SUCCESS: Email sent successfully via direct SMTP!</p>';
        echo '<p>Check your Mailtrap inbox for this email.</p>';
    } else {
        echo '<p style="color: red; font-weight: bold;">✗ FAILED: Email sending failed!</p>';
        echo '<p>Error: ' . $mail->ErrorInfo . '</p>';
    }

} catch (Exception $e) {
    echo '<p style="color: red; font-weight: bold;">✗ EXCEPTION: ' . $mail->ErrorInfo . '</p>';
}

// Check debug log
$debug_log = '/var/www/html/apex/wp-content/debug.log';
if (file_exists($debug_log)) {
    echo "<h2>Recent Debug Log Entries:</h2>";
    $log_content = file_get_contents($debug_log);
    $lines = explode("\n", $log_content);
    $recent_lines = array_slice($lines, -10);

    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd; max-height: 200px; overflow: auto;'>";
    foreach ($recent_lines as $line) {
        if (!empty($line) && strpos($line, 'Apex') !== false) {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo "</pre>";
}
?>
