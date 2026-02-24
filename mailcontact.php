<?php
header('Content-Type: application/json');

// ✅ collect form data (form ke hisaab se)
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// ✅ validation
if (!$email || !$message || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'msg' => 'Invalid input'
    ]);
    exit;
}

// ✅ receiver email
$to = 'contact@fluxorae.in'; // change if needed

// ✅ headers
$headers = "From: Website Contact <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// ✅ mail body
$mailBody  = "Email: $email\n";
$mailBody .= "Phone: $phone\n\n";
$mailBody .= "Message:\n$message";

// ✅ send mail
if (mail($to, 'New Contact Form Message', $mailBody, $headers)) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'msg' => 'Mail could not be sent'
    ]);
}
