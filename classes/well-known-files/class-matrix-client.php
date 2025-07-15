<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Matrix_Client extends Well_Known_File {

    const FILENAME = "matrix/client";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "m.homeserver" => [
                "base_url" => "https://matrix.example.com/"
            ], 
            "m.identity_server" => [
                "base_url" => "https://identity.example.com/"
            ] 
        ], JSON_PRETTY_PRINT);
    }
    
    public function get_description() {
        return __("Provides information for Matrix protocol server discovery for clients.", 'well-known-file-manager');
    }
    
}
?>