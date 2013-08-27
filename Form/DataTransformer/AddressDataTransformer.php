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


use Tadcka\AddressBundle\Entity\Address;
use Tadcka\AddressBundle\Entity\CountryTranslation;
use Tadcka\AddressBundle\Helper\AddressHash;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\DataTransformerInterface;

class AddressDataTransformer implements DataTransformerInterface
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var bool
     */
    private $useHash = true;

    public function __construct($doctrine, $locale, $useHash)
    {
        $this->doctrine = $doctrine;
        $this->locale = $locale;
        $this->useHash = $useHash;
    }

    /**
     * Transform
     *
     * @param \Tadcka\AddressBundle\Entity\Address $value
     * @return \Tadcka\AddressBundle\Entity\Address|null
     */
    public function transform($value)
    {
        if (null === $value) {
            return;
        }

        return $value;
    }

    /**
     * Reverse transform
     *
     * @param \Tadcka\AddressBundle\Entity\Address $value
     * @return \Tadcka\AddressBundle\Entity\Address
     */
    public function reverseTransform($value)
    {
        if (($value !== null) && ($value instanceof Address)) {
            if ($value->getCountry() !== null) {
                $value->setCountryCode($value->getCountry()->getIso());
                $countryTranslation = $value->getCountry()->getTranslation($this->locale);
                if (($countryTranslation !== null) && ($countryTranslation instanceof CountryTranslation)) {
                    $value->setCountryName($countryTranslation->getName());
                }
            }

            $hash = AddressHash::generate($value);

            if ($this->useHash && ($value->getHash() !== $hash)) {
                $om = $this->doctrine->getManager();
                if ($om->contains($value)) {
                    $om->detach($value);
                }

                $address = $om->getRepository('TadckaAddressBundle:Address')->findOneBy(array('hash' => $hash));

                if($address !== null) {
                    return $address;
                }

                $value->setHash($hash);
            }

            return $value;
        }
    }
}