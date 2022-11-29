<?php
    class Autoload {

        private const DIRS = [
            "db",
            "entity",
        ];

        public static function init() {
            spl_autoload_register(['Autoload', 'load']);
        }

        private static function load($class_name) {
            foreach (self::DIRS as $dir) {
                $file_name = self::camelCaseToSnakeCase(str_replace($dir . "\\", "", $class_name));
                $file_path = $_SERVER["DOCUMENT_ROOT"] . "/" . $dir . "/" . $file_name . ".php";
                if (file_exists($file_path)) {
                    require_once $file_path;
                }
            }
        }
        
        private static function camelCaseToSnakeCase($string) :string {
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
        }
    }

    Autoload::init();
 ?>