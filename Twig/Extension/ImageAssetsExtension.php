<?php

namespace Admingenerator\FormExtensionsBundle\Twig\Extension;

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
    protected $uploaderExtension;

    protected $filterExtension;

    public function __construct($uploaderExtension, $filterExtension)
    {
        $this->uploaderExtension = $uploaderExtension;
        $this->filterExtension = $filterExtension;
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

        if ($this->uploaderExtension instanceof \Vich\UploaderBundle\Templating\Helper\UploaderHelper
            || $this->uploaderExtension instanceof \Vich\UploaderBundle\Twig\Extension\UploaderExtension) {
            return call_user_func_array(array($this->uploaderExtension, "asset"), $params);
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

        if (($this->filterExtension instanceof \Liip\ImagineBundle\Templating\ImagineExtension)
            || ($this->filterExtension instanceof \Liip\ImagineBundle\Templating\FilterExtension)) {

            return call_user_func_array(array($this->filterExtension, "filter"), $params);
        }

        if ($this->filterExtension instanceof \Avalanche\Bundle\ImagineBundle\Templating\ImagineExtension) {

            return call_user_func_array(array($this->filterExtension, "applyFilter"), $params);
        }

        // In case no image manipulator is used we
        // return the unmodified path
        return $path;
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
