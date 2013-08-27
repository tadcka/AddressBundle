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

namespace Tadcka\AddressBundle\Form\DataTransformer;

use Tadcka\AddressBundle\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\DataTransformerInterface;

class CountryChoiceDataTransformer implements DataTransformerInterface
{
    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transform
     *
     * @param Country $country
     * @return mixed|void
     */
    public function transform($country)
    {
        if (($country !== null) && ($country instanceof Country)) {
            return $country->getId();
        }
        return null;
    }

    /**
     * Reverse transform
     *
     * @param integer $id
     * @return Country|null
     */
    public function reverseTransform($id)
    {
        if ($id !== null) {
            return $this->doctrine->getRepository('TadckaAddressBundle:Country')->find($id);
        }

        return null;
    }
}