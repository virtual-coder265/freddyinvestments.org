<?php
namespace App\Controllers;

use App\Models\Message;

/**
 * ContactController - Securely processes contact form submissions
 */
class ContactController {
    
    public function submit() {
        // 1. Enforce POST request only
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('contact'));
            exit;
        }

        // 2. Validate CSRF Token
        $csrfToken = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['form_errors'] = ['security' => 'Invalid security token. Please resubmit the form.'];
            header('Location: ' . url('contact'));
            exit;
        }

        // 3. Enforce Rate Limiting (60 seconds between submissions)
        $currentTime = time();
        if (isset($_SESSION['last_submission_time'])) {
            $timeElapsed = $currentTime - $_SESSION['last_submission_time'];
            if ($timeElapsed < 60) {
                $secondsLeft = 60 - $timeElapsed;
                $_SESSION['form_errors'] = ['security' => "Please wait {$secondsLeft} seconds before sending another message."];
                $_SESSION['form_old'] = $_POST;
                header('Location: ' . url('contact'));
                exit;
            }
        }

        // 4. Sanitize Inputs
        $name = isset($_POST['name']) ? sanitize_cms($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_cms($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_cms($_POST['phone']) : '';
        $service = isset($_POST['service']) ? sanitize_cms($_POST['service']) : '';
        $message = isset($_POST['message']) ? sanitize_cms($_POST['message']) : '';

        // Preserved inputs in case of validation failures
        $oldInputs = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service' => $service,
            'message' => $message
        ];

        // 5. Backend Validation Checklist
        $errors = [];

        if (empty($name) || strlen($name) < 2 || strlen($name) > 100) {
            $errors['name'] = 'Full name must be between 2 and 100 characters.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if (!empty($phone) && !preg_match('/^[+0-9\-\(\)\s]{7,25}$/', $phone)) {
            $errors['phone'] = 'Please enter a valid phone number (7-25 digits, spaces, hyphens, and brackets allowed).';
        }

        if (empty($service)) {
            $errors['service'] = 'Please select a service of interest.';
        }

        if (empty($message) || strlen($message) < 10 || strlen($message) > 3000) {
            $errors['message'] = 'Message must be between 10 and 3000 characters.';
        }

        // 6. Redirect on Failure
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old'] = $oldInputs;
            header('Location: ' . url('contact'));
            exit;
        }

        // 7. Success Processing: store in CMS messages, with JSON fallback for resilience.
        $logDir = dirname(dirname(__DIR__)) . '/storage/logs';
        $logFile = $logDir . '/contacts.json';
        $contactData = [
            'id' => uniqid('msg_', true),
            'timestamp' => date('Y-m-d H:i:s'),
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service' => $service,
            'message' => $message
        ];

        $storedInDatabase = false;
        try {
            Message::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'service' => $service,
                'message' => $message,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'status' => 'unread'
            ]);
            $storedInDatabase = true;
        } catch (\Throwable $e) {
            error_log('Contact message database storage failed: ' . $e->getMessage());
        }

        if (!$storedInDatabase) {
            if (!file_exists($logDir)) {
                mkdir($logDir, 0755, true);
            }

            $currentLog = [];
            if (file_exists($logFile)) {
                $jsonData = file_get_contents($logFile);
                $currentLog = json_decode($jsonData, true) ?: [];
            }
            $currentLog[] = $contactData;
            file_put_contents($logFile, json_encode($currentLog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        // 8. Attempt Email Dispatch
        $to = env('CONTACT_EMAIL', 'mphasifreddyinvestments@gmail.com');
        $subject = "New Contact Inquiry from " . $name . " [Freddy Investments]";
        
        $emailBody = "<h2>New Inbound Inquiry</h2>\n";
        $emailBody .= "<p><strong>Name:</strong> {$name}</p>\n";
        $emailBody .= "<p><strong>Email:</strong> {$email}</p>\n";
        $emailBody .= "<p><strong>Phone:</strong> " . ($phone ?: 'Not provided') . "</p>\n";
        $emailBody .= "<p><strong>Service Requested:</strong> {$service}</p>\n";
        $emailBody .= "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>\n";
        $emailBody .= "<hr><p><small>Sent via Freddy Investments secure contact portal. Client IP: {$_SERVER['REMOTE_ADDR']}</small></p>";

        // Headers for HTML Mail
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: secure-portal@freddyinvestments.org" . "\r\n";
        $headers .= "Reply-To: {$email}" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send email
        $mailSent = @mail($to, $subject, $emailBody, $headers);

        // 9. Update Session state and Redirect back with Success Message
        $_SESSION['last_submission_time'] = $currentTime;
        $_SESSION['form_success'] = "Thank you, {$name}! Your message has been securely submitted and logged. Our team will contact you shortly.";
        
        // Remove preserved form state
        unset($_SESSION['form_old']);
        unset($_SESSION['form_errors']);
        
        header('Location: ' . url('contact') . '?status=success');
        exit;
    }
}
