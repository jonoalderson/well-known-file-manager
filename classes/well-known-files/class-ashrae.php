<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Ashrae extends Well_Known_File {

    const FILENAME = "ashrae";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return __("ACME Inc's implementation of ASHRAE BACnet is a communication protocol for building automation and control networks, enabling devices to exchange information and perform functions within a building automation system.", 'well-known-file-manager');
    }

    public function get_description() {
        return __("Provides information about ASHRAE BACnet implementation for building automation systems.", 'well-known-file-manager');
    }

}   
?>