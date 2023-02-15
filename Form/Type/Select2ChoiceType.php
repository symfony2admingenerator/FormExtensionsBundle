<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * See `Resources/doc/select2/overview.md` for documentation
 *
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class Select2ChoiceType extends Select2Type
{
    public function __construct()
    {
        parent::__construct('choice', ChoiceType::class);
    }
}
