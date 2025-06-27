<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Xrp_Ledger_Toml extends Well_Known_File {

    const FILENAME = "xrp-ledger.toml";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "ACCOUNT: rExampleAddress\nDOMAIN: example.com\n";
    }

    public function get_description() {
        return __("Provides information for XRP Ledger domain verification.", 'well-known-file-manager');
    }

}
?>