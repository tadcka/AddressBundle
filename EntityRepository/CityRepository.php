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

namespace Tadcka\AddressBundle\EntityRepository;

use Tadcka\AddressBundle\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class CityRepository extends EntityRepository
{
    /**
     * Get cities by region to drop down
     *
     * @param Region $region
     * @param string $text
     * @param int|null $limit
     * @return array
     */
    public function getCitiesByRegionToDropDown(Region $region, $text, $limit = null)
    {
        $query = $this->createQueryBuilder('c');

        $query->andWhere('c.region = :region')
                ->setParameter('region', $region)
                ->andWhere('c.publish = :publish')
                ->setParameter('publish', true);

        if (trim($text) !== '') {
            $query->andWhere($query->expr()->like($query->expr()->upper('c.name'), ':text'))
                ->setParameter('text', '%' .strtoupper($text). '%');
        }

        if ($limit !== null) {
            $query->setMaxResults($limit);
        }

        $query->select('c.id, c.name');

        $result = array();

        try {
            $result = $query->getQuery()->getResult();
        } catch (NoResultException $e) {
            return array();
        } catch (\Exception $e) {
            return array();
        }

        $data = array();
        foreach ($result as $row) {
            $data[$row['id']] = $row['name'];
        }

        return $data;
    }
}