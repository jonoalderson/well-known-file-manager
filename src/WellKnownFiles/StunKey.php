<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class StunKey extends WellKnownFile {

    const FILENAME = "stun-key";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "realm=example.com\nserver=stun.example.com:3478\nfingerprint=sha-256 11:22:33:44:55:66:77:88:99:00:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:00:AA:BB:CC:DD:EE";
    }

    public function get_description() {
        return __("Provides STUN (Session Traversal Utilities for NAT) server information.", 'well-known-manager');
    }
}
?>