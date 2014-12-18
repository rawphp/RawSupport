<?php

/**
 * This file is part of Step in Deals application.
 *
 * Copyright (c) 2014 Tom Kaczocha
 *
 * This Source Code is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, you can obtain one at http://mozilla.org/MPL/2.0/.
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   RawPHP\RawSupport\Collection
 * @author    Tom Kaczohca <tom@crazydev.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://crazydev.org/licenses/mpl.txt MPL
 * @link      http://crazydev.org/
 */

namespace RawPHP\RawSupport\Collection;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use RawPHP\RawSupport\Util;
use Traversable;

/**
 * Class Collection
 *
 * @package RawPHP\RawSupport\Collection
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /** @var  array */
    protected $items = [ ];

    /**
     * Create new collection.
     *
     * @param array $items
     */
    public function __construct( array $items = [ ] )
    {
        $this->items = $items;
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Collapse the collection items into a single array.
     *
     * @return static
     */
    public function collapse()
    {
        $result = [ ];

        foreach ( $this->items as $values )
        {
            if ( $values instanceof Collection )
            {
                $values = $values->all();
            }

            $result = array_merge( $result, $values );
        }

        return new static( $result );
    }

    /**
     * Determine if an item exists in the collection.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function contains( $value )
    {
        if ( $value instanceof Closure )
        {
            return !is_null( $this->first( $value ) );
        }

        return in_array( $value, $this->items );
    }

    /**
     * @param $items
     *
     * @return static
     */
    public function diff( $items )
    {
        return new static( array_diff( $this->items, $this->getArrayableItems( $items ) ) );
    }

    /**
     * Execute a callback over each item.
     *
     * @param Closure $callback
     *
     * @return Collection
     */
    public function each( Closure $callback )
    {
        array_map( $callback, $this->items );

        return $this;
    }

    /**
     * Get the first item from the collection.
     *
     * @param Closure $callback
     * @param mixed   $default
     *
     * @return array|mixed|null
     */
    public function first( Closure $callback = NULL, $default = NULL )
    {
        if ( is_null( $callback ) )
        {
            return count( $this->items ) > 0 ? reset( $this->items ) : NULL;
        }

        return array_filter( $this->items, $callback, $default );
    }

    /**
     * Flip the items in the collection.
     *
     * @return static
     */
    public function flip()
    {
        return new static( array_flip( $this->items ) );
    }

    /**
     * Remove an item from the collection by key.
     *
     * @param mixed $key
     */
    public function forget( $key )
    {
        unset( $this->items[ $key ] );
    }

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get( $key, $default = NULL )
    {
        if ( $this->offsetExists( $key ) )
        {
            return $this->items[ $key ];
        }

        return Util::value( $default );
    }

    /**
     * Group an associative array by a field or Closure value.
     *
     * @param Closure|string $group
     *
     * @return static
     */
    public function groupBy( $group )
    {
        $result = [ ];

        foreach ( $this->items as $key => $value )
        {
            $result[ $this->getGroupByKey( $group, $key, $value ) ][ ] = $value;
        }

        return new static( $result );
    }

    /**
     * Get the 'group by' key value.
     *
     * @param Closure|string $group
     * @param string         $key
     * @param mixed          $value
     *
     * @return string
     */
    protected function getGroupByKey( $group, $key, $value )
    {
        if ( !is_string( $group ) && is_callable( $group ) )
        {
            return $group( $value, $key );
        }

        return Util::dataGet( $value, $group );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *       <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator( $this->items );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists( $offset )
    {
        return isset( $this->items[ $offset ] );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet( $offset )
    {
        return $this->items[ $offset ];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     */
    public function offsetSet( $offset, $value )
    {
        $this->items[ $offset ] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     */
    public function offsetUnset( $offset )
    {
        unset( $this->items[ $offset ] );
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *       </p>
     *       <p>
     *       The return value is cast to an integer.
     */
    public function count()
    {
        return count( $this->items );
    }

    /**
     * Get the array representation of an object
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *       which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return json_encode( $this->items );
    }
}
