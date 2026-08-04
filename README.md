# GlassPrint

## Change Log

### GP-HOTFIX-001 — Beer Mats Promotional Section

Date: 2026-08-04

Status: Completed — awaiting review and commit.

Reason:

Management requested an urgent Beer Mats promotion on the current live website ahead of the full GlassPrint rebuild.

Placement:

The section is positioned directly after the homepage Hero and before the existing Recent Work section.

Implementation:

Added a responsive, two-column promotional section containing the approved heading, supporting copy and quote CTA. A restrained GlassPrint-branded CSS placeholder provides an image-ready media area without introducing unsuitable stock imagery or an external dependency.

Expected Commercial Impact:

Beer Mats are now presented prominently near the beginning of the homepage, providing pubs, breweries, event organisers and hospitality customers with a direct route to request a quote.

Campaign Artwork:

Final Beer Mats campaign artwork is still pending. The media area is structured so that the placeholder can be replaced without changing the section layout.

### GP-HOTFIX-002 — Contact & Request a Quote Page

Date: 2026-08-04

Status: Completed — awaiting review and commit.

Urgent Commercial Requirement:

The live website required a dedicated conversion destination so that general contact enquiries and quotation requests no longer relied on footer anchors or product-level email links.

Implementation:

Created a dedicated Contact page with verified business details and a structured Request a Quote form. Contact-intent links now route to `contact.php`, while quotation-intent links route directly to `contact.php#quote-form`.

Recipient:

Form enquiries are addressed to `info@glassprinting.ie`, sent from the same verified address, with the validated customer email used only as Reply-To.

Form Fields:

The form collects company name, contact name, email address, optional phone number, product or service, approximate quantity, optional required date, optional artwork status and project details.

Security Controls:

The PHP handler uses POST-only processing, sessions, CSRF protection, server-side validation, email validation, CR/LF header-injection protection, maximum lengths, an allowlisted product selection, a honeypot and a session-based submission cooldown. Public errors are generic.

Data Handling:

No database, SQL, file storage, artwork upload, API key, external form provider, CRM or newsletter functionality is used.

CTA Routing:

Homepage navigation and FAQ contact links route to the Contact page. Beer Mats and product quotation CTAs route to the quote form. Direct footer email and telephone links remain available.

Production Email Test Status:

Form generation and PHP mail logic validated. Actual delivery to `info@glassprinting.ie` requires production testing in Plesk.
