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

    class GraphQLHandler implements \Waddle\Server\HandlerInterface {

        /**
         * Servers
         *
         * @var array
         */
        protected $servers = [];

        /**
         * Handle an Application
         *
         * @param \Waddle\Application $app
         * @return void
         */
        public function handle(\Waddle\Application $app) {

            $server = \Waddle\Util\SharedObject::get($app->serverType);
            $v = $this;
            $server->setHandler(
                function($header, string $body) use ($v, $app) {
                    call_user_func( [$v, "handleRequest"], $header, $body, $app );
                });
            $this->servers[] = $server;

        }

        /**
         * Handle a request
         *
         * @param array $header
         * @param string $body
         * @param \Waddle\Application $app
         * 
         * @return \Waddle\Response
         */
        public function handleRequest($header, string $body, \Waddle\Application $app) : \Waddle\Response {

            \Waddle\Util\Event::emit("middleware.before", $body);

            // WIP
            \GraphQL\GraphQL::executeQuery();

            return (new \Waddle\Response(200))
                ->header("content-type", "application/json")
                ->write($body);

        }

        /**
         * Start server
         *
         * @return void
         */
        public function start(){

            foreach($this->servers as $server){
                $server->getServer()->set(
                    ["http_parse_post" => false]
                );
                $server->start();
            }

        }

    }