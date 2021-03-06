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
            $server->setHandler( $app->getName(),
                function($header, string $body) use ($v, $app) {
                    $variables = $header["variables"] ? $header["variables"] : [];
                    $rslt = [];
                    @parse_str($body, $rslt);
                    if(isset($rslt["query"])){
                        $variables = $rslt["variables"] ?: [];
                        $variables = \json_decode($variables, 1) ?: [];
                        $query = $rslt["query"];
                    }else{
                        $rslt = @json_decode($body, 1);
                        if(isset($rslt["query"])){
                            $variables = $rslt["variables"] ?: [];
                            var_dump($variables);
                            $query = $rslt["query"];
                        }else{
                            $query = $body;
                        }
                    }
                    return call_user_func( [$v, "handleRequest"], $header, $variables, $query, $app );
                }
            );
            $this->servers[] = $server;

        }

        /**
         * Handle a request
         *
         * @param array $header
         * @param array $variables
         * @param string $body
         * @param \Waddle\Application $app
         * 
         * @return \Waddle\Response
         */
        public function handleRequest($header, array $variables, string $body, \Waddle\Application $app) : \Waddle\Response {

            \Waddle\Util\Event::emit("middleware.before", $header, $body);
            
            $result = \GraphQL\GraphQL::executeQuery(
                $app->getSchema(),
                $body,
                null,
                null,
                $variables,
                null,
                $app->getFieldResolver()
            );

            $args = null;

            if (\Waddle\Core::getConfig("debug")) {
                $args = \GraphQL\Error\Debug::INCLUDE_DEBUG_MESSAGE | 
                        \GraphQL\Error\Debug::INCLUDE_TRACE | 
                        \GraphQL\Error\Debug::RETHROW_INTERNAL_EXCEPTIONS;
            }

            try {
                $resp = (new \Waddle\Response(200))
                    ->header("content-type", "application/json")
                    ->write(json_encode($result->toArray($args)));
            } catch(\Exception $e) {
                \Waddle\Log::error($e->getMessage());
                if (\Waddle\Core::getConfig("debug"))
                    throw $e;
            }
            \Waddle\Util\Event::emit("middleware.after", $resp);

            return $resp;

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