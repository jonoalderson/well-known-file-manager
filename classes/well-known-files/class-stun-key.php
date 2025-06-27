<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Stun_Key extends Well_Known_File {

    const FILENAME = "stun-key";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "realm=example.com\nserver=stun.example.com:3478\nfingerprint=sha-256 11:22:33:44:55:66:77:88:99:00:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:00:AA:BB:CC:DD:EE";
    }

    public function get_description() {
        return __("Provides STUN (Session Traversal Utilities for NAT) server information.", 'well-known-file-manager');
    }
}
?>