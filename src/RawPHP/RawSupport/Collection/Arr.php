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
 * @package   Deals
 * @author    Tom Kaczohca <tom@crazydev.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://crazydev.org/licenses/mpl.txt MPL
 * @link      http://crazydev.org/
 */

namespace RawPHP\RawSupport\Collection;

use Closure;
use RawPHP\RawSupport\Util;

class Arr
{
    /**
     * Add an element to an array using 'dot' notation if it does not exist.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     */
    public static function add( $array, $key, $value )
    {
        if ( is_null( static::get( $array, $key ) ) )
        {
            static::set( $array, $key, $value );
        }

        return $array;
    }

    /**
     * Build a new array using a callback.
     *
     * @param array   $array
     * @param Closure $callback
     *
     * @return array
     */
    public static function build( $array, Closure $callback )
    {
        $result = [ ];

        foreach ( $array as $key => $value )
        {
            list( $innerKey, $innerValue ) = call_user_func( $callback, $key, $value );

            $result[ $innerKey ] = $innerValue;
        }

        return $result;
    }

    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param array $array
     *
     * @return array
     */
    public static function divide( $array )
    {
        return [ array_keys( $array ), array_values( $array ) ];
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array  $array
     * @param string $prepend
     *
     * @return array
     */
    public static function dot( $array, $prepend = '' )
    {
        $result = [ ];

        foreach ( $array as $key => $value )
        {
            if ( is_array( $value ) )
            {
                $result = array_merge( $result, static::dot( $value, $prepend . $key . '.' ) );
            }
            else
            {
                $result[ $prepend . $key ] = $value;
            }
        }

        return $result;
    }

    /**
     * Get all of the given array except for the specified array of items.
     *
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public static function except( $array, $keys )
    {
        return array_diff_key( $array, array_flip( ( array ) $keys ) );
    }

    /**
     * Fetch a flattened array of a nested array element.
     *
     * @param array  $array
     * @param string $key
     *
     * @return array
     */
    public static function fetch( $array, $key )
    {
        $result = [ ];

        foreach ( explode( '.', $key ) as $segment )
        {
            foreach ( $array as $value )
            {
                $value = ( array ) $value;

                $result[ ] = $value[ $segment ];
            }

            $array = array_values( $result );
        }

        return array_values( $result );
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param array   $array
     * @param Closure $callback
     * @param mixed   $default
     *
     * @return mixed
     */
    public static function first( $array, $callback, $default = NULL )
    {
        foreach ( $array as $key => $value )
        {
            if ( call_user_func( $callback, $key, $value ) ) return $value;
        }

        return Util::value( $default );
    }

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param array   $array
     * @param Closure $callback
     * @param mixed   $default
     *
     * @return mixed
     */
    public static function last( $array, $callback, $default = NULL )
    {
        return static::first( array_reverse( $array ), $callback, $default );
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $array
     *
     * @return array
     */
    public static function flatten( $array )
    {
        $return = [ ];

        array_walk_recursive( $array, function ( $x ) use ( &$return ) { $return[ ] = $x; } );

        return $return;
    }

    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param array $array
     * @param array $keys
     */
    public static function forget( &$array, $keys )
    {
        $original =& $array;

        foreach ( ( array) $keys as $key )
        {
            $parts = explode( '.', $key );

            while ( count( $parts ) > 1 )
            {
                $part = array_shift( $parts );

                if ( isset( $array[ $part ] ) && is_array( $array[ $part ] ) )
                {
                    $array =& $array[ $part ];
                }
            }

            unset( $array[ array_shift( $parts ) ] );

            // clean up after each pass
            $array =& $original;
        }
    }

    /**
     * Get an item from an array using 'dot' notation.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function get( $array, $key, $default = NULL )
    {
        if ( is_null( $key ) ) return $array;

        if ( isset( $array[ $key ] ) ) return $array[ $key ];

        foreach ( explode( '.', $key ) as $segment )
        {
            if ( !is_array( $array ) || !array_key_exists( $segment, $array ) )
            {
                return Util::value( $default );
            }

            $array = $array[ $segment ];
        }

        return $array;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param array        $array
     * @param array|string $keys
     *
     * @return array
     */
    public static function only( $array, $keys )
    {
        return array_intersect_key( $array, array_flip( ( array ) $keys ) );
    }

    /**
     * Pluck an array of values from an array.
     *
     * @param array  $array
     * @param string $value
     * @param string $key
     *
     * @return array
     */
    public static function pluck( $array, $value, $key = NULL )
    {
        $result = [ ];

        foreach ( $array as $item )
        {
            $itemValue = is_object( $item ) ? $item->{$value} : $item[ $value ];

            if ( is_null( $key ) )
            {
                $result[ ] = $itemValue;
            }
            else
            {
                $itemKey = is_object( $item ) ? $item->{$key} : $item[ $key ];

                $result[ $itemKey ] = $itemValue;
            }
        }

        return $result;
    }

    /**
     * Get a value from the array and remove it.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function pull( &$array, $key, $default = NULL )
    {
        $value = static::get( $array, $key, $default );

        static::forget( $array, $key );

        return $value;
    }

    /**
     * Set an array item to a given value using 'dot' notation.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     */
    public static function set( &$array, $key, $value )
    {
        if ( is_null( $key ) ) return $array = $value;

        $keys = explode( '.', $key );

        while ( count( $keys ) > 1 )
        {
            $key = array_shift( $keys );

            if ( !isset( $array[ $key ] ) || !is_array( $array[ $key ] ) )
            {
                $array[ $key ] = [ ];
            }

            $array =& $array[ $key ];
        }

        $array[ array_shift( $keys ) ] = $value;

        return $array;
    }
}