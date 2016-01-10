<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * See `Resources/doc/bootstrap-money/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class MoneyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\MoneyType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 's2a_money';
    }
}
