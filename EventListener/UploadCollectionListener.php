<?php
namespace Admingenerator\FormExtensionsBundle\EventListener;

use Admingenerator\FormExtensionsBundle\Storage\FileStorageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class UploadCollectionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onRequestHandler'];
    }

    public function __construct(
        protected readonly FileStorageInterface $storage,
        protected readonly string $routeName,
        protected readonly PropertyAccessorInterface $propertyAccessor
    )
    {
    }

    public function onRequestHandler(RequestEvent $event): RequestEvent
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

    private function fixPropertyPath(string $propertyPath): string
    {
        if ($propertyPath[0] != '[') {
            $propertyPath = '[' . substr_replace($propertyPath, ']', strpos($propertyPath, '[')?:strlen($propertyPath), 0);
        }

        return str_replace('[]', '', $propertyPath);
    }

    private function formatResponse(array $files): \stdClass
    {
        $formattedResponse = new \stdClass();
        $formattedResponse->files = $files;

        return $formattedResponse;
    }
}
