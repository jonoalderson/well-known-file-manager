<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Open_Org extends Well_Known_File {

    const FILENAME = 'openorg';
    const CONTENT_TYPE = 'application/json';

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

    public function get_description() {
        return __('Provides Open Organization information.', 'well-known-manager');
    }

}
