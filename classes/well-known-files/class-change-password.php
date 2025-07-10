<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Change_Password extends Well_Known_File {

    const FILENAME     = 'change-password';
    const CONTENT_TYPE = 'text/plain';
    const FILE_TYPE    = 'redirect';

    /**
     * Get the content of the file (redirect type).
     * Only uses the database or default, never a physical file.
     *
     * @return string The content of the file.
     */
    public function get_content() {
        $content = get_option($this->get_option_name());
        if ($content !== false) {
            return $content;
        }
        return $this->get_default_content();
    }

    public function get_default_content() {
        return wp_lostpassword_url();
	}

	public function get_description() {
		return __( 'Provides the URL where users can change their account password.', 'well-known-file-manager' );
	}

	/**
	 * Get the redirect URL for password change.
	 *
	 * @return string The redirect URL.
	 */
	public function get_redirect_url() {
		$content = $this->get_content();
		$decoded = json_decode($content, true);
		
		if ($decoded && isset($decoded['url'])) {
			return $decoded['url'];
		}
		
		// Fallback to WordPress lost password URL
		return wp_lostpassword_url();
	}

	/**
	 * Update the redirect URL.
	 *
	 * @param string $url The new redirect URL.
	 * @return bool Whether the update was successful.
	 */
	public function update_redirect_url($url) {
		$content = $this->get_content();
		$decoded = json_decode($content, true);
		
		if (!$decoded) {
			$decoded = [
				'methods' => ['GET', 'POST']
			];
		}
		
		$decoded['url'] = esc_url_raw($url);
		
		return $this->update_content(json_encode($decoded, JSON_PRETTY_PRINT));
	}


}
