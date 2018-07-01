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

    class Watcher {

        /**
         * Inotify Instance
         *
         * @var Resource
         */
        protected $inotify;

        /**
         * Watchers
         *
         * @var array
         */
        protected $watchers = [];

        /**
         * Constructor
         */
        public function __construct() {

            $this->inotify = inotify_init();

        }

        /**
         * Destructor
         */
        public function __destruct() {

            foreach($this->watchers as $v) {
                inotify_rm_watch($this->inotify, $v);
            }

            fclose($this->inotify);

        }
        
        /**
         * Add a directory
         *
         * @param string $dir
         * 
         * @return self
         */
        public function addDirectory(string $dir) : self {

            $d = opendir($dir);

            while($f = readdir($d)){
                if($f == "." || $f == ".."){
                    continue;
                }
                if (is_dir($f)){
                    $this->addDirectory($f);
                    continue;
                }
                $this->watchers[] = inotify_add_watch($this->inotify, $dir . "/" . $f, IN_MODIFY | IN_DELETE | IN_CREATE | IN_MOVE);
            }

            closedir($d);

            return $this;

        }

        /**
         * Run the loop
         *
         * @param Callable $callback
         * @return void
         */
        public function run(Callable $callback) {

            swoole_event_add($this->inotify, function ($ifd) use ($callback) {
                $events = inotify_read($this->inotify);
                if (!$events) return;
                foreach($events as $event) {
                    if($event["mask"] != IN_IGNORED) {
                        $callback($event);
                        break;
                    }
                }
            });

        }

    }