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
 *
 * @ORM\Table(name="country_houses", indexes={
 * @ORM\Index(name="street_house_number", columns={"street_id", "house_number"}),
 * @ORM\Index(name="post_code", columns={"post_code"}),
 * })
 * @ORM\Entity
 */
class House
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
     * @var Street $street
     *
     * @ORM\ManyToOne(targetEntity="Street", inversedBy="houses")
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     *
     */
    private $street;

    /**
     * @var string $houseNumber
     *
     * @ORM\Column(name="house_number", type="string", length=255, nullable=true)
     */
    private $houseNumber;

    /**
     * @var string $postCode
     *
     * @ORM\Column(name="post_code", type="string", length=255, nullable=true)
     */
    private $postCode;

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
     * Get street
     *
     * @return Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @param Street $street
     * @return House
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     * @return House
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

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
     * Set postCode
     * 
     * @param string $postCode
     * @return House
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }
}
