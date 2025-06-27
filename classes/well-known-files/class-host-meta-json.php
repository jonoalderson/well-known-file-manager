<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Host_Meta_Json extends Well_Known_File {

    const FILENAME = "host-meta.json";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "links" => [
                [
                    "rel" => "http://webfinger.net/rel/profile-page",
                    "href" => "https://example.com/profile"
                ]
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides host metadata in JSON format for web-based protocols.", 'well-known-file-manager');
    }
    
}
?>