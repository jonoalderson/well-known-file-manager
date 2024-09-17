<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class OpenidConfiguration extends WellKnownFile {

    const FILENAME = "openid-configuration";
    const CONTENT_TYPE = "application/json";

    public function get_content_type() {
        return 'application/json';
    }

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
        return __("Provides OpenID Connect configuration information.", 'well-known-manager');
    }
}
?>