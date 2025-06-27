<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Vercel_Flags extends Well_Known_File {

    const FILENAME = "vercel/flags";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "flags" => [
                "feature-1" => true,
                "feature-2" => false
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Defines feature flags for Vercel deployments.", 'well-known-file-manager');
    }

}
?>