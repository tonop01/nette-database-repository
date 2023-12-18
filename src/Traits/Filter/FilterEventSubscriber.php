<?php

namespace Efabrica\NetteRepository\Traits\Filter;

use Efabrica\NetteRepository\Event\RepositoryEvent;
use Efabrica\NetteRepository\Event\SelectQueryEvent;
use Efabrica\NetteRepository\Event\SelectQueryResponse;
use Efabrica\NetteRepository\Subscriber\EventSubscriber;

final class FilterEventSubscriber extends EventSubscriber
{
    public function supportsEvent(RepositoryEvent $event): bool
    {
        return $event->hasBehavior(FilterBehaviorInterface::class);
    }

    public function onSelect(SelectQueryEvent $event): SelectQueryResponse
    {
        foreach ($event->getBehaviors()->all() as $behavior) {
            if ($behavior instanceof FilterBehaviorInterface) {
                $behavior->applyFilter($event->getQuery());
            }
        }
        return $event->handle();
    }
}
