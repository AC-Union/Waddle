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

    class Event {

        /**
         * Events
         *
         * @var array
         */
        protected $events = [];

        /**
         * The Single Instance
         *
         * @var self
         */
        protected static $instance = null;

        /**
         * Add an event listenser
         *
         * @param string $name
         * @param callable $callback
         * 
         * @return self
         */
        protected function add(string $name, callable $callback) : \Waddle\Util\Event {

            if(!isset($this->events[$name])){
                $this->events[$name] = [];
            }
            $this->events[$name][] = $callback;

            return $this;

        }

        /**
         * Get Instance
         *
         * @return self
         */
        public static function getInstance() : self {

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
         * Delete an event
         *
         * @param string $name
         * 
         * @return self
         */
        protected function delete(string $name) : \Waddle\Util\Event {

            unset($this->events[$name]);

            return $this;

        }

        /**
         * Emit an event
         *
         * @param string $name
         * @param mixed ...$args
         * 
         * @return self
         */
        protected function emit(string $name, ...$args) : \Waddle\Util\Event {

            if(isset($this->events[$name])){
                foreach ($this->events[$name] as $v) {
                    call_user_func_args($v, $args);
                }
                return $this;
            }else{
                //throw new \Waddle\Exception\NotFoundException("Undefined Event: " . $name);
                return $this;
            }

        }

    }