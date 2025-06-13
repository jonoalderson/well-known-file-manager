<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Nodeinfo extends Well_Known_File {

    const FILENAME = "nodeinfo";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "links" => [
                [
                    "rel" => "http://nodeinfo.diaspora.software/ns/schema/2.0",
                    "href" => "https://example.com/nodeinfo/2.0"
                ]
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides metadata about the server for federated networks.", 'well-known-manager');
    }
}
?>