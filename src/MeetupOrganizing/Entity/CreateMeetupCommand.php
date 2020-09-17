<?php declare(strict_types=1);

namespace MeetupOrganizing\Entity;

class CreateMeetupCommand
{
    /** @var int */
    private $organizerId;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $scheduledFor;

    /** @var int */
    private $wasCancelled;

    public function __construct(int $organizerId, string $name, string $description, string $scheduledFor, int $wasCancelled = 0)
    {
        $this->organizerId = $organizerId;
        $this->name = $name;
        $this->description = $description;
        $this->scheduledFor = $scheduledFor;
        $this->wasCancelled = $wasCancelled;
    }

    /**
     * @return int
     */
    public function getOrganizerId(): int
    {
        return $this->organizerId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getScheduledFor(): string
    {
        return $this->scheduledFor;
    }

    /**
     * @return int
     */
    public function getWasCancelled(): int
    {
        return $this->wasCancelled;
    }
}
