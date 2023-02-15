<?php

namespace Admingenerator\FormExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

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
class ImageAssetsExtension extends AbstractExtension
{

    public function __construct(protected readonly mixed $uploaderExtension, protected readonly mixed $filterExtension)
    {
    }

    public function getFunctions(): array
    {
        return [
            'image_asset'   =>  new TwigFunction('image_asset', $this->asset(...)),
        ];
    }

    public function getFilters(): array
    {
        return [
            'image_filter'  =>  new TwigFilter('image_filter', $this->filter(...)),
        ];
    }

    /**
     * Gets the browser path for the image and filter to apply.
     *
     * @return string The public path.
     */
    public function asset(object $object, string $field): string
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
     */
    public function filter(): string
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

    public function getName(): string
    {
        return 'admingenerator.twig.extension.image_filter';
    }
}
