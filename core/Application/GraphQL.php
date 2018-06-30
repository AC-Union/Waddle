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
         * @var \GraphQL\Type\Schema
         */
        protected $schema;

        /**
         * The raw code of scheme
         *
         * @var string
         */
        protected $schemaCode = "";
        
        /**
         * Controllers
         * 
         * @var array
         */
        protected $controllers = [];

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
         * @param string $controller
         * 
         * @return \Waddle\Application\GraphQL
         */
        public function loadType(string $name, string $controller) : \Waddle\Application\GraphQL {

            $path = SysDir. "app/{$this->name}/types/{$name}.graphql";

            $this->schemaCode .= file_get_contents($path);

            $this->controllers[$name] = $controller;

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

            foreach($names as $k=>$v) {

                $this->loadType($k, $v);

            }

            return $this;

        }

        /**
         * On Add...
         *
         * @override
         * @param \Waddle\Core $core
         * 
         * @return void
         */
        public function onAdd(\Waddle\Core $core) {

            $this->schema = \GraphQL\Utils\BuildSchema::build($this->schemaCode);

        }

        /**
         * Get the Schema
         *
         * @return \GraphQL\Type\Schema
         */
        public function getSchema() : \GraphQL\Type\Schema {
            return $this->schema;
        }

        /**
         * Get the name
         *
         * @return string
         */
        public function getName() : string {
            return $this->name;
        }

        /**
         * Get Field Resolver
         *
         * @return Callable
         */
        public function getFieldResolver() {

            $s = $this->controllers;

            return function($source, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) use ($s) {

                // Source is an array of controllers.

                $fieldName = $info->fieldName;
                $parentType = $info->parentType;

                $typeName = $parentType->name;

                $controller = $s[$typeName];

                if (isset($controller->{$fieldName})){
                    return $controller->{$fieldName};
                }

                return call_user_func_array([$controller, $fieldName], $args);

            };

        }

    }