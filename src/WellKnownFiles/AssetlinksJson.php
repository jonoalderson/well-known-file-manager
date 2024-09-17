<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class AssetlinksJson extends WellKnownFile {

    const FILENAME = "assetlinks.json";
    const CONTENT_TYPE = "application/json";
    public function get_default_content() {
        return json_encode([
            "relation" => ["delegate_permission/common.handle_all_urls"],
            "target" => [
                "namespace" => "android_app",
                "package_name" => "com.example",
                "sha256_cert_fingerprints" => ["4B:90:E2:12:34:56:78:90:AB:CD:EF:12:34:56:78:90"]
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Associates your Android app with your website for features like App Links.", 'well-known-manager');
    }

}
?>