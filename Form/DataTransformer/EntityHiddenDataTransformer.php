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

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityHiddenDataTransformer implements DataTransformerInterface
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * @var string
     */
    protected $repositoryName;

    /**
     * Constructor.
     *
     * @param RegistryInterface $doctrine
     * @param string $repositoryName
     */
    public function __construct(RegistryInterface $doctrine, $repositoryName)
    {
        $this->doctrine = $doctrine;
        $this->repositoryName = $repositoryName;
    }

    /**
     * Transform.
     *
     * @param mixed $object
     *
     * @return int|null
     */
    public function transform($object)
    {
        if (null !== $object) {
            return $object->getId();
        }

        return null;
    }

    /**
     * Reverse transform.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function reverseTransform($id)
    {
        if (null === $id) {
            return null;
        }

        $object = $this->doctrine->getRepository($this->repositoryName)->find($id);

        if (null === $object) {
            throw new TransformationFailedException();
        }

        return $object;
    }
}
