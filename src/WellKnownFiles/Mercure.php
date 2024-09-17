<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Mercure extends WellKnownFile {

    const FILENAME = "mercure";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "mercure" => [
                "publish" => "https://example.com/.well-known/mercure",
                "subscribe" => "https://example.com/.well-known/mercure"
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Specifies the Mercure protocol hub for real-time updates.", 'well-known-manager');
    }
}
?>