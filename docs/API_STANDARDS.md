# REST API Standard

Base path: `/api/v1`

Success shape:
`{"success":true,"data":{},"message":null,"meta":{}}`

Error shape:
`{"success":false,"data":null,"message":"...","errors":[],"error":{"code":"..."}}`

HTTP policy:
- validation: 422
- authentication: 401
- authorization: 403
- not found: 404
- conflict: 409
- rate limit: 429
- internal failure: 500 without stack traces

Pagination metadata must be stable and versioned.
Filter/sort/search fields must use explicit allow-lists.
