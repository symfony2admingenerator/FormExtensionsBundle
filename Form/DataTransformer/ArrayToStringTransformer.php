<?php

namespace Admingenerator\FormExtensionsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * {@inheritdoc}
 *
 * @author Bilal Amarni <bilal.amarni@gmail.com>
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class ArrayToStringTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly string $separator = ',',
        private readonly array $keys = []
    )
    {
    }

    /**
     * Transforms an array to a string
     */
    public function transform(mixed $value): string
    {
        if (null === $value) {
            return '';
        }

        if (!is_array($value)) {
            throw new TransformationFailedException('Expected an array');
        }

        $value = array_filter(array_values($value), 'strlen');

        return empty($value) ? '' : implode($this->separator, $value);
    }

    /**
     * Transforms a string to an array
     */
    public function reverseTransform(mixed $value): array
    {
        if (!is_string($value)) {
            throw new TransformationFailedException('Expected a string');
        }

        if ( 0 === strlen($value)) {
            return [];
        }

        $transformedString = explode($this->separator, $value);

        if (!empty($this->keys)) {
            if (count($this->keys) != count($transformedString)) {
                throw new TransformationFailedException('Invalid value format.');
            }

            return array_combine($this->keys, $transformedString);
        }

        return $transformedString;
    }
}
