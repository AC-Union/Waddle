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

    namespace Waddle\Util;

    class SharedObject {

        /**
         * Shared Objects
         *
         * @var array
         */
        protected static $objects = [];

        /**
         * Get an object
         *
         * @param string $className
         * 
         * @return mixed
         */
        public static function get(string $className) {

            if (!isset(self::$objects[$className])) {
                self::set($className);
            }

            return self::$objects[$className];

        }

        /**
         * Set an object
         *
         * @param string $className
         * 
         * @throws \Waddle\Exception\NotFoundException
         * 
         * @return void
         */
        protected static function set(string $className) {

            if (!class_exists($className)) {
                throw new \Waddle\Exception\NotFoundException("Class not found: " . $className);
            }else{
                self::$objects[$className] = new $className;
            }

        }

    }