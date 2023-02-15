<?php

namespace Admingenerator\FormExtensionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class LatLngValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): bool
    {
        if (!($constraint instanceof LatLng)) {
            throw new InvalidArgumentException(sprintf('Expected %s, got %s', LatLng::class, $constraint::class));
        }
        if (!preg_match('/^[0-9\-\.]+$/', $value['lat'], $matches) || !preg_match('/^[0-9\-\.]+$/', $value['lng'], $matches)) {
            $this->context->addViolation($constraint->message, ['%lat%' => (float)$value['lat'], '%lng%' => (float)$value['lng']]);
            return false;
        }
        if ($value['lat'] > 90 || $value['lat'] < -90 || $value['lng'] > 180 || $value['lng'] < -180) {
            $this->context->addViolation($constraint->message, ['%lat%' => (float)$value['lat'], '%lng%' => (float)$value['lng']]);
            return false;
        }
        return true;
    }
}
