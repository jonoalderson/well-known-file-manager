<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Matrix extends WellKnownFile {

    const FILENAME = "matrix";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "m.server" => "matrix.example.com:443"
        ], JSON_PRETTY_PRINT);
    }
    
    public function get_description() {
        return __("Provides information for Matrix protocol server discovery.", 'well-known-manager');
    }
    
}
?>