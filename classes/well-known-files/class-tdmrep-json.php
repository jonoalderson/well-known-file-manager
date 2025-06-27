<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Tdmrep_Json extends Well_Known_File {
    
    const FILENAME = "tdmrep.json"; 
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "tdm" => [
                "url" => "https://example.com/tdm"
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides information about the Trusted Data Management (TDM) service.", 'well-known-file-manager');
    }

}
?>