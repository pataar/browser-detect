<?php

namespace Pataar\BrowserDetect;

use Pataar\BrowserDetect\Contracts\ResultInterface;

/**
 * The object is used for safely accessing the
 * result of the parsing, this is necessary
 * to allow us to change the implementation
 * behind the values.
 */
class Result implements ResultInterface
{
    /**
     * @var string
     */
    protected $userAgent = 'Unknown';

    /**
     * @var bool
     */
    protected $isMobile = false;

    /**
     * @var bool
     */
    protected $isTablet = false;

    /**
     * @var bool
     */
    protected $isDesktop = false;

    /**
     * @var bool
     */
    protected $isBot = false;

    /**
     * @var bool
     */
    protected $isTV = false;

    /**
     * @var bool
     */
    protected $isConsole = false;

    /**
     * @var bool
     */
    protected $isWearable = false;

    /**
     * @var bool
     */
    protected $isChrome = false;

    /**
     * @var bool
     */
    protected $isFirefox = false;

    /**
     * @var bool
     */
    protected $isOpera = false;

    /**
     * @var bool
     */
    protected $isSafari = false;

    /**
     * @var bool
     */
    protected $isEdge = false;

    /**
     * @var bool
     */
    protected $isBrave = false;

    /**
     * @var bool
     */
    protected $isVivaldi = false;

    /**
     * @var bool
     */
    protected $isSamsungBrowser = false;

    /**
     * @var bool
     */
    protected $isArc = false;

    /**
     * @var bool
     */
    protected $isDuckDuckGo = false;

    /**
     * @var bool
     */
    protected $isInApp = false;

    /**
     * @var bool
     */
    protected $isIE = false;

    /**
     * @var string
     */
    protected $browserName = 'Unknown';

    /**
     * @var string
     */
    protected $browserFamily = 'Unknown';

    /**
     * @var string
     */
    protected $browserVersion = '';

    /**
     * @var int
     */
    protected $browserVersionMajor = 0;

    /**
     * @var int
     */
    protected $browserVersionMinor = 0;

    /**
     * @var int
     */
    protected $browserVersionPatch = 0;

    /**
     * @var string
     */
    protected $browserEngine = 'Unknown';

    /**
     * @var string
     */
    protected $platformName = 'Unknown';

    /**
     * @var string
     */
    protected $platformFamily = 'Unknown';

    /**
     * @var string
     */
    protected $platformVersion = '';

    /**
     * @var int
     */
    protected $platformVersionMajor = 0;

    /**
     * @var int
     */
    protected $platformVersionMinor = 0;

    /**
     * @var int
     */
    protected $platformVersionPatch = 0;

    /**
     * @var bool
     */
    protected $isWindows = false;

    /**
     * @var bool
     */
    protected $isLinux = false;

    /**
     * @var bool
     */
    protected $isMac = false;

    /**
     * @var bool
     */
    protected $isiOS = false;

    /**
     * @var bool
     */
    protected $isChromeOS = false;

    /**
     * @var bool
     */
    protected $isHarmonyOS = false;

    /**
     * @var bool
     */
    protected $isAndroid = false;

    /**
     * @var string
     */
    protected $deviceFamily = 'Unknown';

    /**
     * @var string
     */
    protected $deviceModel = '';

    /**
     * @param  array<string, mixed>  $result
     */
    public function __construct(array $result)
    {
        foreach ($result as $property => $value) {
            $this->$property = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function userAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * {@inheritdoc}
     */
    public function isMobile(): bool
    {
        return $this->isMobile;
    }

    /**
     * {@inheritdoc}
     */
    public function isTablet(): bool
    {
        return $this->isTablet;
    }

    /**
     * {@inheritdoc}
     */
    public function isDesktop(): bool
    {
        return $this->isDesktop;
    }

    /**
     * {@inheritdoc}
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * {@inheritdoc}
     */
    public function isTV(): bool
    {
        return $this->isTV;
    }

    /**
     * {@inheritdoc}
     */
    public function isConsole(): bool
    {
        return $this->isConsole;
    }

    /**
     * {@inheritdoc}
     */
    public function isWearable(): bool
    {
        return $this->isWearable;
    }

    /**
     * {@inheritdoc}
     */
    public function deviceType(): string
    {
        if ($this->isMobile) {
            return 'Mobile';
        }
        if ($this->isTablet) {
            return 'Tablet';
        }
        if ($this->isTV) {
            return 'TV';
        }
        if ($this->isConsole) {
            return 'Console';
        }
        if ($this->isWearable) {
            return 'Wearable';
        }
        if ($this->isBot) {
            return 'Bot';
        }
        if ($this->isDesktop) {
            return 'Desktop';
        }

        return 'Unknown';
    }

    /**
     * {@inheritdoc}
     */
    public function isChrome(): bool
    {
        return $this->isChrome;
    }

    /**
     * {@inheritdoc}
     */
    public function isFirefox(): bool
    {
        return $this->isFirefox;
    }

    /**
     * {@inheritdoc}
     */
    public function isOpera(): bool
    {
        return $this->isOpera;
    }

    /**
     * {@inheritdoc}
     */
    public function isSafari(): bool
    {
        return $this->isSafari;
    }

    /**
     * {@inheritDoc}
     */
    public function isEdge(): bool
    {
        return $this->isEdge;
    }

    /**
     * {@inheritdoc}
     */
    public function isBrave(): bool
    {
        return $this->isBrave;
    }

    /**
     * {@inheritdoc}
     */
    public function isVivaldi(): bool
    {
        return $this->isVivaldi;
    }

    /**
     * {@inheritdoc}
     */
    public function isSamsungBrowser(): bool
    {
        return $this->isSamsungBrowser;
    }

    /**
     * {@inheritdoc}
     */
    public function isArc(): bool
    {
        return $this->isArc;
    }

    /**
     * {@inheritdoc}
     */
    public function isDuckDuckGo(): bool
    {
        return $this->isDuckDuckGo;
    }

    /**
     * {@inheritdoc}
     */
    public function isInApp(): bool
    {
        return $this->isInApp;
    }

    /**
     * {@inheritdoc}
     */
    public function isIE(): bool
    {
        return $this->isIE;
    }

    /**
     * {@inheritdoc}
     */
    public function isIEVersion(int $version, string $operator = '='): bool
    {
        return $this->isIE && version_compare($this->browserVersion, (string) $version, $operator);
    }

    /**
     * {@inheritdoc}
     */
    public function browserVersion(): string
    {
        return $this->browserVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function browserName(): string
    {
        return $this->browserName;
    }

    /**
     * {@inheritdoc}
     */
    public function browserFamily(): string
    {
        return $this->browserFamily;
    }

    /**
     * {@inheritdoc}
     */
    public function browserVersionMajor(): int
    {
        return (int) $this->browserVersionMajor;
    }

    /**
     * {@inheritdoc}
     */
    public function browserVersionMinor(): int
    {
        return (int) $this->browserVersionMinor;
    }

    /**
     * {@inheritdoc}
     */
    public function browserVersionPatch(): int
    {
        return (int) $this->browserVersionPatch;
    }

    /**
     * {@inheritdoc}
     */
    public function browserEngine(): string
    {
        return $this->browserEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function platformName(): string
    {
        return $this->platformName;
    }

    /**
     * {@inheritdoc}
     */
    public function platformFamily(): string
    {
        return $this->platformFamily;
    }

    /**
     * {@inheritdoc}
     */
    public function platformVersion(): string
    {
        return $this->platformVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function platformVersionMajor(): int
    {
        return (int) $this->platformVersionMajor;
    }

    /**
     * {@inheritdoc}
     */
    public function platformVersionMinor(): int
    {
        return (int) $this->platformVersionMinor;
    }

    /**
     * {@inheritdoc}
     */
    public function isWindows(): bool
    {
        return $this->isWindows;
    }

    /**
     * {@inheritdoc}
     */
    public function isLinux(): bool
    {
        return $this->isLinux;
    }

    /**
     * {@inheritdoc}
     */
    public function isMac(): bool
    {
        return $this->isMac;
    }

    /**
     * {@inheritdoc}
     */
    public function isiOS(): bool
    {
        return $this->isiOS;
    }

    /**
     * {@inheritdoc}
     */
    public function isChromeOS(): bool
    {
        return $this->isChromeOS;
    }

    /**
     * {@inheritdoc}
     */
    public function isHarmonyOS(): bool
    {
        return $this->isHarmonyOS;
    }

    /**
     * {@inheritdoc}
     */
    public function isAndroid(): bool
    {
        return $this->isAndroid;
    }

    /**
     * {@inheritdoc}
     */
    public function platformVersionPatch(): int
    {
        return (int) $this->platformVersionPatch;
    }

    /**
     * {@inheritdoc}
     */
    public function deviceFamily(): string
    {
        return $this->deviceFamily;
    }

    /**
     * {@inheritdoc}
     */
    public function deviceModel(): string
    {
        return $this->deviceModel;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        /** @var array<string, mixed> $vars */
        $vars = get_object_vars($this);

        return $vars;
    }
}
