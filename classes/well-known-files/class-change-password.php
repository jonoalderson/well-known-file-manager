<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Change_Password extends Well_Known_File {

    const FILENAME     = 'change-password';
    const CONTENT_TYPE = 'application/json';

    public function get_default_content() {
        return json_encode(
            [
				'url'     => 'https://example.com/account/change-password',
				'methods' => [
					'GET',
					'POST',
				],
			],
			JSON_PRETTY_PRINT
		);
	}

	public function get_description() {
		return __( 'Provides the URL where users can change their account password.', 'well-known-manager' );
	}


}
