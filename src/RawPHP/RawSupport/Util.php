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
 * @package   RawPHP\RawSupport
 * @author    Tom Kaczohca <tom@crazydev.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://crazydev.org/licenses/mpl.txt MPL
 * @link      http://crazydev.org/
 */

namespace RawPHP\RawSupport;

use Closure;

/**
 * Class Util
 *
 * @package RawPHP\RawSupport
 */
class Util
{
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function value( $value )
    {
        return $value instanceof Closure ? $value() : $value;
    }

    /**
     * Get an item from an array or object using 'dot' notation.
     *
     * @param mixed  $target
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function dataGet( $target, $key, $default = NULL )
    {
        if ( is_null( $key ) ) return $target;

        foreach ( explode( '.', $key ) as $segment )
        {
            if ( is_array( $target ) )
            {
                if ( !array_key_exists( $segment, $target ) )
                {
                    return static::value( $default );
                }

                $target = $target[ $segment ];
            }
            elseif ( is_object( $target ) )
            {
                if ( !isset( $target->{$segment} ) )
                {
                    return static::value( $default );
                }

                $target = $target->{$segment};
            }
            else
            {
                return static::value( $default );
            }
        }

        return $target;
    }

    /**
     * Get the class 'basename' of the given object / class.
     *
     * @param mixed $class
     *
     * @return string
     */
    public static function classBasename( $class )
    {
        $class = is_object( $class ) ? get_class( $class ) : $class;

        return basename( str_replace( '\\', '/', $class ) );
    }

    /**
     * Get the first element of an array. Useful for method chaining.
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function head( $array )
    {
        return reset( $array );
    }

    /**
     * Get the last element from an array.
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function last( $array )
    {
        return end( $array );
    }

    /**
     * Checks whether the value index position is valid.
     *
     * Returns FALSE if an object or resource is passed in.
     *
     * @param int   $index the array position to check
     * @param mixed $value array or string
     *
     * @return bool TRUE if valid index, else FALSE
     */
    public static function validIndex( $index, $value )
    {
        if ( is_array( $value ) )
        {
            return ( count( $value ) > $index && $index >= 0 );
        }
        elseif ( is_string( $value ) )
        {
            return ( strlen( $value ) > $index && $index >= 0 );
        }

        return FALSE;
    }
}