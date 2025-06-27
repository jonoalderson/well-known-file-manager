<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Mta_Sts_Txt extends Well_Known_File {

    const FILENAME = "mta-sts.txt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "version: STSv1\nmode: enforce\nmx: mail.example.com\nmax_age: 86400";
    }

    public function get_description() {
        return __("Defines the MTA-STS (SMTP MTA Strict Transport Security) policy.", 'well-known-file-manager');
    }
}
?>