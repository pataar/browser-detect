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
         * Enable the device-detector engine's own internal cache via Laravel's cache store.
         * When enabled, parsed YAML device definition data is cached by the underlying
         * matomo/device-detector library, reducing file reads on repeated parses.
         * Requires a Laravel application context — do not enable in standalone mode.
         */
        'device-detector' => false,
    ],
    'security' => [
        /**
         * Byte length where the header is cut off, if some attacker sends a long header
         * then the library will make a cut this byte point.
         */
        'max-header-length' => 2048,
    ],
];
