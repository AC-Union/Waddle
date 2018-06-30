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

    namespace Waddle\Server;

    use \Swoole\Http\Server;
    use \Waddle\Core;

    class HttpServer implements \Waddle\Server\ServerInterface {

        /**
         * The swoole http server.
         */
        protected $server;

        /**
         * Current handler
         *
         * @var Callable
         */
        protected $handler;

        /**
         * Constructor
         */
        public function __construct() {

            $this->server = new Server(
                Core::getConfig("listen.http.address"),
                Core::getConfig("listen.http.port")
            );
            
            $this->server->on('request', [$this, "handleRequest"]);

        }

        /**
         * Start the server
         *
         * @return void
         */
        public function start() {

            $this->server->start();

        }

        /**
         * Handle the request
         *
         * @param \Swoole\Http\Request $request
         * @param \Swoole\Http\Response $response
         * 
         * @return void
         */
        public function handleRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response) {

            $h = $this->handler;
            $header = $request->header;
            $header["variables"] = $request->get;
            $resp = $h($header, $request->rawContent());

            $response->status($resp->exportStatus());

            foreach($resp->exportHeader() as $k=>$v) {

                $response->header($k, $v);

            }

            $response->end($resp->exportData());

        }

        /**
         * Set the Handler
         *
         * @param Callable $handler
         * 
         * @return void
         */
        public function setHandler(Callable $handler) {

            $this->handler = $handler;

        }

        /**
         * Get the server
         *
         * @return \Swoole\Http\Server
         */
        public function getServer() {

            return $this->server;

        }

    }