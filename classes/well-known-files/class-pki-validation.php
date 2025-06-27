<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Pki_Validation extends Well_Known_File {

    const FILENAME = "pki-validation";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "abc123def456";
    }

    public function get_description() {
        return __("Supports domain validation for SSL/TLS certificate issuance.", 'well-known-file-manager');
    }
}
?>