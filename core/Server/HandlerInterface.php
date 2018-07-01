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

    namespace Waddle\Server;

    /**
     * Handler Interface
     */
    interface HandlerInterface {

        /**
         * Handle an Application
         *
         * @param \Waddle\Application $app
         * @return void
         */
        public function handle(\Waddle\Application $app);

        /**
         * Start server
         *
         * @return void
         */
        public function start();

    }