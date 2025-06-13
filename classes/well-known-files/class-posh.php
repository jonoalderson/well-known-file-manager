<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Posh extends Well_Known_File {

    const FILENAME = "posh";
    const CONTENT_TYPE = "text/json";

    public function get_default_content() {
        return json_encode([
            "expires" => "2018-12-31T23:59:59Z",
            "fingerprints" => [
                [
                    "type" => "sha-256",
                    "fingerprint" => "SHA256 fingerprint"
                ]
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Supports POSH (Pervasive Oblivious Secure Hosting) for XMPP.", 'well-known-manager');
    }

}
?>