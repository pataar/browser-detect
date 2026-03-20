# Contributing

Thanks for your interest in contributing to Browser Detect!

## Getting Started

1. Fork the repository and clone your fork
2. Install dependencies: `composer install`
3. Run the test suite: `composer test`

## Development Workflow

1. Create a branch from `main`
2. Make your changes
3. Add or update tests as needed
4. Ensure all tests pass: `composer test`
5. Commit using [Conventional Commits](#commit-messages)
6. Open a pull request against `main` with a [conventional commit](#commit-messages) formatted title

## Commit Messages

This project follows [Conventional Commits](https://www.conventionalcommits.org/). Every commit message must be structured as:

```
<type>[optional scope]: <description>

[optional body]
```

### Types

| Type       | When to use                                        |
|------------|----------------------------------------------------|
| `feat`     | A new feature                                      |
| `fix`      | A bug fix                                          |
| `docs`     | Documentation only                                 |
| `refactor` | Code change that neither fixes a bug nor adds a feature |
| `test`     | Adding or updating tests                           |
| `chore`    | Maintenance tasks (deps, CI, config)               |
| `perf`     | Performance improvements                           |

### Examples

```
feat: add detection for Arc browser
fix: correct tablet detection for iPad Air
docs: update installation instructions in README
refactor: extract version normalization into helper
test: add coverage for in-app browser detection
chore(deps): bump matomo/device-detector to ^7.0
```

## Code Style

- Follow the existing patterns in the codebase
- Keep changes focused — one concern per pull request
- Add tests for new functionality and bug fixes

## Running Tests

```bash
composer test                                          # All tests
./vendor/bin/phpunit --filter=TestClassName             # Single test class
./vendor/bin/phpunit --filter=TestClassName::testMethod # Single test method
```
