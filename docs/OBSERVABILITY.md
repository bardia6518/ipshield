# Observability

Independent health dimensions:
- application
- PostgreSQL
- Redis
- queue/workers
- scheduler

Minimum staging/production alerts:
- application unavailable
- database unavailable
- Redis unavailable
- persistent failed jobs
- disk pressure
- abnormal error rate

Health checks must be observable and failure-detectable. Logging alone is not monitoring.
