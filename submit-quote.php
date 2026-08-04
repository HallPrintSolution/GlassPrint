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
    'Content-Type: text/plain; charset=UTF-8',
];

$_SESSION['quote_last_submission'] = time();
$encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
$sent = mail($recipient, $encodedSubject, implode("\r\n", $bodyLines), implode("\r\n", $headers));

if (!$sent) {
    $_SESSION['quote_errors'] = ['quote-heading' => 'Your enquiry could not be sent. Please contact us directly by email or phone.'];
    redirectToForm();
}

unset($_SESSION['quote_old'], $_SESSION['quote_errors']);
$_SESSION['quote_csrf_token'] = bin2hex(random_bytes(32));
$_SESSION['quote_success'] = true;
redirectToForm();
