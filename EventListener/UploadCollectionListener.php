<?php
namespace Admingenerator\FormExtensionsBundle\EventListener;

use Admingenerator\FormExtensionsBundle\Storage\FileStorageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class UploadCollectionListener implements EventSubscriberInterface
{
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\EventDispatcher\EventSubscriberInterface::getSubscribedEvents()
     */
    public static function getSubscribedEvents()
    {
        return array(KernelEvents::REQUEST => 'onRequestHandler');
    }

    /**
     * @var FileStorageInterface
     */
    protected $storage;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @param FileStorageInterface      $storage
     * @param string                    $routeName
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function __construct(FileStorageInterface $storage, $routeName, PropertyAccessorInterface $propertyAccessor)
    {
        $this->storage = $storage;
        $this->routeName = $routeName;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @param GetResponseEvent $event
     * @return GetResponseEvent
     */
    public function onRequestHandler(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->get('_route') == $this->routeName) {
            if ($request->getMethod()=='POST') {
                if (!$propertyPath = $request->request->get('propertyPath')) {
                    throw new NotFoundHttpException();
                }

                $files = $this->propertyAccessor->getValue($request->files->all(), $this->fixPropertyPath($propertyPath));
                $files = $this->formatResponse($this->storage->storeFiles($files));
                $event->setResponse(new JsonResponse($files));
            } else {
                // We can avoid that if we force the method in the route declaration
                throw new NotFoundHttpException();
            }
        }

        return $event;
    }

    /**
     * @param string $propertyPath
     * @return string
     */
    private function fixPropertyPath($propertyPath)
    {
        if ($propertyPath[0] != '[') {
            $propertyPath = '[' . substr_replace($propertyPath, ']', strpos($propertyPath, '[')?:strlen($propertyPath), 0);
        }

        return str_replace('[]', '', $propertyPath);
    }

    /**
     * @param array $files
     * @return \stdClass
     */
    private function formatResponse(array $files)
    {
        $formatedResponse = new \stdClass();
        $formatedResponse->files = $files;

        return $formatedResponse;
    }
}
