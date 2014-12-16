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
 * @package   RawPHP\RawSupport
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSupport\Entity;

use PHPUnit_Framework_TestCase;

/**
 * Class CursorTests
 *
 * @package RawPHP\RawSupport\Entity
 */
class CursorTests extends PHPUnit_Framework_TestCase
{
    /** @var  Cursor */
    protected $cursor;

    /**
     * Test create cursor.
     */
    public function testCreateCursor()
    {
        $currentPage  = 1;
        $pageSize     = 10;
        $totalRecords = 100;

        $this->cursor = new Cursor( $currentPage, $pageSize, $totalRecords );

        $this->assertEquals( $currentPage, $this->cursor->getCurrentPage() );
        $this->assertEquals( $pageSize, $this->cursor->getPageSize() );
        $this->assertEquals( $totalRecords, $this->cursor->getTotalRecords() );
        $this->assertEquals( 10, $this->cursor->getTotalPages() );
    }
}
