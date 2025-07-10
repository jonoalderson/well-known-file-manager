<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

/**
 * Class AcmeChallenge
 *
 * Manages the ACME challenge file for SSL/TLS certificate issuance.
 *
 */
class Acme_Challenge extends Well_Known_File {

    const FILENAME = 'acme-challenge';
    const CONTENT_TYPE = 'text/plain';

    public function get_default_content() {
        return __('This is a placeholder for ACME challenge responses. Actual content will be provided by your ACME client during the certificate issuance process.', 'well-known-file-manager');
    }

    public function get_description() {
        return __('Used for ACME challenges during SSL/TLS certificate issuance.', 'well-known-file-manager');
    }

}