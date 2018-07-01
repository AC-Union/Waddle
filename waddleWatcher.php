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

    $watcher = new \Waddle\Util\Watcher;

    $watcher->addDirectory(__DIR__);

    $p = new \Swoole\Process(function($process){
        $process->exec("/usr/bin/php", [ "./waddle.php" ]);
    });

    $p->start();

    $watcher->run(function($event) use($p) {
        $p->kill($p->pid);
        $p->wait();
        $p->start();
    });