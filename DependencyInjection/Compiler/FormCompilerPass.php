<?php

namespace Admingenerator\FormExtensionsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Processes twig configuration
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class FormCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        // Used templates
        $templates = ['@AdmingeneratorFormExtensions/Form/form_html.html.twig',
            '@AdmingeneratorFormExtensions/Form/form_js.html.twig',
            '@AdmingeneratorFormExtensions/Form/form_css.html.twig'];

        if (($twigConfiguration = $container->getParameter('admingenerator.form.twig')) !== false) {
            $resources = $container->getParameter('twig.form.resources');
            $alreadyImported = count(array_intersect($resources, $templates)) == count($templates);

            if ($twigConfiguration['use_form_resources'] && !$alreadyImported) {
                if (($key = array_search('bootstrap_3_layout.html.twig', $resources)) !== false) {
                    // Insert right after bootstrap_3_layout.html.twig if exists
                    array_splice($resources, ++$key, 0, $templates);
                } else if (($key = array_search('form_div_layout.html.twig', $resources)) !== false) {
                    // Insert right after form_div_layout.html.twig if exists
                    array_splice($resources, ++$key, 0, $templates);
                } else {
                    // Put it in first position
                    array_unshift($resources, $templates);
                }

                $container->setParameter('twig.form.resources', $resources);
            }
        }
    }
}
