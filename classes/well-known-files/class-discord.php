<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Discord extends Well_Known_File {

    const FILENAME = "discord";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "discord" => [
                "url" => "https://example.com/discord"
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides Discord-related information or configuration.", 'well-known-manager');
    }

}
?>