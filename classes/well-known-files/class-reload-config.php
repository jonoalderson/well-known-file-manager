<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Reload_Config extends Well_Known_File {

    const FILENAME = "reload-config";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "overlay_name" => "example.com",
            "node_id" => "NodeID-JQJ1eMF8cMxBBNwf9DhfXJRe3F8bn6qM",
            "bootstrap_ip" => "192.0.2.1",
            "bootstrap_port" => 6001
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides configuration for the RELOAD (REsource LOcation And Discovery) protocol.", 'well-known-manager');
    }
}
?>