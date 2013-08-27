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

use Doctrine\ORM\Mapping as ORM;

/**
 * Evispa\UserBundle\Entity\Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity
 */
class Address
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $countryName
     *
     * @ORM\Column(name="country_name", type="string", length=255, nullable=true)
     */
    private $countryName;

    /**
     * @var string $countryCode
     *
     * @ORM\Column(name="country_code", type="string", length=11, nullable=true)
     */
    private $countryCode;

    /**
     * @var string $regionName
     *
     * @ORM\Column(name="region_name", type="string", length=255, nullable=true)
     */
    private $regionName;

    /**
     * @var string $cityName
     *
     * @ORM\Column(name="city_name", type="string", length=255, nullable=true)
     */
    private $cityName;

    /**
     * @var string $streetName
     *
     * @ORM\Column(name="street_name", type="string", length=128, nullable=true)
     */
    private $streetName;

    /**
     * @var string $house
     *
     * @ORM\Column(name="house_number", type="string", length=20, nullable=true)
     */
    private $houseNumber;

    /**
     * @var string $flat
     *
     * @ORM\Column(name="flat", type="string", length=20, nullable=true)
     */
    private $flat;

    /**
     * @var string $post_code
     *
     * @ORM\Column(name="post_code", type="string", length=127, nullable=true)
     */
    private $postCode;

    /**
     * @var string $hash
     *
     * @ORM\Column(name="hash", type="string", length=255, nullable=false)
     */
    private $hash;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $country;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $region;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $city;
    
    /**
     * @var Street
     *
     * @ORM\ManyToOne(targetEntity="Street")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="street_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $street;

    /**
     * @var House
     *
     * @ORM\ManyToOne(targetEntity="House")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="house_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $house;


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
     * Set countryName
     *
     * @param string $countryName
     * @return Address
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    
        return $this;
    }

    /**
     * Get countryName
     *
     * @return string 
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return Address
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    
        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set regionName
     *
     * @param string $regionName
     * @return Address
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;
    
        return $this;
    }

    /**
     * Get regionName
     *
     * @return string 
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     * @return Address
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
    
        return $this;
    }

    /**
     * Get cityName
     *
     * @return string 
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set streetName
     *
     * @param string $streetName
     * @return Address
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    
        return $this;
    }

    /**
     * Get streetName
     *
     * @return string 
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * Set house number
     *
     * @param string $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    
        return $this;
    }

    /**
     * Get house number
     *
     * @return string 
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set flat
     *
     * @param string $flat
     * @return Address
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
    
        return $this;
    }

    /**
     * Get flat
     *
     * @return string 
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     * @return Address
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    
        return $this;
    }

    /**
     * Get postCode
     *
     * @return string 
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set country
     *
     * @param \Tadcka\AddressBundle\Entity\Country $country
     * @return Address
     */
    public function setCountry(\Tadcka\AddressBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Tadcka\AddressBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param \Tadcka\AddressBundle\Entity\Region $region
     * @return Address
     */
    public function setRegion(\Tadcka\AddressBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \Tadcka\AddressBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param \Tadcka\AddressBundle\Entity\City $city
     * @return Address
     */
    public function setCity(\Tadcka\AddressBundle\Entity\City $city = null)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return \Tadcka\AddressBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param \Tadcka\AddressBundle\Entity\Street $street
     * @return Address
     */
    public function setStreet(\Tadcka\AddressBundle\Entity\Street $street = null)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return \Tadcka\AddressBundle\Entity\Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set House
     *
     * @param \Tadcka\AddressBundle\Entity\House $house
     * @return Address
     */
    public function setHouse(\Tadcka\AddressBundle\Entity\House $house = null)
    {
        $this->house = $house;
    
        return $this;
    }

    /**
     * Get house
     *
     * @return \Tadcka\AddressBundle\Entity\House
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Set hash
     *
     * @param $hash
     * @return Address
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }
}
