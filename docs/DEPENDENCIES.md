# Dependency Governance

Every new dependency requires:
1. documented purpose
2. active maintenance
3. acceptable license
4. security review
5. justification versus native/framework capability

Rules:
- commit lock files
- run dependency audits regularly
- avoid abandoned packages
- remove dependencies that no longer provide value

## Approved Phase 2 dependency: predis/predis

- purpose: Laravel Redis client for cache, queues, locks and short-lived state
- selected version: `v3.6.0` via Composer lock file
- license: MIT
- maintenance: actively maintained at Phase 2 implementation time
- justification: avoids requiring a PHP Redis extension on the current Windows dev host
- production note: client choice may be re-evaluated for Linux production without changing the Redis contract
