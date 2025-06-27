<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Mercure extends Well_Known_File {

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
        return __("Specifies the Mercure protocol hub for real-time updates.", 'well-known-file-manager');
    }
}
?>