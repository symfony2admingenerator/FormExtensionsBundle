<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

/**
 * See `Resources/doc/select2/overview.md` for documentation
 *
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class Select2LanguageType extends Select2Type
{
    public function __construct()
    {
        parent::__construct('language', 'Symfony\Component\Form\Extension\Core\Type\LanguageType');
    }
}
