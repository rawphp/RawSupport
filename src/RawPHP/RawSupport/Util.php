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
}