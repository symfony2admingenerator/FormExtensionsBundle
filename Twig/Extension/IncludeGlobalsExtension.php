<?php

namespace Admingenerator\FormExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * This extension adds global variables based on bundles configuration. For Twig 3 and higher.
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class IncludeGlobalsExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(protected readonly ContainerInterface $container)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals(): array
    {
        return [
            's2a_formextensions_include_jquery'   => $this->container->getParameter('admingenerator.form.include_jquery'),
            's2a_formextensions_include_jqueryui' => $this->container->getParameter('admingenerator.form.include_jqueryui'),
            's2a_formextensions_include_momentjs' => $this->container->getParameter('admingenerator.form.include_momentjs'),
            's2a_formextensions_include_blueimp'  => $this->container->getParameter('admingenerator.form.include_blueimp'),
            's2a_formextensions_include_gmaps'    => $this->container->getParameter('admingenerator.form.include_gmaps'),
        ];
    }

    public function getName(): string
    {
        return 'admingenerator.twig.extension.include_globals';
    }
}
