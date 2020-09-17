<?php declare(strict_types=1);

namespace MeetupOrganizing\Entity;

interface MeetupRepositoryInterface
{
    public function save(Meetup $meetUp): int;
}
