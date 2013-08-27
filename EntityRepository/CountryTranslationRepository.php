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

use Doctrine\ORM\EntityRepository;

class CountryTranslationRepository extends EntityRepository
{
    /**
     * Get countries to drop down
     *
     * @param string $locale
     * @return array
     */
    public function getCountriesToDropDown($locale = 'en')
    {
        $result = $this->getCountryNameByLocale($locale);

        if (count($result) === 0) {
            $result = $this->getCountryNameByLocale('en');
        }

        $data = array();
        foreach ($result as $row) {
            $data[$row['id']] = $row['name'];
        }

        return $data;
    }

    /**
     * Get country name by locale
     *
     * @param string $locale
     * @return array
     */
    private function getCountryNameByLocale($locale)
    {
        $query = $this->createQueryBuilder('ct');
        $query->innerJoin('ct.entity', 'c');
        $query->andWhere('ct.lang = :locale')
                ->setParameter('locale', $locale);
        $query->select('c.id, ct.name');

        try {
            return $query->getQuery()->getResult();
        } catch (NoResultException $e) {
            return array();
        } catch (\Exception $e) {
            return array();
        }
    }
}