<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Dnt_Policy_Txt extends Well_Known_File {

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