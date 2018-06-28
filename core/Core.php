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
        protected $handler = "\\Waddle\\Server\\Handler";

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
         * @return mixed
         */
        public static function __callStatic($name, $args) {

            return call_user_func_array([self::getInstance(), $name], $args);

        }

        /**
         * Add an application
         *
         * @param \Waddle\Application $app
         * 
         * @return self
         */
        public function addApplication(\Waddle\Application $app) : \Waddle\Application {

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
        public function setHandler(string $handlerName) : \Waddle\Core {

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
        public function run() {

            foreach($this->applications as $app){

            }

        }

    }