<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class AppleAppSiteAssociation extends WellKnownFile {

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