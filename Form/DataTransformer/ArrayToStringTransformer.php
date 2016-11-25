<?php

namespace Pintushi\Bundle\SMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class ArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (empty($value)) {
            return null;
        }
        if (is_scalar($value)) {
            return [
                'phoneNumber' => $value,
                'verificationCode' => null
            ];
        }
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
        if (!isset($value['phoneNumber'])) {
            return;
        }

        return $value['phoneNumber'];
    }
}
