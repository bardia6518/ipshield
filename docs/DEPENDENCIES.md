# Dependency Governance

Every new dependency requires:
1. documented purpose
2. active maintenance
3. acceptable license
4. security review
5. justification versus native/framework capability

## Rules
- commit Composer lock files
- run `composer audit --locked` before release
- reject known vulnerable dependencies unless an explicit documented exception exists
- reject abandoned direct dependencies
- remove dependencies that no longer provide value
- JavaScript dependencies must not be treated as reproducible until a lock file exists

## Phase 2 audit
Composer manifest validation: PASS.
Security advisory audit: PASS — no known advisories at the Phase 2 review.
Abandoned direct dependencies: none detected.

## Approved Phase 2 runtime dependencies

### predis/predis
- purpose: Laravel Redis client for cache, queues, locks and short-lived state
- locked version at review: v3.6.0
- license: MIT
- justification: portable Redis client without a required PHP Redis extension on the current Windows dev host

### laravel/sanctum
- purpose: API token authentication foundation
- locked version at review: v4.3.3
- license: MIT
- justification: first-party Laravel authentication primitive selected in Phase 1 architecture

## JavaScript note
The decoupled frontend has not been initialized in Phase 2, so no frontend Node dependency graph is approved yet.
The legacy Laravel backend package manifest is not considered the IPShield frontend dependency boundary.
