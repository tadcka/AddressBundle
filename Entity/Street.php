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
 * @ORM\Table(name="country_street", indexes={
 *      @ORM\Index(name="name", columns={"name"}),
 * })
 * @ORM\Entity(repositoryClass="Tadcka\AddressBundle\EntityRepository\StreetRepository")
 */
class Street
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
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $city;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer $publish
     *
     * @ORM\Column(name="publish", type="smallint", nullable=false)
     */
    private $publish = true;

    /**
     * @var House $houses
     *
     * @ORM\OneToMany(targetEntity="House", mappedBy="street")
     */
    private $houses;

    public function __construct()
    {
        $this->houses = new ArrayCollection();
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
     * Get city
     *
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param City $city
     * @return Street
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param String $name
     * @return Street
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get publish
     *
     * @return bool
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Set publish
     *
     * @param bool $publish
     * @return Street
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get houses
     *
     * @return ArrayCollection
     */
    public function getHouses()
    {
        return $this->houses;
    }

    /**
     * Set houses
     *
     * @param ArrayCollection $houses
     * @return Street
     */
    public function setHouses($houses)
    {
        $this->houses = $houses;

        return $this;
    }
}
