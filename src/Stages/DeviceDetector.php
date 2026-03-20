<?php

namespace hisorange\BrowserDetect\Stages;

use DeviceDetector\Parser\Device\AbstractDeviceParser;
use hisorange\BrowserDetect\Contracts\PayloadInterface;
use hisorange\BrowserDetect\Contracts\StageInterface;

/**
 * Strong browser and platform detector.
 */
class DeviceDetector implements StageInterface
{
    protected ?\DeviceDetector\DeviceDetector $detector = null;

    public function __invoke(PayloadInterface $payload): PayloadInterface
    {
        if ($this->detector === null) {
            $this->detector = new \DeviceDetector\DeviceDetector;
            // Skip bot detection — CrawlerDetect handles that upstream.
            $this->detector->skipBotDetection(true);
        }
        $this->detector->setUserAgent($payload->getAgent());
        $this->detector->parse();

        $detector = $this->detector;

        $platform = $detector->getOs();
        $browser = $detector->getClient();

        if ($platform !== null && is_array($platform)) {
            if (! empty($platform['name'])) {
                $payload->setValue('platformFamily', $platform['name']);
            }

            if (! empty($platform['version']) && is_string($platform['version'])) {
                foreach ($this->parseVersion($platform['version'], 'platform') as $key => $value) {
                    $payload->setValue($key, $value);
                }
            }
        }

        if ($browser !== null && is_array($browser)) {
            if (! empty($browser['name'])) {
                $payload->setValue('browserFamily', $browser['name']);
            }

            if (! empty($browser['engine'])) {
                $payload->setValue('browserEngine', $browser['engine']);
            }

            if (! empty($browser['version']) && is_string($browser['version'])) {
                foreach ($this->parseVersion($browser['version'], 'browser') as $key => $value) {
                    $payload->setValue($key, $value);
                }
            }
        }

        // Skip device-type classification for bots — they don't have meaningful device info.
        if (! $payload->getValue('isBot')) {
            $deviceType = $detector->getDeviceName();

            if (! empty($deviceType)) {
                if ($deviceType === 'desktop') {
                    $payload->setValue('isDesktop', true);
                } elseif ($deviceType === 'tablet') {
                    $payload->setValue('isTablet', true);
                } elseif ($deviceType === 'smartphone' || $deviceType === 'feature phone' || $deviceType === 'phablet') {
                    $payload->setValue('isMobile', true);
                } elseif ($deviceType === 'tv') {
                    $payload->setValue('isTV', true);
                } elseif ($deviceType === 'console') {
                    $payload->setValue('isConsole', true);
                } elseif ($deviceType === 'wearable') {
                    $payload->setValue('isWearable', true);
                }
            }

            $brand = $detector->getBrand();
            if (! empty($brand)) {
                $payload->setValue('deviceFamily', AbstractDeviceParser::getFullName($brand));
            }

            $model = $detector->getModel();
            if (! empty($model)) {
                $payload->setValue('deviceModel', $model);
            }
        }

        return $payload;
    }

    /**
     * Parse semantic version strings into major.minor.patch pieces.
     *
     * @return array<string, int>
     */
    protected function parseVersion(string $version, string $prefix): array
    {
        $response = [];

        if (preg_match('%(?<major>\d+)((\.(?<minor>\d+)((\.(?<patch>\d+))|$))|$)%', $version, $match)) {
            foreach ($match as $key => $value) {
                if ($key === 'major' || $key === 'minor' || $key === 'patch') {
                    $response[$prefix.'Version'.ucfirst($key)] = (int) $value;
                }
            }
        }

        return $response;
    }
}
