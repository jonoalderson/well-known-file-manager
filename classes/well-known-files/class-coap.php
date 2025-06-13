<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

/**
 * Class Coap
 *
 * Manages the CoAP file for the Constrained Application Protocol.
 */
class Coap extends Well_Known_File {

    const FILENAME = "coap";
    const CONTENT_TYPE = "application/link-format";
  
    public function get_default_content() {
        return "</>;rt=\"core\";ct=40,</sensors>;ct=40";
    }
    
    public function get_description() {
        return __("Defines resources for the Constrained Application Protocol (CoAP).", 'well-known-manager');
    }
    
}
?>