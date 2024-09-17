<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class PubvendorsJson extends WellKnownFile {

    const FILENAME = "pubvendors.json";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "pubvendors" => [
                "vendors" => [
                    [
                        "id" => 1,
                        "name" => "Vendor 1",
                        "policyUrl" => "https://example.com/vendor1/policy"
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT);  
    }

    public function get_description() {
        return __("Lists vendors for the Transparency and Consent Framework in digital advertising.", 'well-known-manager');
    }
}
?>