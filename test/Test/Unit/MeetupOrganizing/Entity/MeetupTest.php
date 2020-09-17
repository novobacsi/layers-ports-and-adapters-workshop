<?php declare(strict_types=1);

namespace Test\Unit\MeetupOrganizing\Entity;

use InvalidArgumentException;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;
use PHPUnit\Framework\TestCase;

class MeetupTest extends TestCase
{
    /**
     * @dataProvider invalidParameterDataProvider
     *
     * @param int $organizerId
     * @param string $name
     * @param string $description
     * @param string $scheduledFor
     * @param int $wasCancelled
     * @param string $expectedErrorMessage
     */
    public function testThrowsExceptionForInvalidParameters(
        int $organizerId,
        string $name,
        string $description,
        string $scheduledFor,
        int $wasCancelled,
        string $expectedErrorMessage
    ): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedErrorMessage);
        new Meetup(
            UserId::fromInt($organizerId),
            $name,
            $description,
            ScheduledDate::fromString($scheduledFor),
            $wasCancelled
        );

    }

    public function invalidParameterDataProvider(): array
    {
        return [
            [
                'organizerId' => 1,
                'name' => '',
                'description' => 'desc',
                'scheduledFor' => '2030-01-01 11:11',
                'wasCancelled' => 0,
                'expectedErrorMessage' => 'name cannot be empty',
            ],
            [
                'organizerId' => 1,
                'name' => 'name',
                'description' => '',
                'scheduledFor' => '2030-01-01 11:11',
                'wasCancelled' => 0,
                'expectedErrorMessage' => 'description cannot be empty',
            ],
        ];

    }
}
