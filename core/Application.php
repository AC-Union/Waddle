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

        /**
         * Register a Middleware
         *
         * @param \Waddle\Middleware\MiddlewareInterface $m
         * @return self
         */
        public function registerMiddleware(\Waddle\Middleware\MiddlewareInterface $m) : self {

            \Waddle\Util\Event::add("middleware.before", function (&$header, &$body) use ($m) {

                $a = $m->request($header, $body);
                $header = $a[0];
                $body = $a[1];

            });

            \Waddle\Util\Event::add("middleware.after", function (\Waddle\Response $resp) use ($m) {

                $resp = $m->response($resp);

            });

            return $this;

        }

        /**
         * On Add...
         *
         * @param \Waddle\Core $core
         * 
         * @return void
         */
        public function onAdd(\Waddle\Core $core) {

            // Nothing now...

        }

    }