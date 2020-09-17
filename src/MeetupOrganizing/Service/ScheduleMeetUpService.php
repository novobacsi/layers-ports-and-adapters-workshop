<?php declare(strict_types=1);

namespace MeetupOrganizing\Service;

use MeetupOrganizing\Entity\CreateMeetupCommand;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepositoryInterface;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;

class ScheduleMeetUpService
{
    /** @var MeetupRepositoryInterface */
    private $repository;

    public function __construct(MeetupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(CreateMeetupCommand $createCommand): int
    {
        $meetUp = new Meetup(
            UserId::fromInt($createCommand->getOrganizerId()),
            $createCommand->getName(),
            $createCommand->getDescription(),
            ScheduledDate::fromString($createCommand->getScheduledFor()),
            $createCommand->getWasCancelled()
        );

        return $this->repository->save($meetUp);
    }
}
