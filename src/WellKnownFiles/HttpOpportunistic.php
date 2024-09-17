<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class HttpOpportunistic extends WellKnownFile {

    const FILENAME = "http-opportunistic";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "lifetime" => 86400,
            "alt-svc" => [
                "h2=\"example.com:443\"; ma=3600"
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Supports Opportunistic Security for HTTP.", 'well-known-manager');
    }

}
?>