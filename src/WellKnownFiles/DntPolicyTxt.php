<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class DntPolicyTxt extends WellKnownFile {

    const FILENAME = "dnt-policy.txt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "DNT: 1\n";
    }

    public function get_description() {
        return __("Specifies the website's detailed Do Not Track (DNT) policy.", 'well-known-manager');
    }

}
?>