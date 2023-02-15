<?php

namespace Admingenerator\FormExtensionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class LatLng extends Constraint
{
    public string $message = 'The values for latitude and longitude ("%lat%" and "%lng%") are not valid.';
}
