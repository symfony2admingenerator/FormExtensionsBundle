<?php

namespace Admingenerator\FormExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * This extension adds common twig function for various upload manager 
 * bundles and common twig filter image manipulation bundles. 
 * 
 * Depending on %admingenerator.form.upload_manager% setting a diffrent 
 * upload manager bundle is used.
 * 
 * Depending on %admingenerator.form.image_manipulator% setting a diffrent 
 * image manipulation bundle is used.
 * 
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class ImageAssetsExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'image_asset'   =>  new \Twig_SimpleFunction('image_asset', array($this, 'asset')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'image_filter'  =>  new \Twig_SimpleFilter('image_filter', array($this, 'filter')),
        );
    }
    
    /**
     * Gets the browser path for the image and filter to apply.
     *
     * @return string The public path.
     */
    public function asset($object, $field)
    {
        $params = func_get_args();
        
        if ('vich_uploader' === $this->getUploadManager()) {
            // Note: requires v0.13.0 or higher
            $ext = new \Vich\UploaderBundle\Twig\Extension\UploaderExtension(
                $this->container->get('vich_uploader.templating.helper.uploader_helper')  
            );
            
            return call_user_func_array(array($ext, "asset"), $params);
        }
        
        // In case no upload manager is used we expect object to have
        // a special method returning file's path
        $getter = "get".Container::Camelize($field)."WebPath";
            
        return $object->$getter();
    }

    /**
     * Gets the browser path for the image and filter to apply
     *
     * @return string
     */
    public function filter()
    {
        $params = func_get_args();
        $path = $params[0];
        
        if ('liip_imagine' === $this->getImageManipulator()) {
            $ext = new \Liip\ImagineBundle\Templating\ImagineExtension(
                $this->container->get('liip_imagine.cache.manager')
            );
            
            return call_user_func_array(array($ext, "filter"), $params);
        }
        
        if ('avalanche_imagine' === $this->getImageManipulator()) {
            $ext = new \Avalanche\Bundle\ImagineBundle\Templating\ImagineExtension(
                $this->container->get('imagine.cache.path.resolver')
            );
            
            return call_user_func_array(array($ext, "applyFilter"), $params);
        }
        
        // In case no image manipulator is used we
        // return the unmodified path
        return $path;
    }

    /**
     * Get upload manager name
     *
     * @return string|null Parameter value
     */
    public function getUploadManager()
    {
        return $this->container->getParameter('admingenerator.form.upload_manager');
    }

    /**
     * Get image manipulator name
     *
     * @return string|null Parameter value
     */
    public function getImageManipulator()
    {
        return $this->container->getParameter('admingenerator.form.image_manipulator');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'admingenerator.twig.extension.image_filter';
    }
}
