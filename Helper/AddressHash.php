<?php
/**
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

class AddressHash
{
    /**
     * Generate address hash
     *
     * @param Address $address
     * @return string
     */
    public static function generate(Address $address)
    {
        $hash = '';

        $hash .= $address->getCountryName();
        $hash .= $address->getCountryCode();
        $hash .= $address->getRegionName();
        $hash .= $address->getCityName();
        $hash .= $address->getStreetName();
        $hash .= $address->getHouseNumber();
        $hash .= $address->getFlat();
        $hash .= $address->getPostCode();

        $hash .= $address->getCountry() !== null ? $address->getCountry()->getId() : '';
        $hash .= $address->getRegion() !== null ? $address->getRegion()->getId() : '';
        $hash .= $address->getCity() !== null ? $address->getCity()->getId() : '';
        $hash .= $address->getStreet() !== null ? $address->getStreet()->getId() : '';
        $hash .= $address->getHouse() !== null ? $address->getHouse()->getId() : '';

        $hash = sha1($hash);

        return $hash;
    }
}
