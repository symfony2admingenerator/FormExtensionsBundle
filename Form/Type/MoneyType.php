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
        return 'money';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 's2a_money';
    }
}
