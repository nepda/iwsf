<?php

declare(strict_types=1);

namespace IWantSomeFoodTest\Model;

class MealTest extends \IWantSomeFoodTest\TestCase
{
    /**
     * @var string
     */
    private $mealId;

    /**
     * @var string
     */
    private $mealTitle;
    /**
     * @var string
     */
    private $mealId2;

    /**
     * @var string
     */
    private $mealTitle2;

    protected function setUp()
    {
        $this->mealId = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->mealTitle = 'Pizza mushroom';

        $this->mealId2 = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->mealTitle2 = 'Pizza mushroom2';
    }

    private function reconstituteMealFromHistory(
        \Prooph\EventSourcing\AggregateChanged ...$events
    ): \IWantSomeFood\Model\Meal {
        return $this->reconstituteAggregateFromHistory(\IWantSomeFood\Model\Meal::class, $events);
    }

    private function mealAdded(): \IWantSomeFood\Model\Event\MealAdded
    {
        return \IWantSomeFood\Model\Event\MealAdded::occur(
            $this->mealId,
            [
                'title' => $this->mealTitle,
            ]
        );
    }

    public function testMealWasAdded()
    {
        $meal = \IWantSomeFood\Model\Meal::mealAdded(
            $this->mealId,
            $this->mealTitle
        );

        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events = $this->popRecordEvents($meal);

        $this->assertCount(1, $events);

        /** @var \IWantSomeFood\Model\Event\MealAdded $event */
        $event = $events[0];

        $this->assertSame(\IWantSomeFood\Model\Event\MealAdded::class, $event->messageName());
        $this->assertSame($this->mealId, $event->id());
        $this->assertSame($this->mealTitle, $event->title());
    }

    public function testMealWasAddedTwice()
    {
        $meal = \IWantSomeFood\Model\Meal::mealAdded(
            $this->mealId,
            $this->mealTitle
        );

        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events = $this->popRecordEvents($meal);

        $this->assertCount(1, $events);

        /** @var \IWantSomeFood\Model\Event\MealAdded $event */
        $event = $events[0];

        $this->assertSame(\IWantSomeFood\Model\Event\MealAdded::class, $event->messageName());
        $this->assertSame($this->mealId, $event->id());
        $this->assertSame($this->mealTitle, $event->title());


        $meal2 = \IWantSomeFood\Model\Meal::mealAdded(
            $this->mealId2,
            $this->mealTitle2
        );

        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events2 = $this->popRecordEvents($meal2);

        $this->assertCount(1, $events2);

        /** @var \IWantSomeFood\Model\Event\MealAdded $event2 */
        $event2 = $events2[0];

        $this->assertNotSame($event, $event2);

        $this->assertSame(\IWantSomeFood\Model\Event\MealAdded::class, $event2->messageName());
        $this->assertSame($this->mealId2, $event2->id());
        $this->assertSame($this->mealTitle2, $event2->title());
    }

    public function testMealTitleChanged()
    {
        $meal = $this->reconstituteMealFromHistory(
            $this->mealAdded()
        );

        $meal->changeTitle('Super duper mushroom pizza');


        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events = $this->popRecordEvents($meal);

        $this->assertCount(1, $events);

        /** @var \IWantSomeFood\Model\Event\MealTitleChanged $event */
        $event = $events[0];

        $this->assertSame(\IWantSomeFood\Model\Event\MealTitleChanged::class, $event->messageName());
        $this->assertSame($this->mealId, $event->id());
        $this->assertSame('Super duper mushroom pizza', $event->title());
    }

    public function testNothingHappensWhenNotChangingTitle()
    {
        $meal = $this->reconstituteMealFromHistory(
            $this->mealAdded()
        );

        $meal->changeTitle($this->mealTitle);

        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events = $this->popRecordEvents($meal);

        $this->assertCount(0, $events);
    }
}
