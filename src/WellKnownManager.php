<?php

namespace WellKnownManager;

class WellKnownManager {
    private $admin;

    public function init() {
        $this->admin = new Admin();
        $this->admin->register_hooks();
    }

    public static function get_well_known_file_classes() {
        $files = glob(WELL_KNOWN_MANAGER_DIR . '/src/WellKnownFiles/*.php');
        foreach ($files as $file) {
            $class_name = 'WellKnownManager\\WellKnownFiles\\' . basename($file, '.php');
            if (class_exists($class_name)) {
                $well_known_classes[] = $class_name;
            }
        }
        return $well_known_classes;
    }

    public static function get_well_known_files() {
        $well_known_classes = self::get_well_known_file_classes();
        $well_known_files = [];
        foreach ($well_known_classes as $class_name) {
            $instance = new $class_name();
            $well_known_files[$class_name] = $instance::FILENAME;
        }

        return $well_known_files;
    }

}
?>