<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Uma2_Configuration extends Well_Known_File {

    const FILENAME = "uma2-configuration";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "issuer" => "https://example.com",
            "authorization_endpoint" => "https://example.com/oauth2/authorize",
            "token_endpoint" => "https://example.com/oauth2/token",
            "userinfo_endpoint" => "https://example.com/oauth2/userinfo",
            "jwks_uri" => "https://example.com/.well-known/jwks.json",
            "response_types_supported" => ["code", "token"],    
            "subject_types_supported" => ["public"],
            "id_token_signing_alg_values_supported" => ["RS256"]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides User-Managed Access 2.0 configuration information.", 'well-known-file-manager');
    }
   
}
?>