# GlassPrint Technical Modernization

GlassPrint Technical Modernization is the audited engineering programme for improving GlassPrinting.ie across technical SEO, accessibility, semantics, security, conversion, performance and maintainability. The current production website remains a legacy single-page B2B site with targeted improvements while the professional rebuild is in discovery.

> **Deployment scope:** a task marked **Completed** has an approved implementation and verified commit. GP-002 through GP-006 and GP-V02/GP-V03 are complete on their dedicated engineering branches but have not been merged into `main`. Only work contained in `main` should be treated as current production-ready source.

## Current Status

| ID | Area | Status |
|---|---|---|
| GP-001 | HTML structure repair | Completed |
| GP-002 | Heading hierarchy | Completed |
| GP-003 | HTML5 main landmark and semantic structure | Completed |
| GP-004 | Title and meta description optimisation | Completed |
| GP-005 | Open Graph metadata | Completed |
| GP-006 | Twitter Card metadata | Completed |
| GP-V02 | Hero conversion redesign | Completed |
| GP-V03 | Mobile horizontal overflow repair | Completed |
| GP-V04 | Newsletter modal experience | Superseded |
| GP-V04.1 | Newsletter popup removal | Completed |
| GP-V05 | Homepage trust bar proposal | Removed |
| GP-SEC-001 | Legacy newsletter security remediation | Completed |
| GP-HOTFIX-001 | Beer Mats promotional section | Completed |
| GP-HOTFIX-002 | Contact and Request a Quote journey | Completed |
| GP-HOTFIX-003 | Beer Mats product campaign | In review |
| GP-R00 | Professional rebuild discovery and architecture audit | Planning |

## Project Objectives

- Improve technical SEO, accessibility and HTML semantics.
- Improve performance and conversion clarity.
- Preserve approved visual and functional behaviour.
- Produce a secure, maintainable codebase.
- Document every audited and approved change.
- Prepare a scalable professional multi-page rebuild.

## Working Rules

- `main` contains production-ready work only.
- Experimental work must not be performed directly on `main`.
- Urgent production work uses short-lived hotfix branches.
- Every implementation begins with an audit.
- Every implementation is reviewed before commit.
- Every approved change is documented.
- Security issues take priority over visual work.
- Secrets must never be committed to source control.
- Production deployment must follow reviewed `main`.
- Legacy improvements must not create unnecessary rebuild debt.

## Engineering and SEO Progress

### GP-001 — HTML Structure Repair

**Status:** Completed
**Commit:** `22624e024892b6f5e416765090582612e2f46c9b`

- Removed the complete HTML document that was incorrectly nested around the FAQ.
- Preserved FAQ content, schema and functionality.
- Restored one valid document structure without visual regression.

### GP-002 — Heading Hierarchy

**Status:** Completed on `seo-fixes-fase-1`; not merged into `main`
**Commit:** `628fb37bcfebd9d257047952e2514f2ff5d6616f`

- Converted the seven approved card headings from H4 to H3.
- Added a scoped CSS override so their rendered appearance remained unchanged.
- Improved semantic hierarchy without changing global H3 styling.

### GP-003 — HTML5 Main Landmark and Semantic Structure

**Status:** Completed on `seo-fixes-fase-1`; not merged into `main`
**Commit:** `985ba858a4330a8fd6a34e8bd8209368f02244b1`

- Added exactly one `<main>` landmark.
- Wrapped primary content inside `<main>` while keeping the header and footer outside.
- Moved the four industry modals outside `<main>` without changing their markup.
- Preserved functionality and visual output.

### GP-004 — Title and Meta Description Optimisation

**Status:** Completed on `seo-fixes-fase-1`; not merged into `main`
**Commit:** `600ef4e294f74054c7c30de583017fa546107714`

- Shortened and clarified the homepage title.
- Optimised the meta description for the approved commercial message.
- Maintained parity between the document metadata and Open Graph title and description.

### GP-005 — Open Graph Metadata

**Status:** Completed on `seo-fixes-fase-1`; not merged into `main`
**Commit:** `3033479e4e1e6560e2caf7030c7528854fa3e533`

Added the following properties while preserving the existing Open Graph values:

- `og:site_name`
- `og:image:alt`
- `og:image:width`
- `og:image:height`

### GP-006 — Twitter Card Metadata

**Status:** Completed on `seo-fixes-fase-1`; not merged into `main`
**Commit:** `8951fd6b392fa0c7f4b12b09784d8dddf4848a2c`

Added explicit values for:

- `twitter:title`
- `twitter:description`
- `twitter:image`
- `twitter:image:alt`

The values were aligned with the approved document and Open Graph metadata.

## Visual and UX Work

### GP-V02 — Hero Conversion Redesign

**Status:** Completed on `visual-refresh-fase-1`; not merged into `main`
**Commit:** `dca520124afad23ff124ad14802ee9d87f30444c`

- Made the existing H1 visible and added approved supporting copy.
- Added Request a Quote and View Products CTAs.
- Introduced a controlled image overlay and responsive Hero content block.
- Added focus-visible styling and reduced-motion support.
- Preserved the carousel and its automatic behaviour.

### GP-V03 — Mobile Horizontal Overflow Repair

**Status:** Completed on `visual-refresh-fase-1`; not merged into `main`
**Commit:** `fd7812854951af393f3bc4935ab08c3d129a456a`

- Resolved conflicting grid, flex and intrinsic-width rules.
- Added scoped responsive containment and safe text wrapping.
- Removed mobile horizontal overflow without using `overflow-x: hidden` as a workaround.
- Preserved the desktop layout and existing content.

### GP-V04 — Newsletter Modal Experience

**Status:** Superseded

An improved delay, session behaviour and visual treatment were evaluated. The work is not active because the newsletter popup was subsequently removed entirely.

### GP-V04.1 — Newsletter Popup Removal

**Status:** Completed; incorporated into GP-SEC-001
**Commit:** `1482203422957361f9dac876ded47d1c3ecee304`

- Removed the newsletter modal and its form.
- Removed dedicated newsletter CSS and JavaScript.
- Removed automatic opening, closing, delay and storage logic.
- Kept the Hero and primary conversion journey unobstructed.

### GP-V05 — Homepage Trust Bar Proposal

**Status:** Removed after evaluation

The proposed trust bar was implemented for visual evaluation, rejected and removed because it did not meet the strategic and visual standard required for the rebuild. It is not active functionality.

## Security

### GP-SEC-001 — Legacy Newsletter Security Remediation

**Status:** Completed and merged into `main`
**Commit:** `1482203422957361f9dac876ded47d1c3ecee304`

- Removed the insecure `save_email.php` endpoint and the complete newsletter data-collection flow.
- Removed exposed database credentials from the active codebase.
- Added `SECURITY.md` with secret-management and future-form requirements.
- The affected database password was treated as compromised and rotated externally.
- Production database and hosting access were reviewed.
- The new quote form does not use a database.
- Future secrets must use managed environment configuration or hosting secret management.

Repository history may still contain previous secret material. Historical credentials must continue to be treated as compromised; actual values must never be reproduced in documentation.

## Commercial Hotfixes

### GP-HOTFIX-001 — Beer Mats Promotional Section

**Status:** Completed and merged into `main`
**Commit:** `68efa827404f2aed5bddc4f09c54481a810a55ff`

The temporary homepage section delivered by this task has been superseded by GP-HOTFIX-003. The completed commit remains part of the project history.

- Delivered an urgent management request to promote Beer Mats.
- Added a responsive promotional section immediately after the Hero.
- Added a Request a Quote CTA, now routed to `contact.php#quote-form`.
- Used a restrained, replacement-ready media treatment.
- Final Beer Mats campaign artwork remains pending and can replace the placeholder without changing the layout.

### GP-HOTFIX-003 — Beer Mats Product Campaign

**Status:** Implemented on `hotfix/beer-mats-product-page`; awaiting review and production approval

Management requested a stronger commercial Beer Mats journey for immediate production use. The temporary homepage promotional section was removed and superseded by a dedicated campaign slide in the existing Hero carousel.

Implementation:

- Added a Beer Mats Hero campaign slide linking to `beer-mats.html`.
- Created a dedicated product page covering traditional 1.4 mm hospitality Beer Mats, round and square formats, lead time, artwork preparation and the Beer Mat design service.
- Added the premium reusable coaster range with Recycled PET felt, cork, bamboo and PU leather material options.
- Separated traditional absorbent Beer Mats and premium reusable coasters into two visually distinct product families with dedicated card grids and specifications.
- Added central quotation CTAs for Beer Mats and premium coasters.
- Added safe server-side Contact form preselection for both product categories.
- Added `beer-mats.html` to the sitemap.

Asset status:

- No approved Beer Mats or premium-coaster campaign photography was present in the repository. Branded, image-ready CSS treatments are used without misleading product photography. Replacement assets are expected at `images/beer-mats/round-beer-mat.webp`, `images/beer-mats/square-beer-mat.webp`, `images/beer-mats/rpet-felt-coaster.webp`, `images/beer-mats/cork-coaster.webp`, `images/beer-mats/bamboo-coaster.webp` and `images/beer-mats/pu-leather-coaster.webp`.
- Round and square artwork-template files were not present. The download controls remain visibly disabled and non-interactive until approved files are uploaded.
- Recommended future filenames are `pdfs/round-beer-mat-template.pdf` and `pdfs/square-beer-mat-template.pdf`.

### GP-HOTFIX-002 — Contact and Request a Quote Journey

**Status:** Completed, production-validated and merged into `main`
**Commit:** `121df4967932c6b4c3c81473e3fe66b953b0a1d4`
**Merge commit:** `06e0cd648734a83167a8a4206147853b275b3f16`

Created:

- `contact.php`
- `contact.css`
- `submit-quote.php`

The implementation provides a dedicated professional Contact and Request a Quote journey for commercial enquiries.

#### Form fields

Required:

- Company Name
- Contact Name
- Email Address
- Product / Service
- Approximate Quantity
- Project Details

Optional:

- Phone Number
- Required Date
- Artwork Status

#### Security controls

- POST-only processing
- PHP sessions
- Cryptographically secure CSRF protection
- Honeypot protection
- 60-second submission cooldown
- Authoritative server-side validation
- Email validation and CR/LF header-injection protection
- Product and artwork-status allowlists
- Escaped output and safely associated validation errors
- One-time session success flash
- No database, file storage, credentials or external form provider

#### Email handling

- **Recipient:** `info@glassprinting.ie`
- **Sender:** `info@glassprinting.ie`
- **Reply-To:** validated customer email only

#### Production validation

- `contact.php` executed successfully on the production hosting environment using PHP 8.4.
- The quote form submitted successfully.
- The enquiry was delivered to `info@glassprinting.ie`.
- One-time success feedback was confirmed.

## Centralised Contact and Quote Routing

| Intent | Destination |
|---|---|
| Navigation Contact | `contact.php` |
| Beer Mats Request a Quote | `contact.php#quote-form` |
| Product quote CTAs | `contact.php#quote-form` |
| FAQ Contact links | `contact.php` |
| Footer direct email | `mailto:info@glassprinting.ie` |
| Footer phone | `tel:+35314045145` |
| Printed Glassware catalogue | Existing catalogue download retained |

Internal quote CTAs open in the current browsing context. Intended catalogue and external-link behaviour remains unchanged.

## Production Environment

- **Hosting:** Irish Domains / Plesk
- **Production domain:** `glassprinting.ie`
- **PHP:** PHP 8.4 FastCGI
- **Previous PHP:** PHP 7.4
- **SSL:** Sectigo PositiveSSL DV
- **Database:** the legacy newsletter database integration has been removed from active website code; the current quote journey uses no database.
- **Backup:** a full hosting backup was completed before the security remediation.

No hosting passwords, database credentials, server paths or other secrets belong in this repository.

## Current Production Architecture

The current production-ready source uses:

- A static HTML homepage
- Global CSS
- Vanilla JavaScript
- A PHP Contact and Request a Quote flow
- No active application database
- Plesk production hosting

This remains the current legacy architecture with targeted production improvements. It is not the final professional rebuild architecture.

## GlassPrint Professional Rebuild

**Status:** Planning / Discovery
**Reference:** GP-R00 — Professional Rebuild Discovery and Architecture Audit

The current single-page website is planned to evolve into a professional multi-page B2B platform. The strategic direction includes evaluation of:

- Multi-page information architecture
- Dedicated product and industry pages
- Capabilities and service pages
- Special-product landing pages
- A professional Request a Quote journey
- A reusable design system and new colour/typography direction
- Structured SEO and internal-linking architecture
- Analytics and conversion measurement
- Secure backend integrations and future CRM capability
- Scalable content architecture

Astro + TypeScript was recommended during technical discovery and remains subject to final architecture approval.

## Branch Strategy

- `main` — production-ready source of truth.
- `seo-fixes-fase-1` — technical SEO and semantic work; completed commits remain unmerged pending promotion decisions.
- `visual-refresh-fase-1` — visual experiments and UX improvements; completed commits remain unmerged pending promotion decisions.
- `security/remove-legacy-email-endpoint` — completed security remediation branch.
- `hotfix/beer-mats-section` — completed urgent Beer Mats commercial work.
- `hotfix/contact-quote-live` — completed Contact and Quote production implementation.
- Professional rebuild work should use a dedicated rebuild branch with short-lived feature branches and reviewed integration checkpoints.

No direct experimental commits should be made to `main`.

## Quality Standard

Every approved change must satisfy all applicable requirements:

- No unexpected visual regressions.
- Accessibility, SEO and responsive behaviour are preserved or improved.
- Existing functionality is preserved unless removal is explicitly approved.
- Security controls are reviewed proportionately to risk.
- No secrets or sensitive credentials are committed.
- Documentation reflects branch scope and production status accurately.
- Production deployment follows review and validation.

## Change Log Template

Future approved changes should record:

```text
ID:
Date:
Commit:
Branch / deployment scope:
Files modified:
Problem:
Solution:
Business impact:
Technical notes:
Status:
```
