# Browser Detect - Claude Code Instructions

## Conventions

- Commits follow [Conventional Commits](https://www.conventionalcommits.org/)
- PR titles follow the same conventional commit format (e.g. `feat: add PHPStan support`)
- Base branch is `stable`

## Quality

- PHPStan at level `max` with zero baseline errors: `composer analyse`
- Tests: `composer test`

## Commands

```bash
composer test              # Run PHPUnit tests
composer analyse           # Run PHPStan static analysis
composer test-with-coverage # Run tests with coverage report
```
