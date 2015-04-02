<?php

namespace Admingenerator\GeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AssetsCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $twigGlobals = $container->getParameter('twig.globals');
        $container->setParameter('twig.globals', array_merge($twigGlobals, array(
            's2a_formextensions_include_jquery'   => $container->getParameter('admingenerator_form_extensions.include_jquery'),
            's2a_formextensions_include_jqueryui' => $container->getParameter('admingenerator_form_extensions.include_jqueryui'),
        )));
    }
}
