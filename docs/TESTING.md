# Testing Foundation

Required layers:
- Unit tests
- Feature tests
- API tests
- Integration tests
- Security-focused tests

Rules:
- test database is separate from development/staging/production data
- important features are not Done without tests
- tests never depend on production credentials
- factories and fixtures use synthetic data
- CI may be added later without changing the test contract
