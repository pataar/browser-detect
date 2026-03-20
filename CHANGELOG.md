# Changelog

For recent changes (6.x and later), see [GitHub Releases](https://github.com/pataar/browser-detect/releases).

---

### Changes in 5.0.0

- Support for Laravel 10.x
- Upgrade to MobileDetect 3.x
- Remove the outdated "mobileGrade" feature
- Test on PHP 8.2 too

### Changes in 4.5.2

- Improved the inApp detection
- Small fix for new PHP versions

### Change in 4.5.1

- Added Prerender as bot

### Change in 4.5.0

- New shortcut call for deviceType (by @mylesduncanking)
- Testing on PHP 8.1
- Testing with Laravel 9.x

### Changes in 4.4.0

- Support for Laravel 8.x
- Support for PHP 8.x
- New github actions tests to cover an even bigger test matrix
- Fixes some PHPStan testing issue

### Changes in 4.3.0

- Replaced the archived piwik/device-detector with the matomo/device-detector (by @matthewnessworthy)
- Merged some readme changes
- New micro feature **isInApp** check on the browser #156

### Changes in 4.2.2

- Fix bug with config merging.
- Support for Laravel 7.0
- Update many dependency to have compatibility on all Laravel version.
- New config accessor to read and test the config injection.
- Tests for the config merging.
- Use composer scripts for easier local testing.

### Changes in 4.2.1

- Fix unhandled null type in user agent string accessor.

### Changes in 4.2.0

- Standalone mode, removed the requirement for Laravel.
- Support for user configs, also supports the Laravel config manager.

### Changes in 4.1.0

- OS detectors for Windows, Linux, Andorid, and Mac/iOS.
- 100% test coverage.
- Type hinted every class and function.
- Introduced the static code analysis to the test flow.
- Introduced the code quality analysis to the test flow.
- Moved to PSR12 standards with the code base.
- Fixed potential type errors.
- Improve the resistance for HTTP header based attacks.
- First iteraton for a demo site.

### Change in 4.0.0

- PHP 5.6 is no longer supported.
- Raised the minimum Laravel version to 6.0.
- Support for Laravel 6.0, 6.1, 6.2, 6.3, 6.4, 6.5.
- Unify the coding standards.
- Remove legacy PHP workarounds.
- Release the isEdge result variable.
- Invalidate cache with 3.x versions.
- Update the tests to test for every laravel framework version.

### Changes in 3.1.4

- Fix blade directives, add test coverage.

### Changes in 3.1.3

- Allow PHPUnit 7.0 as dependency.

### Changes in 3.1.2

- Bump version testing to laravel 5.6.

### Changes in 3.1.1

- Fix: MobileDetect still used the osName instead of platformName.
- Fix: isIEVersion comparison called the parameters in wrong order.
- Addition: Version parser now forces the semantic version pieces to be integer.
- Fixed: MobileDetect test only ran on one sample.
- Addition: More test coverage, getting closer to the maximum.

### Changes in 3.1.0

- Added the DeviceDetector stage to the pipeline.
- Fixed a minor issue with versions and trailing dots.
- Added the Browser::browserEngine() function.
- Much better detection rates with the new stage.

### Changes in 3.0.1

- Fixed the result objects bad property calls.
- Added more unit test for the fixed case.

### Changes in 3.0.0

- The package has been rewrote from ground zero.
- Added PHPUnit, and covering the main features.
- Added the travis ci to the release cycle.
- Moved to the Develop -> Staging -> Stable branch model.
- Interfaced everything, seriously!
- Custom exceptions for easier package managing.
- Blade directives.
- Result is now a well annotated object, any IDE can work with it.
- End of the plugin era, pipelines ha arrived.
- Added the crawler detect package.
- Replaced the UAParser to a more supported one.
- Support for MobileDetect 2.0 to 2.8, 3.0 will never come :D
- Parser class is much more simple to use.
- PSR-2 code style.
- Browsecap plugin has been removed.
- UserAgentStringApi plugin has been removed. (Too slow to call)
- Everything is easier now, but also less flexibility in the package.
- Better version support for PHP and Laravel.
- Easy fast setup.
- Namespaces are redesigned to be more descriptive.
