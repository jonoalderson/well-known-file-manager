<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Dat extends WellKnownFile {

    const FILENAME = "dat";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "url" => "dat://example-dat-url.com",
            "title" => "Example Dat Site",
            "description" => "This is an example Dat site"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides information for the Dat peer-to-peer protocol.", 'well-known-manager');
    }

}
?>
