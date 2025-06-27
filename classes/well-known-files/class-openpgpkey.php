<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Openpgpkey extends Well_Known_File {

    const FILENAME = "openpgpkey";
    const CONTENT_TYPE = "application/pgp-keys";

    public function get_default_content() {
        return "-----BEGIN PGP PUBLIC KEY BLOCK-----\n...\n-----END PGP PUBLIC KEY BLOCK-----";
    }

    public function get_description() {
        return __("Stores OpenPGP public keys for email addresses on the domain.", 'well-known-file-manager');
    }

}
?>