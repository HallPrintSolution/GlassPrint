# Security

## Legacy Newsletter Endpoint

The legacy newsletter endpoint and its associated data-collection flow were removed from the active codebase.

Database credentials had previously been committed to source control. The affected database password must be rotated externally, and database and hosting access should be reviewed to confirm that only authorised users and services retain access.

Repository history may still contain the previous credentials. Removing the endpoint from the current branch does not invalidate or erase credentials stored in earlier commits.

## Secret Management

Secrets must never be committed to the repository. Future backend credentials, API keys and tokens must use managed environment variables or the secret-management facilities provided by the hosting platform.

Public errors must never expose database internals, connection details, queries, credentials or other operational information.

## Future Forms

Any future form or data-collection endpoint must include:

- Authoritative server-side validation.
- Spam and automated-abuse protection.
- Rate limiting.
- Appropriate consent and privacy handling.
- Safe error responses and private operational logging.
