# REST API Standard

Base path: `/api/v1`
Configured by: `IPSHIELD_API_VERSION=v1`

## Versioning
Public API routes must live under an explicit version prefix.
Unversioned public API routes are not exposed.
Breaking contract changes require a new API version.

## Response contract
Success shape:
`{"success":true,"data":{},"message":null,"meta":{}}`

Error shape:
`{"success":false,"data":null,"message":"...","errors":[],"error":{"code":"..."}}`

Every versioned response should expose the active version in metadata where applicable.
Foundation health responses also return the `X-API-Version` header.

## Content
JSON is the default representation for `/api/*`.
API clients should send `Accept: application/json`.

## HTTP policy
- validation: 422
- authentication: 401
- authorization: 403
- not found: 404
- conflict: 409
- rate limit: 429
- internal failure: 500 without stack traces
- dependency/service degradation: 503 when the endpoint explicitly represents health

## Query contracts
Pagination metadata must remain stable within an API version.
Filter, sort and search fields must use explicit allow-lists.
New fields may be added compatibly; removals or semantic changes require review.

## Phase 2 boundary
The REST foundation defines routing and response contracts only.
Authentication, validation, security middleware and centralized exception mapping are completed in later Phase 2 steps.
