<?php declare(strict_types=1);

namespace MeetupOrganizing\Entity;

class MeetupForList
{
    /** @var Meetup[] */
    private $items = [];

    public function add(Meetup $meetUp): void
    {
        $this->items[] = $meetUp;
    }

   public function getForView(): array
   {
        $result = [];

        foreach ($this->items as $meetup)
        {
            $result[] =  [
                'meetupId' => $meetup->getId(),
                'name' => $meetup->getName(),
                'description' => $meetup->getDescription(),
                'scheduledFor' => $meetup->getScheduledFor()->asString(),
            ];
        }

        return $result;
    }
}
