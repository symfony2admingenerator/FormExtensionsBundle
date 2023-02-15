<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\LocaleType;

/**
 * See `Resources/doc/select2/overview.md` for documentation
 *
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class Select2LocaleType extends Select2Type
{
    public function __construct()
    {
        parent::__construct('locale', LocaleType::class);
    }
}
