<?php

namespace Pataar\BrowserDetect\Stages;

use Pataar\BrowserDetect\Contracts\PayloadInterface;
use Pataar\BrowserDetect\Contracts\StageInterface;

/**
 * BrowserDetect stage to fix mix ups caused by different results.
 */
class BrowserDetect implements StageInterface
{
    /**
     * @var list<string>
     */
    protected const IN_APP_TOKENS = [
        'MicroMessenger',
        'Twitter',
        'WebView',
    ];

    public function __invoke(PayloadInterface $payload): PayloadInterface
    {
        $agent = $payload->getAgent();

        // Resolve conflicting device type flags into a single type.
        if ($payload->getValue('isTablet')) {
            $payload->setValue('isMobile', false);
            $payload->setValue('isDesktop', false);
        } elseif ($payload->getValue('isMobile')) {
            $payload->setValue('isTablet', false);
            $payload->setValue('isDesktop', false);
        } else {
            $payload->setValue('isDesktop', true);
        }

        // Prerender bot checker
        if (stripos($agent, 'Prerender') !== false) {
            $payload->setValue('isBot', true);
            $payload->setValue('isTablet', false);

            if (stripos($agent, 'Android') !== false) {
                $payload->setValue('isMobile', true);
                $payload->setValue('isDesktop', false);
            } else {
                $payload->setValue('isMobile', false);
                $payload->setValue('isDesktop', true);
            }
        }

        // Popular browser vendors.
        $browserFamily = $this->getString($payload, 'browserFamily');
        if (stripos($browserFamily, 'chrom') !== false) {
            $payload->setValue('isChrome', true);
        } elseif (stripos($browserFamily, 'firefox') !== false) {
            $payload->setValue('isFirefox', true);
        } elseif (stripos($browserFamily, 'opera') !== false) {
            $payload->setValue('isOpera', true);
        } elseif (stripos($browserFamily, 'safari') !== false) {
            $payload->setValue('isSafari', true);
        } elseif (preg_match('/explorer|\bie\b|trident/i', $browserFamily)) {
            $payload->setValue('isIE', true);
        } elseif (stripos($browserFamily, 'edge') !== false) {
            $payload->setValue('isEdge', true);
        }

        $this->buildVersionAndName($payload, 'browser', $browserFamily);

        // Popular os vendors.
        $platformFamily = $this->getString($payload, 'platformFamily');

        $this->buildVersionAndName($payload, 'platform', $platformFamily);
        if (stripos($platformFamily, 'windows') !== false) {
            $payload->setValue('isWindows', true);
        } elseif (stripos($platformFamily, 'android') !== false) {
            $payload->setValue('isAndroid', true);
        } elseif (
            stripos($platformFamily, 'mac') !== false
            || stripos($platformFamily, 'ios') !== false
        ) {
            $payload->setValue('isMac', true);
        } elseif (stripos($platformFamily, 'linux') !== false) {
            $payload->setValue('isLinux', true);
        }

        // Request: https://github.com/hisorange/browser-detect/issues/156
        $payload->setValue('isInApp', $this->detectIsInApp($agent));

        return $payload;
    }

    /**
     * Build version string and human-readable name for the given prefix (browser or platform).
     */
    protected function buildVersionAndName(PayloadInterface $payload, string $prefix, string $family): void
    {
        $version = $this->trimVersion(implode('.', [
            $this->getString($payload, "{$prefix}VersionMajor", '0'),
            $this->getString($payload, "{$prefix}VersionMinor", '0'),
            $this->getString($payload, "{$prefix}VersionPatch", '0'),
        ]));

        $payload->setValue("{$prefix}Version", $version);
        $payload->setValue("{$prefix}Name", trim($family.' '.$version));
    }

    /**
     * Code snippet based on https://github.com/f2etw/detect-inapp/blob/master/src/inapp.js#L38-L47
     */
    protected function detectIsInApp(string $agent): bool
    {
        foreach (self::IN_APP_TOKENS as $token) {
            if (stripos($agent, $token) !== false) {
                return true;
            }
        }

        // Apple in-app: iOS device without Safari in the UA
        if (preg_match('%(iPhone|iPod|iPad)(?!.*Safari\/)%i', $agent)) {
            return true;
        }

        // Android WebView marker
        if (preg_match('%Android.*wv%i', $agent)) {
            return true;
        }

        return false;
    }

    protected function getString(PayloadInterface $payload, string $key, string $default = ''): string
    {
        $value = $payload->getValue($key);

        if (is_string($value)) {
            return $value;
        }

        return is_scalar($value) ? (string) $value : $default;
    }

    /**
     * Trim the trailing .0 versions from a semantic version string.
     * It makes it more readable for an end user.
     */
    protected function trimVersion(string $version): string
    {
        return trim((string) preg_replace('%(^0.0.0$|\.0\.0$|\.0$)%', '', $version), '.');
    }
}
