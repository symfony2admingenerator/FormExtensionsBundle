<?php

namespace Admingenerator\FormExtensionsBundle;

use Admingenerator\FormExtensionsBundle\DependencyInjection\Compiler\FormCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Form extensions for Symfony2 Admingenerator project
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class AdmingeneratorFormExtensionsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormCompilerPass());
    }
}