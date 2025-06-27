<?php

namespace WellKnownFileManager;

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * An autoloader for the plugin's classes, searching recursively in the classes directory.
 *
 * @param string $class_name The name of the requested class.
 *
 * @return bool Whether or not the requested class was found.
 */
function autoloader( $class_name ) {

	if ( strpos( $class_name, __NAMESPACE__ ) === false ) {
		return false;
	}

	$class_name = str_replace( __NAMESPACE__ . '\\', '', $class_name );
	$class_name = str_replace( '_', '-', $class_name );

	$class_name   = explode( '\\', $class_name );
	$class_name[] = 'class-' . array_pop( $class_name );

	$class_file = implode( '/', $class_name );
	$class_file = strtolower( $class_file ) . '.php';

	$base_dir = Plugin::PLUGIN_FOLDER . '/classes/';

	// Search recursively for the class file.
	$iterator = new \RecursiveIteratorIterator(
		new \RecursiveDirectoryIterator( $base_dir, \FilesystemIterator::SKIP_DOTS )
	);

	foreach ( $iterator as $file ) {
		if ( strtolower( $file->getFilename() ) === basename( $class_file ) ) {
			include_once $file->getPathname();
			return true;
		}
	}

	return false;
}

spl_autoload_register( __NAMESPACE__ . '\autoloader' );
