<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Did_Json extends Well_Known_File {

    const FILENAME = "did";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "did" => "did:example:123456789abcdefghi"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Specifies the Decentralized Identifier (DID) for the domain.", 'well-known-manager');
    }

}
?>