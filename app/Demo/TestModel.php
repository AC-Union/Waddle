<?php

    namespace App\Demo;

    class TestModel {

        public $status = "0";
        
        public function result() {
            
            return [
                "rand" => rand(1, 10)
            ];

        }

    }