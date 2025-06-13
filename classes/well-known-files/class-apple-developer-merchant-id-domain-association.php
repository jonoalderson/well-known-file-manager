<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Apple_Developer_Merchant_Id_Domain_Association extends Well_Known_File {

    const FILENAME = "apple-developer-merchantid-domain-association";
    const CONTENT_TYPE = "application/json";

    public function get_default_content() {
        return json_encode([
            "merchant_id" => "merchant.com.example"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Verifies domain ownership for Apple Pay merchant validation.", 'well-known-manager');
    }

}
?>