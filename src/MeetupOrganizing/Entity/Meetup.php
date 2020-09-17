<?php declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Assert\Assert;

class Meetup
{
    /** @var int|null */
    private $id;

    /** @var UserId */
    private $organizerId;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var ScheduledDate */
    private $scheduledFor;

    /** @var int */
    private $wasCancelled;

    /**
     * @param UserId $organizerId
     * @param string $name
     * @param string $description
     * @param ScheduledDate $scheduledFor
     * @param int $wasCancelled
     */
    public function __construct(UserId $organizerId, string $name, string $description, ScheduledDate $scheduledFor, int $wasCancelled = 0)
    {
        Assert::that($name)->notEmpty('name cannot be empty');
        Assert::that($description)->notEmpty('description cannot be empty');

        $this->organizerId = $organizerId;
        $this->name = $name;
        $this->description = $description;
        $this->scheduledFor = $scheduledFor;
        $this->wasCancelled = $wasCancelled;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public static function fromDatabase(array $rawMeetup): self
    {
        $meetup = new self(
            UserId::fromInt((int)$rawMeetup['organizerId']),
            $rawMeetup['name'],
            $rawMeetup['description'],
            ScheduledDate::fromString($rawMeetup['scheduledFor']),
            (int)$rawMeetup['wasCancelled'],
        );

        return $meetup->setId((int)$rawMeetup['meetupId']);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getScheduledFor(): ScheduledDate
    {
        return $this->scheduledFor;
    }

    public function getData(): array
    {
        return [
            'organizerId' => $this->organizerId->asInt(),
            'name' => $this->name,
            'description' => $this->description,
            'scheduledFor' => $this->scheduledFor->asString(),
            'wasCancelled' => $this->wasCancelled,
        ];
    }
}
