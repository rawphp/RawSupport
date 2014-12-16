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
 * @package   RawPHP\RawSupport\Entity
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSupport\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\XmlElement;

/**
 * Class Cursor
 *
 * @ExclusionPolicy(value="NONE")
 *
 * @package RawPHP\RawSupport\Entity
 */
class Cursor
{
    /**
     * @XmlElement(cdata=false)
     *
     * @var int
     */
    protected $pageSize = 1;
    /**
     * @XmlElement(cdata=false)
     *
     * @var int
     */
    protected $currentPage = 1;
    /**
     * @XmlElement(cdata=false)
     *
     * @var int
     */
    protected $totalPages = 1;
    /**
     * @XmlElement(cdata=false)
     *
     * @var int
     */
    protected $totalRecords = 1;

    /**
     * Create new cursor.
     *
     * @param int $currentPage
     * @param int $pageSize
     * @param int $totalRecords
     */
    public function __construct( $currentPage, $pageSize, $totalRecords )
    {
        $this->currentPage  = $currentPage;
        $this->pageSize     = $pageSize;
        $this->totalRecords = $totalRecords;
    }

    /**
     * Get total records.
     *
     * @return int
     */
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    /**
     * Set total records.
     *
     * @param int $totalRecords
     *
     * @return Cursor
     */
    public function setTotalRecords( $totalRecords )
    {
        $this->totalRecords = $totalRecords;

        return $this;
    }

    /**
     * Get current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set current page.
     *
     * @param int $currentPage
     *
     * @return Cursor
     */
    public function setCurrentPage( $currentPage )
    {
        $this->currentPage = ( int ) $currentPage;

        return $this;
    }

    /**
     * Get page size.
     *
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Set page size.
     *
     * @param int $pageSize
     *
     * @return Cursor
     */
    public function setPageSize( $pageSize )
    {
        $this->pageSize = ( int ) $pageSize;

        return $this;
    }

    /**
     * Get total pages.
     *
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages = $this->totalRecords / $this->pageSize;
    }

    /**
     * Set total pages.
     *
     * @param int $totalPages
     *
     * @return Cursor
     */
    public function setTotalPages( $totalPages )
    {
        $this->totalPages = ( int ) $totalPages;

        return $this;
    }
}
