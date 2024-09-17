<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

/**
 * Class Openorg.
 *
 * Provides Open Organization information.
 *
 * @package WellKnownManager\WellKnownFiles
 */
class Openorg extends WellKnownFile {

    /**
     * The filename for the well-known file.
     *
     * @var string
     */
    const FILENAME = 'openorg';

    /**
     * The content type for the well-known file.
     *
     * @var string
     */
    const CONTENT_TYPE = 'application/json';

    /**
     * Get the default content.
     *
     * @return string The default content in JSON format.
     */
    public function get_default_content() {
        return json_encode([
            'name' => 'Example Organization',
            'url' => 'https://example.com',
            'logo' => 'https://example.com/logo.png',
            'contact' => [
                'email' => 'contact@example.com',
                'phone' => '+1234567890'
            ]
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Get the description of the well-known file.
     *
     * @return string The description of the well-known file.
     */
    public function get_description() {
        return __('Provides Open Organization information.', 'well-known-manager');
    }

}
