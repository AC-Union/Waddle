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

    class Application {

        /**
         * Which server to use
         *
         * @var string
         */
        public $serverType = "\\Waddle\\Server\\HttpServer";

    }