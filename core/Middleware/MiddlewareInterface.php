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

    namespace Waddle\Middleware;

    interface MiddlewareInterface {

        /**
         * Request Event Handler
         *
         * @param array $header
         * @param string $body
         * 
         * @return array
         */
        public function request($header, string $body) : array;

        public function response(\Waddle\Response $response) : \Waddle\Response;

    }