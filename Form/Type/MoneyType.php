<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType as SymfonyMoneyType;

/**
 * See `Resources/doc/bootstrap-money/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class MoneyType extends AbstractType
{
    public function getParent(): string
    {
        return SymfonyMoneyType::class;
    }

    public function getBlockPrefix(): string
    {
        return 's2a_money';
    }
}
