<?php
    /**
     * A Demo Application
     */

    namespace App\Demo;

    class QueryController {

        public function greetings($firstName, $lastName) : string {

            return "Hello, $firstName $lastName!";

        }

    }