<?php declare(strict_types=1);

namespace MeetupOrganizing\Entity;

interface ListMeetupsRepositoryInterface
{
    public function listUpcomingMeetups(): MeetupForList;
    public function listPastMeetups(): MeetupForList;
}
