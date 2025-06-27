<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Csvm extends Well_Known_File {

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
        return __("Supports the CSV on the Web (CSVW) metadata standard.", 'well-known-file-manager');
    }

}
?>