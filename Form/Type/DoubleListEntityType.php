<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

/**
 * See `Resources/doc/double-list/overview.md` for documentation
 *
 * @author Stéphane Escandell <stephane.escandell@gmail.com>
 */
class DoubleListEntityType extends DoubleListType
{
    public function __construct()
    {
        parent::__construct('entity', 'Symfony\Bridge\Doctrine\Form\Type\EntityType');
    }
}
