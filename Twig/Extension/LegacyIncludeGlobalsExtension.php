<?php

namespace Admingenerator\FormExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * This extension adds global variables based on bundles configuration. Only for Twig 1 and 2.
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class LegacyIncludeGlobalsExtension extends AbstractExtension implements GlobalsInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
            's2a_formextensions_include_jquery'     => $this->container->getParameter('admingenerator.form.include_jquery'),
            's2a_formextensions_include_jqueryui'   => $this->container->getParameter('admingenerator.form.include_jqueryui'),
            's2a_formextensions_include_momentjs'   => $this->container->getParameter('admingenerator.form.include_momentjs'),
            's2a_formextensions_include_blueimp'    => $this->container->getParameter('admingenerator.form.include_blueimp'),
            's2a_formextensions_include_gmaps'      => $this->container->getParameter('admingenerator.form.include_gmaps'),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'admingenerator.twig.extension.include_globals';
    }
}
