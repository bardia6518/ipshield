# Storage Architecture

PostgreSQL stores evidence metadata, hashes, relationships, and integrity data.
Large evidence files use Laravel filesystem abstraction.

Initial adapters:
- local filesystem for development
- S3-compatible object storage for future staging/production

Do not store large binary evidence blobs directly in PostgreSQL unless a future ADR explicitly approves it.
