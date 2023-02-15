<?php

namespace Admingenerator\FormExtensionsBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class ReorderCollectionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => ['preSubmit', 140],
        ];
    }

    public function preSubmit(FormEvent $event): void
    {
        $data = $event->getData();

        if (is_array($data)) {
            $event->setData(array_values($data));
        }
    }
}
