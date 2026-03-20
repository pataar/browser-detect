# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
composer test              # Run all tests
./vendor/bin/phpunit --filter=TestClassName          # Run a single test class
./vendor/bin/phpunit --filter=TestClassName::testMethod  # Run a single test method
```

## Architecture

This is a Laravel package (`pataar/browser-detect`) that composites two browser detection libraries into a unified API. It works both as a Laravel integration (ServiceProvider/Facade) and standalone.

### Pipeline Pattern

The core design is a **stages pipeline** in `Parser::process()` using `array_reduce()`. A mutable `Payload` carries state through three ordered stages, then gets converted into an immutable `Result`:

```
User Agent → CrawlerDetect → DeviceDetector → BrowserDetect → Result
```

1. **CrawlerDetect** (`jaybizzle/crawler-detect`) — Bot/crawler flagging
2. **DeviceDetector** (`matomo/device-detector`) — Comprehensive browser, OS, and device parsing (extracts browser/platform info for all UAs, skips device classification for bots)
3. **BrowserDetect** — Post-processing: resolves conflicts, maps families to boolean flags (`isChrome`, `isWindows`, etc.), detects in-app browsers, normalizes version strings

Each stage implements `StageInterface` — a single `__invoke(PayloadInterface): PayloadInterface` callable.

### Key Classes

- **Parser** — Orchestrator. Supports Laravel cache (7-day TTL) + in-memory runtime cache. Truncates user agents at 2048 bytes (DoS protection). Proxies unknown method calls to the current Result via `__call()`.
- **Payload** — Mutable key-value bag carrying the user agent and intermediate detection data through the pipeline.
- **Result** — Immutable output with ~30 typed properties (booleans, strings, ints). Implements `JsonSerializable`.
- **ServiceProvider** — Registers the parser binding, publishes config, and registers Blade directives (`@mobile`, `@desktop`, `@tablet`, `@browser`).

### Tests

Tests use **Orchestra Testbench** for Laravel integration testing. Data providers use PHPUnit `#[DataProvider]` attributes (PHPUnit 13+). Stage tests validate individual pipeline stages in isolation; integration tests (Parser, Result, Blade) test end-to-end behavior.
