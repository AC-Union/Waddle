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

    trait ExceptionTrait {

        /**
         * Get Exception Type
         *
         * @return string
         */
        public function getExceptionType() : string {

            return $this->exceptionType;

        }

    }