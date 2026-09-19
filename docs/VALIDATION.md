# Validation Foundation

All external input must be validated before entering Application or Domain layers.

## Rules
- Use explicit allow-lists.
- Never pass raw request payloads directly to services or persistence.
- Prefer dedicated FormRequest classes for API endpoints.
- Validation rules must be deterministic and testable.
- Unvalidated extra fields are discarded.
- Validation errors use the API error contract defined in the Error Handling step.

## Base request
`App\Http\Requests\ApiFormRequest` is the Phase 2 base class.
Its `validatedPayload()` method exposes only validated data.

## Boundary
Phase 2 defines the validation contract and tests.
Domain-specific validation rules are added with their Phase 3 features.
