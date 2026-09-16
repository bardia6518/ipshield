# Git Workflow

Branches:
- `main`: stable baseline
- `develop`: integration branch
- `feature/*`: features
- `bugfix/*`: non-urgent fixes
- `hotfix/*`: urgent fixes

Commit prefixes:
- `feat:` `fix:` `security:` `refactor:` `docs:` `test:` `chore:`

Rules:
1. Never commit `.env`, credentials, private keys, or feed secrets.
2. Work merges into `develop` before `main`.
3. `main` must remain deployable.
4. Security/infrastructure changes require matching documentation updates.
