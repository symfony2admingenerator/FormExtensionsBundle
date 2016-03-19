<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

/**
 * See `Resources/doc/bootstrap-collection/overview.md` for documentation
 *
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class BootstrapFieldsetCollectionType extends BootstrapCollectionType
{
    public function __construct()
    {
        parent::__construct('fieldset');
    }
}
