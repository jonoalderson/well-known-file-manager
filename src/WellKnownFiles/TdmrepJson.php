<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class TdmrepJson extends WellKnownFile {
    
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
        return __("Provides information about the Trusted Data Management (TDM) service.", 'well-known-manager');
    }

}
?>