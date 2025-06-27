<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Atproto_Did extends Well_Known_File {

    const FILENAME = "atproto-did";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "did" => "did:example:123456789abcdefghi"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Specifies the Decentralized Identifier (DID) for the AT Protocol.", 'well-known-file-manager');
    }

}
?>