<?php
    /**
     * Waddle Framework
     * 
     * @author   Tianle Xu <xtl@xtlsoft.top>
     * @package  Waddle
     * @category framework
     * @license  GPL-V3
     * @link     https://github.com/AC-Union/Waddle/
     */

    namespace Waddle;

    class Log {

        /**
         * Configure of log module
         *
         * @var array
         */
        public static $config = [
            "stream" => [
                "info"    => STDOUT,
                "warning" => STDOUT,
                "error"   => STDOUT,
                "default" => STDOUT
            ]
        ];

        /**
         * Add a log
         *
         * @param string $type
         * @param string $msg
         * 
         * @return void
         */
        public static function add(string $type = "info", string $msg = "null") {

            if (isset(self::$config["stream"][$type])){
                $stream = self::$config["stream"][$type];
            }else{
                $stream = self::$config["stream"]["default"];
            }

            $msg = "[" . strtoupper($type) . "][" . date("Y-m-d h:i:s", time()) . "]" . $msg . PHP_EOL;

            fwrite($stream, $msg);

        }

        /**
         * Call a static function
         *
         * @param string $name
         * @param array $args
         * 
         * @return void
         */
        public static function __callStatic($name, $args) {

            if (count($args) !== 1) throw new \Waddle\Exception\InvalidArgumentException(
                "\\Waddle\\Log::$name only needs 1 argument, " . count($args) . "given."
            );

            return call_user_func("\\Waddle\\Log::add", $name, $args[0]);

        }

    }