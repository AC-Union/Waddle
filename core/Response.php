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

    namespace Waddle;

    class Response {

        /**
         * The headers
         *
         * @var array
         */
        protected $header = [];

        /**
         * The response data
         *
         * @var string
         */
        protected $data = "";

        /**
         * Status code (if avaliable)
         *
         * @var integer
         */
        protected $status = 200;

        /**
         * Constructor
         *
         * @param integer $status
         */
        public function __construct(int $status) {
            $this->status = $status;
        }

        /**
         * Add headers
         *
         * @param string $key
         * @param string $value
         * 
         * @return \Waddle\Response
         */
        public function header(string $key, string $value) : \Waddle\Response {

            $this->header[$key] = $value;

            return $this;

        }

        /**
         * Write data
         *
         * @param string $data
         * 
         * @return \Waddle\Response
         */
        public function write(string $data) : \Waddle\Response {

            $this->data .= $data;

            return $this;

        }

        /**
         * Export the headers
         *
         * @return array
         */
        public function exportHeader() {

            return $this->header;

        }

        /**
         * Export the data
         *
         * @return string
         */
        public function exportData() : string {
            
            return $this->data;

        }

        /**
         * Export the status
         *
         * @return integer
         */
        public function exportStatus() : int {

            return $this->status;

        }

    }