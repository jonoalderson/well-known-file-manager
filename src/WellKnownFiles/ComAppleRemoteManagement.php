<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class ComAppleRemoteManagement extends WellKnownFile {

    const FILENAME = "com.apple.remotemanagement";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "mdm" => [
                "server_url" => "https://example.com/mdm",
                "checkin_url" => "https://example.com/checkin",
                "access_rights" => 1
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Configures Apple's remote management for iOS and macOS devices.", 'well-known-manager');
    }

}
?>