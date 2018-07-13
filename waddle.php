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

    namespace Waddle\Instance;

    require_once "vendor/autoload.php";

    use Waddle\{Core, Log};

    Log::info("Waddle Version ". __WADDLE_VERSION__);
    Core::loadConfig(__DIR__ . "/app/configure.json");

    foreach (glob(__DIR__ . "/app/*/init.php") as $v) {
        Log::info("Application Loaded: " . dirname($v));
        require_once($v);
    }

    Core::run();