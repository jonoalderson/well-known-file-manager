<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Matrix_Server extends Well_Known_File {

    const FILENAME = "matrix/server";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "m.server" => "matrix.example.com:443"
        ], JSON_PRETTY_PRINT);
    }
    
    public function get_description() {
        return __("Provides Matrix server delegation information for federation traffic routing. Used when your homeserver is not accessible on the default federation port (8448) or domain.", 'well-known-file-manager');
    }
    
}
?>