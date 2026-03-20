<?php

namespace hisorange\BrowserDetect\Stages;

use hisorange\BrowserDetect\Contracts\PayloadInterface;
use hisorange\BrowserDetect\Contracts\StageInterface;

/**
 * BrowserDetect stage to fix mix ups caused by different results.
 *
 * @package hisorange\BrowserDetect\Stages
 */
class BrowserDetect implements StageInterface
{
    /**
     * @param  PayloadInterface $payload
     * @return PayloadInterface
     */
    public function __invoke(PayloadInterface $payload): PayloadInterface
    {
        $agent = $payload->getAgent();

        // Resolve conflicting device type flags into a single type.
        if (!$payload->getValue('isMobile') && !$payload->getValue('isTablet')) {
            $payload->setValue('isMobile', false);
            $payload->setValue('isTablet', false);
            $payload->setValue('isDesktop', true);
        } elseif ($payload->getValue('isTablet')) {
            $payload->setValue('isMobile', false);
            $payload->setValue('isTablet', true);
            $payload->setValue('isDesktop', false);
        } else {
            $payload->setValue('isMobile', true);
            $payload->setValue('isTablet', false);
            $payload->setValue('isDesktop', false);
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
        if (false !== stripos($browserFamily, 'chrom')) {
            $payload->setValue('isChrome', true);
        } elseif (false !== stripos($browserFamily, 'firefox')) {
            $payload->setValue('isFirefox', true);
        } elseif (false !== stripos($browserFamily, 'opera')) {
            $payload->setValue('isOpera', true);
        } elseif (false !== stripos($browserFamily, 'safari')) {
            $payload->setValue('isSafari', true);
        } elseif (
            false !== stripos($browserFamily, 'explorer')
            || false !== stripos($browserFamily, 'ie')
            || false !== stripos($browserFamily, 'trident')
        ) {
            $payload->setValue('isIE', true);
        } elseif (false !== stripos($browserFamily, 'edge')) {
            $payload->setValue('isEdge', true);
        }

        $this->buildVersionAndName($payload, 'browser', $browserFamily);

        // Popular os vendors.
        $platformFamily = $this->getString($payload, 'platformFamily');

        $this->buildVersionAndName($payload, 'platform', $platformFamily);
        if (false !== stripos($platformFamily, 'windows')) {
            $payload->setValue('isWindows', true);
        } elseif (false !== stripos($platformFamily, 'android')) {
            $payload->setValue('isAndroid', true);
        } elseif (
            false !== stripos($platformFamily, 'mac')
            || false !== stripos($platformFamily, 'ios')
        ) {
            $payload->setValue('isMac', true);
        } elseif (false !== stripos($platformFamily, 'linux')) {
            $payload->setValue('isLinux', true);
        }

        # Request: https://github.com/hisorange/browser-detect/issues/156
        $payload->setValue('isInApp', $this->detectIsInApp($payload));

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
        $payload->setValue("{$prefix}Name", trim($family . ' ' . $version));
    }

    /**
     * Code snippet based on https://github.com/f2etw/detect-inapp/blob/master/src/inapp.js#L38-L47
     */
    protected function detectIsInApp(PayloadInterface $payload): bool
    {
        $agent = $payload->getAgent();

        // Simple WebView match
        if (stripos($agent, 'WebView') !== false) {
            return true;
        }

        // Twitter
        if (stripos($agent, 'Twitter') !== false) {
            return true;
        }

        // WeChat
        if (stripos($agent, 'MicroMessenger') !== false) {
            return true;
        }

        // Apple
        if (preg_match('%(iPhone|iPod|iPad)(?!.*Safari\/)%i', $agent)) {
            return true;
        }

        // Android
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
     *
     * @param  string $version
     * @return string
     */
    protected function trimVersion(string $version): string
    {
        return trim((string) preg_replace('%(^0.0.0$|\.0\.0$|\.0$)%', '', $version), '.');
    }
}
