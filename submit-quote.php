<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    ini_set('session.cookie_secure', '1');
}

session_start();

function redirectToForm(): void
{
    header('Location: contact.php#quote-form', true, 303);
    exit;
}

function inputValue(
    string $key,
    int $maximumLength,
    array &$errors,
    ?string $lengthErrorMessage = null
): string
{
    $value = isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
    $value = str_replace("\0", '', trim($value));

    if (strlen($value) > $maximumLength) {
        if ($lengthErrorMessage !== null) {
            $errors[$key] = $lengthErrorMessage;
            return substr($value, 0, $maximumLength);
        }

        return '';
    }

    return $value;
}

function containsHeaderBreak(string $value): bool
{
    return preg_match('/[\r\n]/', $value) === 1;
}

function sanitiseAttachmentFilename(string $originalName, string $extension): string
{
    $name = str_replace(['/', '\\'], '-', $originalName);
    $name = preg_replace('/[\x00-\x1F\x7F]+/', '', $name) ?? '';
    $stem = pathinfo($name, PATHINFO_FILENAME);
    $stem = preg_replace('/[^A-Za-z0-9_-]+/', '-', $stem) ?? '';
    $stem = trim(preg_replace('/-+/', '-', $stem) ?? '', '-_.');

    if ($stem === '') {
        $stem = 'artwork';
    }

    return substr($stem, 0, 100) . '.' . $extension;
}

function validateArtworkUpload(array &$errors): ?array
{
    $maximumBytes = 8 * 1024 * 1024;
    $file = $_FILES['artwork_file'] ?? null;

    if ($file === null) {
        return null;
    }

    if (!is_array($file) || !isset($file['error']) || is_array($file['error'])) {
        $errors['artwork_file'] = 'Your artwork file could not be uploaded. Please try again.';
        return null;
    }

    $uploadError = (int) $file['error'];
    if ($uploadError === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($uploadError === UPLOAD_ERR_INI_SIZE || $uploadError === UPLOAD_ERR_FORM_SIZE) {
        $errors['artwork_file'] = 'Your artwork file is too large. Please upload a file smaller than 8 MB.';
        return null;
    }

    $uploadErrorMessages = [
        UPLOAD_ERR_PARTIAL => 'Your artwork file was only partially uploaded. Please try again.',
        UPLOAD_ERR_NO_TMP_DIR => 'The server cannot accept artwork files right now. Please try again later.',
        UPLOAD_ERR_CANT_WRITE => 'The server could not process your artwork file. Please try again later.',
        UPLOAD_ERR_EXTENSION => 'The server rejected your artwork file. Please choose another file.',
    ];

    if ($uploadError !== UPLOAD_ERR_OK) {
        $errors['artwork_file'] = $uploadErrorMessages[$uploadError]
            ?? 'Your artwork file could not be uploaded. Please try again.';
        return null;
    }

    $size = isset($file['size']) && is_int($file['size']) ? $file['size'] : -1;
    if ($size < 0 || $size > $maximumBytes) {
        $errors['artwork_file'] = 'Your artwork file is too large. Please upload a file smaller than 8 MB.';
        return null;
    }

    $temporaryName = isset($file['tmp_name']) && is_string($file['tmp_name']) ? $file['tmp_name'] : '';
    $originalName = isset($file['name']) && is_string($file['name']) ? $file['name'] : '';
    if ($temporaryName === '' || !is_uploaded_file($temporaryName) || !is_file($temporaryName)) {
        $errors['artwork_file'] = 'Your artwork file could not be verified. Please try again.';
        return null;
    }

    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedTypes = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'pdf' => 'application/pdf',
        'svg' => 'image/svg+xml',
    ];

    if (!isset($allowedTypes[$extension])) {
        $errors['artwork_file'] = 'Please upload artwork as a PNG, JPG, PDF or SVG file.';
        return null;
    }

    if (!class_exists('finfo')) {
        $errors['artwork_file'] = 'The server cannot verify artwork files right now. Please try again later.';
        return null;
    }

    $fileInfo = new finfo(FILEINFO_MIME_TYPE);
    $detectedMime = $fileInfo->file($temporaryName);
    if (!is_string($detectedMime) || $detectedMime !== $allowedTypes[$extension]) {
        $errors['artwork_file'] = 'The artwork file type does not match its filename. Please upload a valid PNG, JPG, PDF or SVG file.';
        return null;
    }

    return [
        'path' => $temporaryName,
        'mime' => $detectedMime,
        'filename' => sanitiseAttachmentFilename($originalName, $extension),
    ];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'This endpoint accepts form submissions only.';
    exit;
}

unset($_SESSION['quote_success']);

$csrfToken = isset($_POST['csrf_token']) && is_string($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
$sessionToken = isset($_SESSION['quote_csrf_token']) && is_string($_SESSION['quote_csrf_token'])
    ? $_SESSION['quote_csrf_token']
    : '';

if ($sessionToken === '' || $csrfToken === '' || !hash_equals($sessionToken, $csrfToken)) {
    $_SESSION['quote_errors'] = ['quote-heading' => 'Your session could not be verified. Please reload the page and try again.'];
    redirectToForm();
}

$honeypot = isset($_POST['website']) && is_string($_POST['website']) ? trim($_POST['website']) : '';
if ($honeypot !== '') {
    unset($_SESSION['quote_old']);
    redirectToForm();
}

$cooldownSeconds = 60;
$lastSubmission = isset($_SESSION['quote_last_submission']) ? (int) $_SESSION['quote_last_submission'] : 0;
if ($lastSubmission > 0 && (time() - $lastSubmission) < $cooldownSeconds) {
    $_SESSION['quote_errors'] = ['quote-heading' => 'Please wait before submitting another enquiry.'];
    redirectToForm();
}

$errors = [];
$values = [
    'company_name' => inputValue('company_name', 120, $errors),
    'contact_name' => inputValue('contact_name', 120, $errors),
    'email' => inputValue('email', 254, $errors),
    'phone' => inputValue('phone', 40, $errors, 'Phone number is too long.'),
    'product_service' => inputValue('product_service', 80, $errors),
    'quantity' => inputValue('quantity', 80, $errors),
    'required_date' => inputValue('required_date', 10, $errors, 'Required date is invalid.'),
    'artwork_status' => inputValue('artwork_status', 80, $errors, 'Artwork status is invalid.'),
    'project_details' => inputValue('project_details', 3000, $errors),
];

$_SESSION['quote_old'] = $values;

$requiredLabels = [
    'company_name' => 'Enter your company name.',
    'contact_name' => 'Enter your contact name.',
    'email' => 'Enter your email address.',
    'product_service' => 'Select a product or service.',
    'quantity' => 'Enter an approximate quantity.',
    'project_details' => 'Tell us about your project.',
];

foreach ($requiredLabels as $field => $message) {
    if ($values[$field] === '') {
        $errors[$field] = $message;
    }
}

if ($values['email'] !== '' && filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
    $errors['email'] = 'Enter a valid email address.';
}

if (containsHeaderBreak($values['email']) || containsHeaderBreak($values['company_name'])) {
    $errors['email'] = 'Enter valid contact details.';
}

$allowedProducts = [
    'Printed Glassware',
    'Printed Glass Bottles',
    'Printed Jars',
    'Cosmetic Packaging',
    'Reusable Cups',
    'Plastic Drinkware',
    'Ceramics',
    'Beer Mats',
    'Premium Reusable Coasters',
    'Bespoke / Special Project',
    'Other',
];

if ($values['product_service'] !== '' && !in_array($values['product_service'], $allowedProducts, true)) {
    $errors['product_service'] = 'Select a valid product or service.';
}

$allowedArtworkStatuses = [
    '',
    'Artwork Ready',
    'Artwork Needs Adjustment',
    'Design Assistance Required',
    'Not Sure Yet',
];

if (!in_array($values['artwork_status'], $allowedArtworkStatuses, true)) {
    $errors['artwork_status'] = 'Select a valid artwork status.';
}

if ($values['required_date'] !== '') {
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $values['required_date']);
    $dateErrors = DateTimeImmutable::getLastErrors();
    $dateIsValid = $date !== false
        && ($dateErrors === false || ($dateErrors['warning_count'] === 0 && $dateErrors['error_count'] === 0))
        && $date->format('Y-m-d') === $values['required_date'];

    if (!$dateIsValid) {
        $errors['required_date'] = 'Enter a valid required date.';
    }
}

$attachment = validateArtworkUpload($errors);

if (!empty($errors)) {
    $_SESSION['quote_errors'] = $errors;
    redirectToForm();
}

date_default_timezone_set('Europe/Dublin');
$recipient = 'info@glassprinting.ie';
$sender = 'info@glassprinting.ie';
$subject = 'New GlassPrinting.ie Quote Request — ' . $values['company_name'];
$bodyLines = [
    'Company: ' . $values['company_name'],
    'Contact Name: ' . $values['contact_name'],
    'Email: ' . $values['email'],
    'Phone: ' . ($values['phone'] !== '' ? $values['phone'] : 'Not provided'),
    'Product / Service: ' . $values['product_service'],
    'Approximate Quantity: ' . $values['quantity'],
    'Required Date: ' . ($values['required_date'] !== '' ? $values['required_date'] : 'Not provided'),
    'Artwork Status: ' . ($values['artwork_status'] !== '' ? $values['artwork_status'] : 'Not provided'),
    '',
    'Project Details:',
    $values['project_details'],
    '',
    'Submission date/time: ' . date('Y-m-d H:i:s T'),
];
$headers = [
    'From: GlassPrinting.ie <' . $sender . '>',
    'Reply-To: ' . $values['email'],
    'MIME-Version: 1.0',
];

$messageBody = implode("\r\n", $bodyLines);
if ($attachment !== null) {
    $attachmentContents = file_get_contents($attachment['path']);
    if ($attachmentContents === false) {
        $_SESSION['quote_errors'] = ['artwork_file' => 'The server could not process your artwork file. Please try again.'];
        redirectToForm();
    }

    $boundary = '=_GlassPrinting_' . bin2hex(random_bytes(24));
    $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
    $messageBody = implode("\r\n", [
        '--' . $boundary,
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        '',
        implode("\r\n", $bodyLines),
        '',
        '--' . $boundary,
        'Content-Type: ' . $attachment['mime'] . '; name="' . $attachment['filename'] . '"',
        'Content-Transfer-Encoding: base64',
        'Content-Disposition: attachment; filename="' . $attachment['filename'] . '"',
        '',
        rtrim(chunk_split(base64_encode($attachmentContents), 76, "\r\n")),
        '--' . $boundary . '--',
        '',
    ]);
} else {
    $headers[] = 'Content-Type: text/plain; charset=UTF-8';
}

$_SESSION['quote_last_submission'] = time();
$encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
$sent = mail($recipient, $encodedSubject, $messageBody, implode("\r\n", $headers));

if (!$sent) {
    $_SESSION['quote_errors'] = ['quote-heading' => 'Your enquiry could not be sent. Please contact us directly by email or phone.'];
    redirectToForm();
}

unset($_SESSION['quote_old'], $_SESSION['quote_errors']);
$_SESSION['quote_csrf_token'] = bin2hex(random_bytes(32));
$_SESSION['quote_success'] = true;
redirectToForm();
