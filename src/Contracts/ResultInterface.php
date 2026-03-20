<?php

namespace Pataar\BrowserDetect\Contracts;

use JsonSerializable;

/**
 * Interface ResultInterface
 */
interface ResultInterface extends JsonSerializable
{
    /**
     * Initialize the result object with a processed payload.
     *
     * @param  array<string, mixed>  $result
     */
    public function __construct(array $result);

    /**
     * Get the original user agent string.
     */
    public function userAgent(): string;

    /**
     * Is this a mobile device?
     */
    public function isMobile(): bool;

    /**
     * Is this a tablet device?
     */
    public function isTablet(): bool;

    /**
     * Is this a desktop computer?
     */
    public function isDesktop(): bool;

    /**
     * What type of device is this: Mobile, Tablet, Desktop, Bot, TV, Console, Wearable
     */
    public function deviceType(): string;

    /**
     * Is this a crawler / bot?
     */
    public function isBot(): bool;

    /**
     * Is this a TV device?
     */
    public function isTV(): bool;

    /**
     * Is this a game console?
     */
    public function isConsole(): bool;

    /**
     * Is this a wearable device?
     */
    public function isWearable(): bool;

    /**
     * Is this a Chrome or Chromium browser?
     */
    public function isChrome(): bool;

    /**
     * Is this a Firefox browser?
     */
    public function isFirefox(): bool;

    /**
     * Is this an Opera browser?
     */
    public function isOpera(): bool;

    /**
     * Is this a Safari browser?
     */
    public function isSafari(): bool;

    /**
     * Is this browser a Microsoft Edge?
     */
    public function isEdge(): bool;

    /**
     * Is this browser an Internet Explorer?
     */
    public function isIE(): bool;

    /**
     * Is this a Brave browser?
     */
    public function isBrave(): bool;

    /**
     * Is this a Vivaldi browser?
     */
    public function isVivaldi(): bool;

    /**
     * Is this a Samsung Internet browser?
     */
    public function isSamsungBrowser(): bool;

    /**
     * Is this an Arc browser?
     */
    public function isArc(): bool;

    /**
     * Is this a DuckDuckGo browser?
     */
    public function isDuckDuckGo(): bool;

    /**
     * Is this an in-app browser?
     */
    public function isInApp(): bool;

    /**
     * Is this an Internet Explorer X (or lower version)?
     */
    public function isIEVersion(int $version, string $operator = '='): bool;

    /**
     * Build a human-readable browser name: Internet Explorer 7, Firefox 3.6
     */
    public function browserName(): string;

    /**
     * Browser's vendor like Chrome, Firefox, Opera.
     */
    public function browserFamily(): string;

    /**
     * Build a human-readable browser version. (Cuts the trailing .0 parts)
     */
    public function browserVersion(): string;

    /**
     * Browser's semantic major version.
     */
    public function browserVersionMajor(): int;

    /**
     * Browser's semantic minor version.
     */
    public function browserVersionMinor(): int;

    /**
     * Browser's semantic patch version.
     */
    public function browserVersionPatch(): int;

    /**
     * Browser's rendering engine.
     */
    public function browserEngine(): string;

    /**
     * Operating system's human-friendly name like Windows XP, macOS 10.
     */
    public function platformName(): string;

    /**
     * Operating system's vendor like Linux, Windows, MacOS.
     */
    public function platformFamily(): string;

    /**
     * Build a human-readable os version. (cuts the trailing .0 parts)
     */
    public function platformVersion(): string;

    /**
     * Operating system's semantic major version.
     */
    public function platformVersionMajor(): int;

    /**
     * Operating system's semantic minor version.
     */
    public function platformVersionMinor(): int;

    /**
     * Operating system's semantic patch version.
     */
    public function platformVersionPatch(): int;

    /**
     * Is this a windows operating system?
     */
    public function isWindows(): bool;

    /**
     * Is this a linux operating system?
     */
    public function isLinux(): bool;

    /**
     * Is this a Mac operating system?
     */
    public function isMac(): bool;

    /**
     * Is this an iOS operating system?
     */
    public function isiOS(): bool;

    /**
     * Is this Chrome OS?
     */
    public function isChromeOS(): bool;

    /**
     * Is this HarmonyOS?
     */
    public function isHarmonyOS(): bool;

    /**
     * Is this an android operating system?
     */
    public function isAndroid(): bool;

    /**
     * Device's vendor like Samsung, Apple, Huawei.
     */
    public function deviceFamily(): string;

    /**
     * Device's brand name like iPad, iPhone, Nexus.
     */
    public function deviceModel(): string;

    /**
     * Export the result's data into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
