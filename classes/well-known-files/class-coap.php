<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Coap extends Well_Known_File {

    const FILENAME = "coap";
    const CONTENT_TYPE = "application/link-format";
  
    public function get_default_content() {
        return "</>;rt=\"core\";ct=40,</sensors>;ct=40";
    }
    
    public function get_description() {
        return __("Defines resources for the Constrained Application Protocol (CoAP).", 'well-known-file-manager');
    }
    
}
?>