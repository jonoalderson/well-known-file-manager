<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Browser_Id extends Well_Known_File {

    const FILENAME = "browserid";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "public-key" => "example-public-key"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Supports the BrowserID authentication protocol (now deprecated).", 'well-known-manager');
    }

}
?>