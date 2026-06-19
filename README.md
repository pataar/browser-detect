# Browser Detect

[![Latest Stable Version](https://poser.pugx.org/pataar/browser-detect/v/stable)](https://packagist.org/packages/pataar/browser-detect)
[![Build](https://github.com/pataar/browser-detect/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/pataar/browser-detect/actions/workflows/tests.yml)
[![PHPStan](https://github.com/pataar/browser-detect/actions/workflows/static-analysis.yml/badge.svg?branch=main)](https://github.com/pataar/browser-detect/actions/workflows/static-analysis.yml)
[![Coverage Status](https://coveralls.io/repos/github/pataar/browser-detect/badge.svg?branch=main)](https://coveralls.io/github/pataar/browser-detect?branch=main)
[![Total Downloads](https://poser.pugx.org/pataar/browser-detect/downloads)](https://packagist.org/packages/pataar/browser-detect)
[![License](https://poser.pugx.org/pataar/browser-detect/license)](https://packagist.org/packages/pataar/browser-detect)

A Laravel package to identify the visitor's browser, operating system, and device type. Results are powered by two well-tested detection libraries — no magic involved.

> **Fork notice:** This is a maintained fork of [hisorange/browser-detect](https://github.com/hisorange/browser-detect) by [Varga Zsolt](https://github.com/hisorange), which appears to be abandoned. Full credit to the original author for the design and initial implementation.

### Changes from the original

- PHP 8.3+ and Laravel 12–13 support (dropped older versions)
- Removed `ua-parser/ua-parser` and `mobiledetect/mobiledetect` — detection is now powered by fewer, better-maintained libraries

## Requirements

- PHP 8.3+
- Laravel 12 or 13 (or standalone without Laravel)

## Installation

```sh
composer require pataar/browser-detect
```

That's it — Laravel auto-discovers the service provider and facade.

## Usage

### Facade

```php
use Browser;

if (Browser::isMobile()) {
    // Redirect to the mobile version of the site.
}

if (Browser::isBot()) {
    echo 'Bot detected!';
}

if (Browser::isFirefox() || Browser::isOpera()) {
    $response .= '<script src="firefox-fix.js"></script>';
}

if (Browser::isAndroid()) {
    $response .= '<a>Install our Android App!</a>';
} elseif (Browser::isMac() && Browser::isMobile()) {
    $response .= '<a>Install our iOS App!</a>';
}
```

### Blade directives

```blade
@mobile
    <p>This is the MOBILE template!</p>
    @include('your-mobile-template')
@endmobile

@tablet
    <p>This is the TABLET template!</p>
@endtablet

@desktop
    <p>This is the DESKTOP template!</p>
@enddesktop

@browser('isBot')
    <p>Bots are identified too!</p>
@endbrowser
```

### Standalone (without Laravel)

```php
use hisorange\BrowserDetect\Parser as Browser;

if (Browser::isLinux()) {
    // Works without Laravel!
}
```

### Parsing a specific user agent

```php
$result = Browser::detect();       // Current visitor
$result = Browser::parse('Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14');
```

Results are cached in memory for the current request and optionally persisted via Laravel's cache (7-day TTL by default).

## API Reference

### Device detection

| Method                    | Returns  | Description                                  |
| :------------------------ | :------: | :------------------------------------------- |
| `Browser::isMobile()`     |  `bool`  | Is this a mobile device?                     |
| `Browser::isTablet()`     |  `bool`  | Is this a tablet device?                     |
| `Browser::isDesktop()`    |  `bool`  | Is this a desktop computer?                  |
| `Browser::isBot()`        |  `bool`  | Is this a crawler / bot?                     |
| `Browser::deviceType()`   | `string` | One of: `Mobile`, `Tablet`, `Desktop`, `Bot` |
| `Browser::deviceFamily()` | `string` | Device vendor (Samsung, Apple, Huawei, ...)  |
| `Browser::deviceModel()`  | `string` | Device model (iPad, iPhone, Nexus, ...)      |

### Browser detection

| Method                           | Returns  | Description                                  |
| :------------------------------- | :------: | :------------------------------------------- |
| `Browser::browserName()`         | `string` | Human-friendly name (e.g. `Firefox 3.6`)     |
| `Browser::browserFamily()`       | `string` | Vendor (Chrome, Firefox, Opera, ...)         |
| `Browser::browserVersion()`      | `string` | Version string with trailing `.0` trimmed    |
| `Browser::browserVersionMajor()` |  `int`   | Semantic major version                       |
| `Browser::browserVersionMinor()` |  `int`   | Semantic minor version                       |
| `Browser::browserVersionPatch()` |  `int`   | Semantic patch version                       |
| `Browser::browserEngine()`       | `string` | Rendering engine (Blink, WebKit, Gecko, ...) |
| `Browser::isChrome()`            |  `bool`  | Chrome or Chromium?                          |
| `Browser::isFirefox()`           |  `bool`  | Firefox?                                     |
| `Browser::isOpera()`             |  `bool`  | Opera?                                       |
| `Browser::isSafari()`            |  `bool`  | Safari?                                      |
| `Browser::isEdge()`              |  `bool`  | Microsoft Edge?                              |
| `Browser::isIE()`                |  `bool`  | Internet Explorer (or Trident)?              |
| `Browser::isIEVersion(int, op)`  |  `bool`  | Compare against a specific IE version        |
| `Browser::isInApp()`             |  `bool`  | In-app browser (WebView, Twitter, WeChat)?   |

### Operating system detection

| Method                            | Returns  | Description                               |
| :-------------------------------- | :------: | :---------------------------------------- |
| `Browser::platformName()`         | `string` | Human-friendly name (e.g. `Windows 10`)   |
| `Browser::platformFamily()`       | `string` | Vendor (Linux, Windows, Mac, ...)         |
| `Browser::platformVersion()`      | `string` | Version string with trailing `.0` trimmed |
| `Browser::platformVersionMajor()` |  `int`   | Semantic major version                    |
| `Browser::platformVersionMinor()` |  `int`   | Semantic minor version                    |
| `Browser::platformVersionPatch()` |  `int`   | Semantic patch version                    |
| `Browser::isWindows()`            |  `bool`  | Windows?                                  |
| `Browser::isLinux()`              |  `bool`  | Linux?                                    |
| `Browser::isMac()`                |  `bool`  | macOS or iOS?                             |
| `Browser::isAndroid()`            |  `bool`  | Android?                                  |

## Configuration

In Laravel, publish the config file:

```sh
php artisan vendor:publish --provider="hisorange\BrowserDetect\ServiceProvider"
```

In standalone mode, pass a custom config array:

```php
use hisorange\BrowserDetect\Parser;

$browser = new Parser(null, null, [
    'cache' => [
        'interval' => 86400, // Cache TTL in seconds
    ],
]);
```

Available options:

| Key                          |  Default  | Description                                            |
| :--------------------------- | :-------: | :----------------------------------------------------- |
| `cache.interval`             |  `10080`  | Cache TTL in seconds                                   |
| `cache.prefix`               |  `bd4_`   | Cache key prefix                                       |
| `cache.device-detector`      |  `null`   | Cache driver for device-detector's internal cache. See `config/browser-detect.php` for examples. |
| `security.max-header-length` |  `2048`   | Max user agent length (DoS protection)                 |

## Quality

This package aims for 100% test coverage and PHPStan level `max` with zero baseline errors.

## Credits

This package was originally created by [Varga Zsolt (hisorange)](https://github.com/hisorange). This fork is maintained by [Pieter Willekens (pataar)](https://github.com/pataar).

Detection is powered by:

- [jaybizzle/crawler-detect](https://github.com/JayBizzle/Crawler-Detect) — Bot and crawler detection
- [matomo/device-detector](https://github.com/matomo-org/device-detector) — Comprehensive device, browser, and OS parsing

## License

[MIT](LICENSE)
