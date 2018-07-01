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

    class RpcClient {

        /**
         * Server address
         *
         * @var string
         */
        protected $address = "";

        /**
         * Constructor
         *
         * @param string $name
         */
        public function __construct(string $name) {

            if(substr($name, 0, 5) != "auto:") {
                $this->address = $name;
                return;
            }

            $name = substr($name, 5, 0);
            $addrs = \Waddle\Core::getConfig("rpc.servers.$name");
            $this->address = $addrs[rand(0, count($addrs))];

        }

        /**
         * Make a call
         *
         * @param string $method
         * @param mixed $argument
         * @param Callable $callback
         * 
         * @return self
         */
        public function call(string $method, $argument, Callable $callback) : self {

            Yar_Concurrent_Client::call($this->address, $method, $argument, $callback, [
                YAR_OPT_PACKAGER => "json"
            ]);

            return $this;

        }

        /**
         * Run the call
         *
         * @return self
         */
        public function run() : self {
            Yar_Concurrent_Client::loop();
            return $this;
        }

    }