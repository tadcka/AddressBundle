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

use Tadcka\AddressBundle\Form\DataTransformer\CountryChoiceDataTransformer;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CountryChoiceFormType extends AbstractType
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var string
     */
    private $locale;

    public function __construct($doctrine, $locale = 'en')
    {
        $this->doctrine = $doctrine;
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new CountryChoiceDataTransformer($this->doctrine);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'TadckaAddressBundle',
            'label' => 'form.address.country',
            'label_attr' => array(
                'class' => 'label_form'
            ),
            'choices' => $this->getCountries(),
            'attr' => array('class' => 'select_16 select2'),
            'empty_value' => 'form.country_choice.empty_value',
        ));
    }

    /**
     * Get countries
     *
     * @return array
     */
    private function getCountries()
    {
        return $this->doctrine->getRepository('TadckaAddressBundle:CountryTranslation')
                                                                    ->getCountriesToDropDown($this->locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'tadcka_address_country_choice';
    }
}