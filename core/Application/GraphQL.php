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

    namespace Waddle\Application;

    class GraphQL extends \Waddle\Application {

        /**
         * Application name
         *
         * @var string
         */
        protected $name = "";

        /**
         * Scheme
         * 
         * @var \GraphQL\Type\Scheme
         */
        protected $scheme;

        /**
         * The raw code of scheme
         *
         * @var string
         */
        protected $schemeCode = "";

        /**
         * Set application name
         *
         * @param string $name
         */
        public function __construct(string $name) {

            $this->name = $name;

        }

        /**
         * Load a type
         *
         * @param string $name
         * 
         * @return \Waddle\Application\GraphQL
         */
        public function loadType(string $name) : \Waddle\Application\GraphQL {

            $path = SysDir. "app/{$this->name}/types/{$name}.graphql";

            $this->schemeCode .= file_get_contents($path);

            return $this;

        }

        /**
         * Load the types
         *
         * @param array $names
         * 
         * @return \Waddle\Application\GraphQL
         */
        public function loadTypes($names) : \Waddle\Application\GraphQL {

            foreach($names as $v) {

                $this->loadType($v);

            }

            return $this;

        }

    }