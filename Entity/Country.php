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

namespace Tadcka\AddressBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Countries
 *
 * @ORM\Table(name="countries", indexes={
 *      @ORM\Index(name="iso", columns={"iso"}),
 * })
 * @ORM\Entity(repositoryClass="Tadcka\AddressBundle\EntityRepository\CountryRepository")
 */
class Country
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="iso", type="string", length=2, nullable=false)
     */
    private $iso;

    /**
     * @var string
     *
     * @ORM\Column(name="iso3", type="string", length=3, nullable=false)
     */
    private $iso3;

    /**
     * @var Continent
     *
     * @ORM\ManyToOne(targetEntity="Continent", inversedBy="countries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="continent_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $continent;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_code", type="string", length=10, nullable=true)
     */
    private $phoneCode;

    /**
     * @var CountryTranslation[] $translations
     *
     * @ORM\OneToMany(targetEntity="CountryTranslation", mappedBy="entity", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set iso
     *
     * @param string $iso
     * @return Countries
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    
        return $this;
    }

    /**
     * Get iso
     *
     * @return string 
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * Set iso3
     *
     * @param string $iso3
     * @return Countries
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;
    
        return $this;
    }

    /**
     * Get iso3
     *
     * @return string 
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * Set phoneCode
     *
     * @param string $phoneCode
     * @return Countries
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phoneCode = $phoneCode;
    
        return $this;
    }

    /**
     * Get phoneCode
     *
     * @return string 
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * Set continent
     *
     * @param \Tadcka\AddressBundle\Entity\Continent $continent
     * @return Countries
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * Get continent
     *
     * @return \Tadcka\AddressBundle\Entity\Continent
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * Add translations
     *
     * @param \Tadcka\AddressBundle\Entity\CountryTranslation $translations
     * @return Country
     */
    public function addTranslation(\Tadcka\AddressBundle\Entity\CountryTranslation $translations)
    {
        $this->translations[] = $translations;
    
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Tadcka\AddressBundle\Entity\CountryTranslation $translations
     */
    public function removeTranslation(\Tadcka\AddressBundle\Entity\CountryTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Get translation | default locale en
     *
     * @param string $locale
     * @return CountryTranslation|null
     */
    public function getTranslation($locale = 'en')
    {
        $defaultLocale = 'en';
        $trans = null;

        foreach ($this->getTranslations() as $translation) {
            if ($translation->getLang() === $locale) {
                $trans = $translation;
                break;
            }
        }

        if ($trans === null) {
            foreach ($this->getTranslations() as $translation) {
                if ($translation->getLang() === $defaultLocale) {
                    $trans = $translation;
                    break;
                }
            }
        }

        return $trans;
    }
}
