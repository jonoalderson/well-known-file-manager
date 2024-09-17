<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Csvm extends WellKnownFile {

    const FILENAME = "csvm";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "csvm" => [
                "url" => "https://example.com/csvm"
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Supports the CSV on the Web (CSVW) metadata standard.", 'well-known-manager');
    }

}
?>