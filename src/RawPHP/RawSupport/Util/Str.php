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
 * @package   RawPHP\RawSupport\Util
 * @author    Tom Kaczocha <tom@crazydev.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://crazydev.org/licenses/mpl.txt MPL
 * @link      http://crazydev.org/
 */

namespace RawPHP\RawSupport\Util;

use Patchwork\Utf8;
use RuntimeException;

/**
 * Class Str
 *
 * @package RawPHP\RawSupport\Util
 */
class Str
{
    /**
     * Transliterate a UTF-8 value to ASCII.
     *
     * @param string $value
     *
     * @return string
     */
    public static function ascii( $value )
    {
        return Utf8::toAscii( $value );
    }

    /**
     * Convert a value to camel case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function camel( $value )
    {
        return lcfirst( static::studly( $value ) );
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    public static function contains( $haystack, $needles )
    {
        foreach ( ( array ) $needles as $needle )
        {
            if ( '' !== $needle && FALSE !== strpos( $haystack, $needle ) )
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param string $value
     * @param int    $limit
     * @param string $end
     *
     * @return string
     */
    public static function limit( $value, $limit = 100, $end = '...' )
    {
        if ( mb_strlen( $value ) <= $limit )
        {
            return $value;
        }

        return rtrim( mb_substr( $value, 0, $limit, 'UTF-8' ) ) . $end;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function lower( $value )
    {
        return mb_strtolower( $value );
    }

    /**
     * Generate a more truly 'random' alpha-numeric string.
     *
     * @param int $length
     *
     * @return string
     */
    public static function random( $length = 16 )
    {
        if ( function_exists( 'openssl_random_pseudo_bytes' ) )
        {
            $bytes = openssl_random_pseudo_bytes( $length * 2 );

            if ( FALSE === $bytes )
            {
                throw new RuntimeException( 'Unable to generate random string.' );
            }

            return substr( str_replace( [ '/', '+', '=' ], '', base64_encode( $bytes ) ), 0, $length );
        }

        return static::quickRandom( $length );
    }

    /**
     * Generate a 'random' alpha-numeric string.
     *
     * @param int $length
     *
     * @return string
     */
    public static function quickRandom( $length = 16 )
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr( str_shuffle( str_repeat( $pool, 5 ) ), 0, $length );
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function upper( $value )
    {
        return mb_strtoupper( $value );
    }

    /**
     * Convert the given string to title case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function title( $value )
    {
        return mb_convert_case( $value, MB_CASE_TITLE, 'UTF-8' );
    }

    /**
     * Generate a URL friendly 'slug' from a given string.
     *
     * @param string $title
     * @param string $separator
     *
     * @return string
     */
    public static function slug( $title, $separator = '-' )
    {
        $title = static::ascii( $title );

        $flip = $separator == '-' ? '_' : '-';

        $title = preg_replace( '![' . preg_quote( $flip ) . ']+!u', $separator, $title );

        $title = preg_replace( '![^' . preg_quote( $separator ) . '\pL\pN\s]+!u', '', mb_strtolower( $title ) );

        $title = preg_replace( '![' . preg_quote( $separator ) . '\s]+!u', $separator, $title );

        return trim( $title, $separator );
    }

    /**
     * Convert a value to studly capse case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function studly( $value )
    {
        $value = ucwords( str_replace( [ '-', '_' ], '', $value ) );

        return str_replace( ' ', '', $value );
    }
}