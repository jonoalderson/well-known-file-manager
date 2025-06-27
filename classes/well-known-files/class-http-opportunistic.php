<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Http_Opportunistic extends Well_Known_File {

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
        return __("Supports Opportunistic Security for HTTP.", 'well-known-file-manager');
    }

}
?>