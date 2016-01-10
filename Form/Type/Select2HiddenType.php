<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

/**
 * See `Resources/doc/select2/overview.md` for documentation
 *
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */

// TODO: what the aim of this formType???
class Select2HiddenType extends Select2Type
{
    public function __construct()
    {
        parent::__construct('hidden', 'Symfony\Component\Form\Extension\Core\Type\HiddenType');
    }
}
