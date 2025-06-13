<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Security_Txt extends Well_Known_File {

    const FILENAME = "security.txt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "Contact: mailto:security@example.com\nExpires: 2023-12-31T23:59:59.000Z\nEncryption: https://example.com/pgp-key.txt\nAcknowledgments: https://example.com/hall-of-fame.html\nPreferred-Languages: en, es\nCanonical: https://example.com/.well-known/security.txt\nPolicy: https://example.com/security-policy.html";
    }

    public function get_description() {
        return __("Provides security policy and contact information for ethical hackers and researchers.", 'well-known-manager');
    }

}
?>