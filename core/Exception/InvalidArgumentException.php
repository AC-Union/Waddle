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

    namespace Waddle\Exception;

    class InvalidArgumentException extends \Exception {

        use \Waddle\Exception\ExceptionTrait;

        /**
         * Exception Type
         *
         * @var string
         */
        protected $exceptionType = "InvalidArgumentException";

    }