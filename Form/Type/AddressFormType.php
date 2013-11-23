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

namespace Tadcka\AddressBundle\Form\Type;

use Tadcka\AddressBundle\Form\DataTransformer\AddressDataTransformer;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressFormType extends AbstractType
{
    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'country',
            new CountryChoiceFormType($this->doctrine, $options['_locale']),
            array(
                'attr' => array('class' => 'select_16 address_country select2'),
            )
        );

        $builder->add(
            'region',
            new EntityHiddenFormType($this->doctrine),
            array(
                'attr' => array('class' => 'address_region'),
                'class' => 'Tadcka\AddressBundle\Entity\Region',
            )
        );

        $builder->add(
            'regionName',
            'text',
            array(
                'label' => 'form.address.region',
                'label_attr' => array(
                    'class' => 'label_form'
                ),
                'attr' => array('class' => ' input_16 address_region_name', 'autocomplete' => 'off'),
                'required' => false,
            )
        );

        $builder->add(
            'city',
            new EntityHiddenFormType($this->doctrine),
            array(
                'attr' => array('class' => 'address_city'),
                'class' => 'Tadcka\AddressBundle\Entity\City',
            )
        );

        $builder->add(
            'cityName',
            'text',
            array(
                'label' => 'form.address.city',
                'label_attr' => array(
                    'class' => 'label_form'
                ),
                'attr' => array('class' => 'input_16 address_city_name', 'autocomplete' => 'off'),
                'required' => false,
            )
        );

        $builder->add(
            'street',
            new EntityHiddenFormType($this->doctrine),
            array(
                'attr' => array('class' => 'address_street'),
                'class' => 'Tadcka\AddressBundle\Entity\Street',
            )
        );

        $builder->add(
            'streetName',
            'text',
            array(
                'label' => 'form.address.street',
                'label_attr' => array(
                    'class' => 'label_form'
                ),
                'attr' => array('class' => 'input_16 address_street_name', 'autocomplete' => 'off'),
                'required' => false,
            )
        );

        $builder->add(
            'house',
            new EntityHiddenFormType($this->doctrine),
            array(
                'attr' => array('class' => 'address_house'),
                'class' => 'Tadcka\AddressBundle\Entity\House',
            )
        );

        $builder->add(
            'houseNumber',
            'text',
            array(
                'label' => 'form.address.house',
                'label_attr' => array(
                    'class' => 'label_form'
                ),
                'attr' => array('class' => 'input_16 address_house_number', 'autocomplete' => 'off'),
                'required' => false,
            )
        );

        $builder->add(
            'flat',
            'text',
            array(
                'label' => 'form.address.flat',
                'label_attr' => array(
                    'class' => 'label_form'
                ),
                'attr' => array('class' => 'input_16 address_flat', 'autocomplete' => 'off'),
                'required' => false,
            )
        );

        $builder->add(
            'postCode',
            'text',
            array(
                'label' => 'form.address.post_code',
                'label_attr' => array(
                    'class' => 'label_form'
                ),
                'attr' => array(
                    'class' => 'input_16 address_post_code',
                    'autocomplete' => 'off',
                    'data-url_id' => $options['address_post_code']
                ),
                'required' => false,
            )
        );

        $transformer = new AddressDataTransformer($this->doctrine, $options['_locale'], $options['_use_hash']);
        $builder->addModelTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['autocomplete_regions'] = $options['autocomplete_regions'];
        $view->vars['autocomplete_cities'] = $options['autocomplete_cities'];
        $view->vars['autocomplete_streets'] = $options['autocomplete_streets'];
        $view->vars['class_form'] = $options['_class'];
        $view->vars['id_form'] = $options['id_form'];
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'TadckaAddressBundle',
            'data_class' => 'Tadcka\AddressBundle\Entity\Address',
            'autocomplete_regions' => 'tadcka_address_regions',
            'autocomplete_cities' => 'tadcka_address_cities',
            'autocomplete_streets' => 'tadcka_address_streets',
            'address_post_code' => 'tadcka_address_post_code',
            'label' => false,
            '_locale' => 'en',
            '_class' => 'tadcka_address_form',
            '_use_hash' => true,
            'id_form' => 'tadcka_address_form',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'tadcka_address';
    }
}
