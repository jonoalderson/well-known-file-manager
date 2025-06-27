<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

/**
 * Class AiPluginJson
 *
 * Manages the ai-plugin.json file for AI plugin configuration.
 */
class Ai_Plugin_Json extends Well_Known_File {

    const FILENAME = 'ai-plugin.json';
    const CONTENT_TYPE = 'application/json';

    public function get_default_content() {
        $default_content = [
            'schema_version' => 'v1',
            'name_for_human' => 'Example Plugin',
            'name_for_model' => 'example_plugin',
            'description_for_human' => 'Plugin for example purposes.',
            'description_for_model' => 'This is an example plugin for AI models.',
            'auth' => [
                'type' => 'none',
            ],
            'api' => [
                'type' => 'openapi',
                'url' => 'https://example.com/openapi.yaml',
            ],
            'logo_url' => 'https://example.com/logo.png',
            'contact_email' => 'support@example.com',
            'legal_info_url' => 'https://example.com/legal',
        ];

        return wp_json_encode($default_content, JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __('Defines the configuration for an AI plugin, allowing integration with AI models like ChatGPT.', 'well-known-file-manager');
    }
}