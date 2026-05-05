<?php

return [
    'cache' => [
        /**
         * Interval in seconds, as how long a result should be cached.
         */
        'interval' => 10080,
        /**
         * Cache prefix, the user agent string will be hashed and appended at the end.
         */
        'prefix' => 'bd4_',
        /**
         * Cache driver class for the device-detector engine's internal cache. When null,
         * the library uses its built-in StaticCache. Override to swap in a different driver.
         *
         * Examples:
         *   \DeviceDetector\Cache\StaticCache::class   — in-process static cache (default)
         *   \DeviceDetector\Cache\LaravelCache::class  — persists via Laravel's cache store
         */
        'device-detector' => null,
    ],
    'security' => [
        /**
         * Byte length where the header is cut off, if some attacker sends a long header
         * then the library will make a cut this byte point.
         */
        'max-header-length' => 2048,
    ],
];
