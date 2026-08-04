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

if (empty($_SESSION['quote_csrf_token'])) {
    $_SESSION['quote_csrf_token'] = bin2hex(random_bytes(32));
}

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function errorAttributes(array $errors, string $field): string
{
    return isset($errors[$field])
        ? ' aria-invalid="true" aria-describedby="' . escapeHtml($field) . '-error"'
        : '';
}

function fieldError(array $errors, string $field): string
{
    if (!isset($errors[$field])) {
        return '';
    }

    return '<p class="contact-field-error" id="' . escapeHtml($field) . '-error">'
        . escapeHtml((string) $errors[$field])
        . '</p>';
}

$errors = $_SESSION['quote_errors'] ?? [];
$old = $_SESSION['quote_old'] ?? [];
$success = isset($_SESSION['quote_success']) && $_SESSION['quote_success'] === true;
unset($_SESSION['quote_errors'], $_SESSION['quote_old'], $_SESSION['quote_success']);
$productOptions = [
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
$artworkOptions = [
    'Artwork Ready',
    'Artwork Needs Adjustment',
    'Design Assistance Required',
    'Not Sure Yet',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact GlassPrinting.ie in Dublin or request a quote for custom printed bottles, glassware, jars, packaging, Beer Mats and bespoke printing projects.">
    <title>Contact &amp; Request a Quote | GlassPrinting.ie</title>
    <link rel="canonical" href="https://www.glassprinting.ie/contact.php">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Contact &amp; Request a Quote | GlassPrinting.ie">
    <meta property="og:description" content="Contact GlassPrinting.ie in Dublin or request a quote for custom printed bottles, glassware, jars, packaging, Beer Mats and bespoke printing projects.">
    <meta property="og:url" content="https://www.glassprinting.ie/contact.php">
    <meta property="og:image" content="https://www.glassprinting.ie/images/banner1.jpg">
    <meta property="og:site_name" content="GlassPrinting.ie">
    <meta property="og:image:alt" content="Custom printed glass bottles, glasses and jars by GlassPrinting.ie in Dublin">
    <meta property="og:image:width" content="1900">
    <meta property="og:image:height" content="840">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Contact &amp; Request a Quote | GlassPrinting.ie">
    <meta name="twitter:description" content="Contact GlassPrinting.ie in Dublin or request a quote for custom printed bottles, glassware, jars, packaging, Beer Mats and bespoke printing projects.">
    <meta name="twitter:image" content="https://www.glassprinting.ie/images/banner1.jpg">
    <meta name="twitter:image:alt" content="Custom printed glass bottles, glasses and jars by GlassPrinting.ie in Dublin">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KDT5ESTHDC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-KDT5ESTHDC');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P6N2FSCZ');</script>
    <!-- End Google Tag Manager -->
    <link rel="stylesheet" href="contact.css">
</head>
<body class="contact-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6N2FSCZ"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <a class="contact-skip-link" href="#main-content">Skip to main content</a>

    <header class="contact-header">
        <a class="contact-brand" href="index.html" aria-label="GlassPrinting.ie home">
            <img src="images/logo.png" alt="GlassPrinting.ie" width="562" height="91">
        </a>
        <nav class="contact-nav" aria-label="Primary navigation">
            <a href="index.html">Home</a>
            <a href="index.html#about-us">About Us</a>
            <a href="index.html#industries">Industries</a>
            <a href="index.html#products">Products</a>
            <a href="contact.php" aria-current="page">Contact</a>
            <a href="index.html#faq-section">FAQ</a>
        </nav>
    </header>

    <main id="main-content" class="contact-main">
        <div class="contact-intro">
            <p class="contact-eyebrow">GlassPrinting.ie Dublin</p>
            <h1>Contact GlassPrinting.ie</h1>
            <p>Tell us about your project and our team will review your requirements and get back to you with the next steps.</p>
        </div>

        <div class="contact-layout">
            <section class="contact-details" aria-labelledby="contact-details-heading">
                <h2 id="contact-details-heading">Contact Information</h2>
                <address>
                    <strong>GlassPrinting.ie</strong>
                    <span>Unit B6 South City Business Centre</span>
                    <span>Whitestown Way</span>
                    <span>Tallaght</span>
                    <span>Dublin</span>
                    <span>D24 V227</span>
                </address>
                <dl>
                    <div>
                        <dt>Phone</dt>
                        <dd><a href="tel:+35314045145">01 404 5145</a></dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd><a href="mailto:info@glassprinting.ie">info@glassprinting.ie</a></dd>
                    </div>
                </dl>
            </section>

            <section id="quote-form" class="contact-quote" aria-labelledby="quote-heading">
                <h2 id="quote-heading">Request a Quote</h2>
                <p>Provide a few details about your project so we can understand your requirements before getting in touch.</p>

                <?php if ($success): ?>
                    <div class="contact-status contact-status-success" role="status" tabindex="-1">
                        Thank you. Your enquiry has been sent to the GlassPrinting.ie team.
                    </div>
                <?php elseif (!empty($errors)): ?>
                    <div class="contact-status contact-status-error" role="alert" tabindex="-1">
                        <p>We could not submit your enquiry. Please review the following:</p>
                        <ul>
                            <?php foreach ($errors as $field => $message): ?>
                                <li><a href="#<?= escapeHtml((string) $field) ?>"><?= escapeHtml((string) $message) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form class="contact-form" action="submit-quote.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?= escapeHtml($_SESSION['quote_csrf_token']) ?>">
                    <div class="contact-honeypot" aria-hidden="true">
                        <label for="website">Leave this field empty</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="contact-field-grid">
                        <div class="contact-field">
                            <label for="company_name">Company Name <span aria-hidden="true">*</span></label>
                            <input type="text" id="company_name" name="company_name" maxlength="120" autocomplete="organization" required aria-required="true" value="<?= escapeHtml((string) ($old['company_name'] ?? '')) ?>"<?= errorAttributes($errors, 'company_name') ?>>
                            <?= fieldError($errors, 'company_name') ?>
                        </div>
                        <div class="contact-field">
                            <label for="contact_name">Contact Name <span aria-hidden="true">*</span></label>
                            <input type="text" id="contact_name" name="contact_name" maxlength="120" autocomplete="name" required aria-required="true" value="<?= escapeHtml((string) ($old['contact_name'] ?? '')) ?>"<?= errorAttributes($errors, 'contact_name') ?>>
                            <?= fieldError($errors, 'contact_name') ?>
                        </div>
                        <div class="contact-field">
                            <label for="email">Email Address <span aria-hidden="true">*</span></label>
                            <input type="email" id="email" name="email" maxlength="254" autocomplete="email" required aria-required="true" value="<?= escapeHtml((string) ($old['email'] ?? '')) ?>"<?= errorAttributes($errors, 'email') ?>>
                            <?= fieldError($errors, 'email') ?>
                        </div>
                        <div class="contact-field">
                            <label for="phone">Phone Number <span class="contact-optional">Optional</span></label>
                            <input type="tel" id="phone" name="phone" maxlength="40" autocomplete="tel" value="<?= escapeHtml((string) ($old['phone'] ?? '')) ?>"<?= errorAttributes($errors, 'phone') ?>>
                            <?= fieldError($errors, 'phone') ?>
                        </div>
                        <div class="contact-field">
                            <label for="product_service">Product / Service <span aria-hidden="true">*</span></label>
                            <select id="product_service" name="product_service" required aria-required="true"<?= errorAttributes($errors, 'product_service') ?>>
                                <option value="">Select an option</option>
                                <?php foreach ($productOptions as $option): ?>
                                    <option value="<?= escapeHtml($option) ?>"<?= (($old['product_service'] ?? '') === $option) ? ' selected' : '' ?>><?= escapeHtml($option) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= fieldError($errors, 'product_service') ?>
                        </div>
                        <div class="contact-field">
                            <label for="quantity">Approximate Quantity <span aria-hidden="true">*</span></label>
                            <input type="text" id="quantity" name="quantity" maxlength="80" inputmode="numeric" required aria-required="true" value="<?= escapeHtml((string) ($old['quantity'] ?? '')) ?>"<?= errorAttributes($errors, 'quantity') ?>>
                            <?= fieldError($errors, 'quantity') ?>
                        </div>
                        <div class="contact-field">
                            <label for="required_date">Required Date <span class="contact-optional">Optional</span></label>
                            <input type="date" id="required_date" name="required_date" value="<?= escapeHtml((string) ($old['required_date'] ?? '')) ?>"<?= errorAttributes($errors, 'required_date') ?>>
                            <?= fieldError($errors, 'required_date') ?>
                        </div>
                        <div class="contact-field">
                            <label for="artwork_status">Artwork Status <span class="contact-optional">Optional</span></label>
                            <select id="artwork_status" name="artwork_status"<?= errorAttributes($errors, 'artwork_status') ?>>
                                <option value="">Select an option</option>
                                <?php foreach ($artworkOptions as $option): ?>
                                    <option value="<?= escapeHtml($option) ?>"<?= (($old['artwork_status'] ?? '') === $option) ? ' selected' : '' ?>><?= escapeHtml($option) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= fieldError($errors, 'artwork_status') ?>
                        </div>
                    </div>

                    <div class="contact-field">
                        <label for="project_details">Project Details <span aria-hidden="true">*</span></label>
                        <textarea id="project_details" name="project_details" rows="7" maxlength="3000" required aria-required="true"<?= errorAttributes($errors, 'project_details') ?>><?= escapeHtml((string) ($old['project_details'] ?? '')) ?></textarea>
                        <?= fieldError($errors, 'project_details') ?>
                    </div>

                    <p class="contact-privacy">By submitting this form, you agree that GlassPrinting.ie may use the information provided to respond to your enquiry.</p>
                    <p class="contact-required-note"><span aria-hidden="true">*</span> Required fields</p>
                    <button type="submit" class="contact-submit">Send Quote Request</button>
                </form>
            </section>
        </div>
    </main>

    <footer class="contact-footer">
        <div>
            <strong>GlassPrinting.ie</strong>
            <span>Unit B6 South City Business Centre, Whitestown Way, Tallaght, Dublin, D24 V227</span>
        </div>
        <div>
            <a href="tel:+35314045145">01 404 5145</a>
            <a href="mailto:info@glassprinting.ie">info@glassprinting.ie</a>
        </div>
    </footer>
</body>
</html>
