<?php

declare(strict_types=1);

namespace IWantSomeFood\Model;

final class Meal extends \Prooph\EventSourcing\AggregateRoot
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    protected function aggregateId(): string
    {
        return $this->id;
    }

    /**
     * Apply given event
     *
     * @param \Prooph\EventSourcing\AggregateChanged|\IWantSomeFood\Model\Event\MealAdded|\IWantSomeFood\Model\Event\MealTitleChanged $event
     */
    protected function apply(\Prooph\EventSourcing\AggregateChanged $event): void
    {
        switch ($event->messageName()) {
            case \IWantSomeFood\Model\Event\MealAdded::class:
                $this->id = $event->id();
                $this->title = $event->title();
                break;
            case \IWantSomeFood\Model\Event\MealTitleChanged::class:
                $this->title = $event->title();
                break;
        }
    }

    public static function mealAdded(
        string $id,
        string $title
    ): self {
        $self = new self();

        $self->recordThat(
            \IWantSomeFood\Model\Event\MealAdded::occur(
                $id,
                [
                    'title' => $title
                ]
            )
        );

        return $self;
    }

    public function changeTitle(
        string $title
    ): void {
        if ($title === $this->title) {
            return;
        }
        $this->recordThat(
            \IWantSomeFood\Model\Event\MealTitleChanged::occur(
                $this->aggregateId(),
                [
                    'title' => $title,
                ]
            )
        );
    }
}
