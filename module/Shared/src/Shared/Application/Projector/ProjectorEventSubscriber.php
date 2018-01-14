<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 16:06
 */

namespace Shared\Application\Projector;



use Shared\Application\Event\Event;
use Shared\Application\Event\Subscriber\EventSubscriber;
use Shared\Application\Projector\Projection\ProjectionInterface;

class ProjectorEventSubscriber implements EventSubscriber
{
    /**
     * @var \Shared\Application\Projector\Projection\ProjectionInterface[]
     */
    private $projections;

    /**
     * Projector constructor.
     *
     * @param \Shared\Application\Projector\Projection\ProjectionInterface[] ...$projections
     */
    public function __construct(ProjectionInterface ...$projections)
    {
        $this->projections = $projections;
    }

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        foreach ($this->projections as $projection) {
            if (TRUE === $projection->isSubscribedTo($event)) {
                $projection->project($event);
            }
        }
    }

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool
    {
        foreach ($this->projections as $projection) {
            if (TRUE === $projection->isSubscribedTo($event)) {
                return TRUE;
            }
        }

        return FALSE;
    }
}