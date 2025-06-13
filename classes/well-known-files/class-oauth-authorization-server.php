<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class OAuth_Authorization_Server extends Well_Known_File {

    const FILENAME = "oauth-authorization-server";
    const CONTENT_TYPE = "application/json";
   
    public function get_default_content() {
        return json_encode([
            "issuer" => "https://example.com",
            "authorization_endpoint" => "https://example.com/oauth2/authorize",
            "token_endpoint" => "https://example.com/oauth2/token",
            "jwks_uri" => "https://example.com/.well-known/jwks.json",
            "response_types_supported" => ["code", "token"],
            "subject_types_supported" => ["public"],
            "id_token_signing_alg_values_supported" => ["RS256"]
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Specifies the OAuth 2.0 Authorization Server metadata.", 'well-known-manager');
    }
}
?>