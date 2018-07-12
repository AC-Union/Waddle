<?php
    /**
     * A Demo Application
     */

    namespace App\Demo;

    class QueryController {

        public function Test($id): array {
            return [
                "rand" => rand(0, $id),
                "id" => $id,
            ];
        }

        public function greetings($firstName, $lastName) {

            return (new class {
                public $Message;
                public function set($a, $b){
                    $this->Message = "Hello, $a $b.";

                    return $this;
                }
            })->set($lastName, $firstName);

        }

        public function TestDynamic() {

            $rslt = new TestModel();

            $rslt->status = "ok";

            return $rslt;

        }

    }