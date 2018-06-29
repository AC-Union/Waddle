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
         * Add an event listenser
         *
         * @param string $name
         * @param callable $callback
         * 
         * @return self
         */
        public function add(string $name, callable $callback) : \Waddle\Util\Event {

            if(!isset($this->events[$name])){
                $this->events[$name] = [];
            }
            $this->events[$name][] = $callback;

            return $this;

        }

        /**
         * Delete an event
         *
         * @param string $name
         * 
         * @return self
         */
        public function delete(string $name) : \Waddle\Util\Event {

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
        public function emit(string $name, ...$args) : \Waddle\Util\Event {

            if(isset($this->events[$name])){
                foreach ($this->events[$name] as $v) {
                    call_user_func_args($v, $args);
                }
            }else{
                throw new \Waddle\Exception\NotFoundException("Undefined Event: " . $name);
            }

        }

    }