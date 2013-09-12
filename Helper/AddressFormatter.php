<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Tadcka\AddressBundle\Helper;

use Tadcka\AddressBundle\Entity\Address;

class AddressFormatter
{
    const SHORT = 'address_short';

    const MEDIUM = 'address_medium';

    const LONG = 'address_long';

    /**
     * Formatter
     *
     * @param Address $address
     * @param string $type
     * @return string
     */
    public static function formatter(Address $address, $type = self::MEDIUM)
    {
        $text = '';

        $countryName = $address->getCountryName();
        $text .= !empty($countryName) ? $countryName : '';

        $countryCode = $address->getCountryCode();
        $text .= !empty($countryCode) ? ($text !== '' ? ' ' . $countryCode : $countryCode) : '';

        $regionName = $address->getRegionName();
        $text .= !empty($regionName) ? ($text !== '' ? ', ' . $regionName : $regionName) : '';

        $cityName = $address->getCityName();
        $text .= !empty($cityName) ? ($text !== '' ? ', ' . $cityName : $cityName) : '';

        if ((self::MEDIUM === $type) || (self::LONG === $type)) {
            $streetName = $address->getStreetName();
            $text .= !empty($streetName) ? ($text !== '' ? ', ' . $streetName : $streetName) : '';

            $houseNumber = $address->getHouseNumber();
            $text .= !empty($houseNumber) ? ($text !== '' ? ' ' . $houseNumber : '') : '';

            $flat = $address->getFlat();
            $text .= !empty($flat) ? ($text !== '' ? ($houseNumber !== '-' . $flat ?  : ' ' . $flat) : '' ) : '';
        }

        if (self::LONG === $type) {
            $postCode = $address->getPostCode();
            $text .= !empty($postCode) ? ($text !== '' ? ', ' . $postCode : '') : '';
        }

        return $text;
    }
}
