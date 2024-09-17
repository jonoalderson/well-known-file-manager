<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class AtprotoDid extends WellKnownFile {

    const FILENAME = "atproto-did";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "did" => "did:example:123456789abcdefghi"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Specifies the Decentralized Identifier (DID) for the AT Protocol.", 'well-known-manager');
    }

}
?>