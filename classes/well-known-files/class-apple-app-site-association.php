<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Apple_App_Site_Association extends Well_Known_File {

    const FILENAME = "apple-app-site-association";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "applinks" => [
                "apps" => [],
                "details" => [
                    [
                        "appID" => "TEAMID.com.example.app",
                        "paths" => ["*"]
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Links your iOS app with your website, enabling features like Universal Links.", 'well-known-manager');
    }

}
?>