<?php
    /**
     * Demo Application
     */

    namespace App\Demo;
    
    $app = new \Waddle\Application\GraphQL("Demo");

    $app->loadType("Query", QueryController::class);

    \Waddle\Core::addApplication($app);