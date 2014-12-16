<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 *
 * Copyright (c) 2014 RawPHP.org
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * PHP version 5.3
 *
 * @category  PHP
 * @package   RawPHP\RawSupport\Event
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSupport\Event;

use DateTime;
use RawPHP\RawSupport\Event\Contract\IEvent;

/**
 * Class Event
 *
 * @package RawPHP\RawSupport\Event
 */
class BaseEvent implements IEvent
{
    /** @var DateTime */
    protected $dateTime;
    /** @var boolean */
    protected $isCancelled = FALSE;
    /** @var array */
    protected $errors = [ ];
    /** @var bool */
    protected $status = FALSE;

    /**
     * Create a new event.
     */
    public function __construct()
    {
        $this->dateTime = new DateTime();
    }

    /**
     * Get event status.
     *
     * @return boolean
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Set event status.
     *
     * @param boolean $status
     */
    public function setStatus( $status )
    {
        $this->status = $status;
    }

    /**
     * Get the event date.
     *
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Get event errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set event errors.
     *
     * @param array $errors
     */
    public function setErrors( array $errors )
    {
        $this->errors = $errors;
    }

    /**
     * Add an error to the event.
     *
     * @param mixed $error
     */
    public function addError( $error )
    {
        $this->errors[ ] = $error;
    }

    /**
     * Determine if the event has been cancelled.
     *
     * @return boolean
     */
    public function isCancelled()
    {
        return $this->isCancelled;
    }

    /**
     * Set if event is cancelled.
     *
     * @param boolean $isCancelled
     */
    public function setIsCancelled( $isCancelled )
    {
        $this->isCancelled = $isCancelled;
    }

    /**
     * Converts the event object to string.
     */
    public function __toString()
    {
        $pts = explode( '\\', get_class( $this ) );

        $str = 'Event: ' . array_pop( $pts ) . ' fired';

        return $str;
    }
}
