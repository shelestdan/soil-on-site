<?php
declare(strict_types=1);

const QUOTE_TO = 'soilonsitensw@gmail.com';
const MAX_UPLOAD_BYTES = 16777216; // 16 MB

function google_tag_html() {
    return '<script async src="https://www.googletagmanager.com/gtag/js?id=AW-18170578951"></script>'
        . '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}'
        . 'gtag("js",new Date());gtag("config","AW-18170578951");</script>';
}

function clean_text($value, $max = 2000) {
    $value = is_string($value) ? $value : '';
    $value = str_replace(["\r", "\0"], ['', ''], $value);
    $value = trim(strip_tags($value));
    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $max, 'UTF-8');
    }
    return substr($value, 0, $max);
}

function clean_header($value, $max = 200) {
    $value = clean_text($value, $max);
    return str_replace(["\n", "\r"], ' ', $value);
}

function html_response($title, $message, $ok = true) {
    http_response_code($ok ? 200 : 400);
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo google_tag_html();
    echo '<title>' . $safeTitle . ' | Soil On Site</title>';
    echo '<style>body{margin:0;font-family:Arial,sans-serif;background:#eef7ff;color:#0b1f3d;display:grid;min-height:100vh;place-items:center}.box{max-width:620px;margin:24px;padding:34px;border-radius:18px;background:#fff;box-shadow:0 18px 55px rgba(13,54,94,.14)}h1{margin:0 0 14px;font-size:32px}.ok{color:#124f86}.err{color:#b42318}p{font-size:18px;line-height:1.55}a{display:inline-block;margin-top:12px;color:#124f86;font-weight:700}</style>';
    echo '</head><body><main class="box">';
    echo '<h1 class="' . ($ok ? 'ok' : 'err') . '">' . $safeTitle . '</h1>';
    echo '<p>' . $safeMessage . '</p>';
    echo '<a href="/#quote">Back to the quote form</a>';
    echo '</main></body></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /#quote', true, 303);
    exit;
}

if (!empty($_POST['_honey'])) {
    header('Location: /thank-you.html', true, 303);
    exit;
}

$name = clean_text($_POST['name'] ?? '', 100);
$phone = clean_text($_POST['phone'] ?? '', 40);
$email = clean_header($_POST['email'] ?? '', 254);
$address = clean_text($_POST['address'] ?? '', 200);

if ($name === '' || $phone === '' || $address === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    html_response('Form not sent', 'Please complete your name, phone, email address, and site address.', false);
}

$fields = [
    'Name' => $name,
    'Phone' => $phone,
    'Email' => $email,
    'Site address / lot' => $address,
    'Project type' => clean_text($_POST['project_type'] ?? '', 120),
    'Bedrooms in main residence' => clean_text($_POST['bedrooms_main'] ?? '', 80),
    'Bedrooms in secondary building' => clean_text($_POST['bedrooms_secondary'] ?? '', 80),
    'Dwellings/buildings connected' => clean_text($_POST['dwellings'] ?? '', 80),
    'Message' => clean_text($_POST['message'] ?? '', 2000),
];

$body = "New Soil On Site quote request\n\n";
foreach ($fields as $label => $value) {
    $body .= $label . ":\n" . ($value !== '' ? $value : '-') . "\n\n";
}

$subject = 'New Soil On Site quote request';
$from = 'Soil On Site Website <noreply@soilonsite.com.au>';
$replyTo = $email;
$boundary = 'soilonsite_' . md5((string)microtime(true));
$headers = [
    'From: ' . $from,
    'Reply-To: ' . $replyTo,
    'MIME-Version: 1.0',
];

$hasAttachment = isset($_FILES['attachment']) && is_array($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE;

if ($hasAttachment) {
    $file = $_FILES['attachment'];
    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png', 'dwg', 'doc', 'docx'];
    $originalName = clean_header($file['name'] ?? 'attachment', 180);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($file['error'] !== UPLOAD_ERR_OK) {
        html_response('Form not sent', 'The file upload failed. Please try again without the attachment, or email the plans directly.', false);
    }
    if ((int)$file['size'] > MAX_UPLOAD_BYTES || !in_array($ext, $allowedExt, true)) {
        html_response('Form not sent', 'The attachment must be PDF, DWG, JPG, PNG, DOC, or DOCX and no larger than 16 MB.', false);
    }

    $content = chunk_split(base64_encode((string)file_get_contents($file['tmp_name'])));
    $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
    $message = "--{$boundary}\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\n";
    $message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message .= $body . "\n";
    $message .= "--{$boundary}\n";
    $message .= "Content-Type: application/octet-stream; name=\"" . addslashes($originalName) . "\"\n";
    $message .= "Content-Transfer-Encoding: base64\n";
    $message .= "Content-Disposition: attachment; filename=\"" . addslashes($originalName) . "\"\n\n";
    $message .= $content . "\n";
    $message .= "--{$boundary}--";
} else {
    $headers[] = 'Content-Type: text/plain; charset=UTF-8';
    $message = $body;
}

$sent = mail(QUOTE_TO, $subject, $message, implode("\r\n", $headers));

if (!$sent) {
    html_response('Form not sent', 'The server could not send the email. Please email soilonsitensw@gmail.com directly.', false);
}

header('Location: /thank-you.html', true, 303);
exit;
