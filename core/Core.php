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

    class Core {

        /**
         * Applications
         *
         * @var \Waddle\Application[]
         */
        protected $applications = [];

        /**
         * The Single Instance
         *
         * @var self
         */
        protected static $instance = null;

        /**
         * Which handler to use
         * 
         * @var string
         */
        protected $handler = "\\Waddle\\Server\\GraphQLHandler";

        /**
         * Configure
         * 
         * @var array
         */
        protected $config = [
            "listen" => [
                "http" => [
                    "address" => "127.0.0.1",
                    "port" => 21301,
                ]
            ]
        ];

        /**
         * Protected Constructor
         * 
         * For Single-Instance
         */
        protected function __construct(){

        }

        /**
         * Get Instance
         *
         * @return self
         */
        public static function getInstance() : \Waddle\Core {

            if (!self::$instance){
                self::$instance = new self;
            }
            return self::$instance;

        }

        /**
         * Magic Function: Call Static
         *
         * @param string $name
         * @param array $args
         * 
         * @return mixed
         */
        public static function __callStatic($name, $args) {

            return call_user_func_array([self::getInstance(), $name], $args);

        }

        /**
         * Magic Function: Call
         *
         * @param string $name
         * @param array $args
         * 
         * @return mixed
         */
        public function __call($name, $args) {

            return call_user_func_array([$this, $name], $args);

        }

        /**
         * Add an application
         *
         * @param \Waddle\Application $app
         * 
         * @return self
         */
        protected function addApplication(\Waddle\Application $app) : \Waddle\Core {

            // Execute the application's onAdd method.
            $app->onAdd($this);

            $this->applications[] = $app;

            return $this;

        }

        /**
         * Set the Handler
         *
         * @param string $handlerName
         * 
         * @return self
         */
        protected function setHandler(string $handlerName) : \Waddle\Core {

            if (!class_exists($handlerName)){
                throw new \Exception("Undefined Handler: ". $handlerName);
            }else{
                $this->handler = $handlerName;
                return $this;
            }

        }

        /**
         * Run the applications
         *
         * @return void
         */
        protected function run() {

            foreach($this->applications as $app){
                $handler = \Waddle\Util\SharedObject::get($this->handler);

                $handler->handle($app);
            }

            \Waddle\Log::info("Started running......");

            $handler->start();

        }

        /**
         * Load the configure
         *
         * @param string $fileName
         * 
         * @return self
         */
        protected function loadConfig(string $fileName) : \Waddle\Core {

            $this->config = array_merge($this->config, json_decode(file_get_contents($fileName), 1));

            return $this;

        }

        /**
         * Get the configure
         *
         * @param string $key
         * 
         * @return mixed
         */
        protected function getConfig(string $key) {

            $e = explode(".", $key);
            $r = $this->config;
            foreach ($e as $v){
                $r = $r[$v];
            }

            return $r;

        }

    }