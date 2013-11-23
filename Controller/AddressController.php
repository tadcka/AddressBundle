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

namespace Tadcka\AddressBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends ContainerAware
{
    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    /**
     * @return int|null
     */
    private function getLimit()
    {
        if ($this->container->hasParameter('tadcka_address')) {
            $parameter = $this->container->getParameter('tadcka_address');
            if (isset($parameter['limit'])) {
                return $parameter['limit'];
            }
        }

        return null;
    }


    public function regionsAction(Request $request, $id = 0)
    {
        $data = array();
        if ($request->getMethod() === "GET") {
            $text = $request->get('text', '');
            if ($id !== 0) {
                $country = $this->getDoctrine()->getRepository('TadckaAddressBundle:Country')->find($id);

                if ($country !== null) {
                    $data = $this->getDoctrine()->getRepository('TadckaAddressBundle:Region')
                        ->getRegionsByCountryToDropDown($country, $text, $this->getLimit());
                }
            }
        }

        return new JsonResponse($data);
    }

    public function citiesAction(Request $request, $id = 0)
    {
        $data = array();

        if ($request->getMethod() === "GET") {
            $text = $request->get('text', '');

            if ($id !== 0) {
                $region = $this->getDoctrine()->getRepository('TadckaAddressBundle:Region')->find($id);
                if ($region !== null) {
                    $data = $this->getDoctrine()->getRepository('TadckaAddressBundle:City')
                        ->getCitiesByRegionToDropDown($region, $text, $this->getLimit());
                }
            }
        }

        return new JsonResponse($data);
    }

    public function streetsAction(Request $request, $id = 0)
    {
        $data = array();

        if ($request->getMethod() === "GET") {
            $text = $request->get('text', '');
            if ($id !== 0) {
                $city = $this->getDoctrine()->getRepository('TadckaAddressBundle:City')->find($id);

                if ($city !== null) {
                    $data = $this->getDoctrine()->getRepository('TadckaAddressBundle:Street')
                        ->getStreetsByCityToDropDown($city, $text, $this->getLimit());
                }
            }
        }

        return new JsonResponse($data);
    }


    public function postCodeAction(Request $request, $id = 0)
    {
        $data = array('post_code' => '', 'house' => null);
        if ($request->getMethod() === "GET" && ($id !== 0)) {
            $houseNumber = $request->get('house', '');
            if (trim($houseNumber) !== '') {
                $house = $this->getDoctrine()->getRepository('TadckaAddressBundle:House')
                    ->findOneBy(array('street' => $id, 'houseNumber' => $houseNumber));

                if ($house !== null) {
                    $data['post_code'] = $house->getPostCode();
                    $data['house'] = $house->getId();
                }
            }
        }

        return new JsonResponse($data);
    }
}
