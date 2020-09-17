<?php declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Assert\Assert;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use PDO;

class MeetupRepository implements MeetupRepositoryInterface, ListMeetupsRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Meetup $meetUp): int
    {
        $this->connection->insert(
            'meetups',
            $meetUp->getData()
        );

        return (int)$this->connection->lastInsertId();
    }

    public function listUpcomingMeetups(): MeetupForList
    {
        $now = new DateTimeImmutable();

        $statement = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetups')
            ->where('scheduledFor >= :now')
            ->setParameter('now', $now->format(ScheduledDate::DATE_TIME_FORMAT))
            ->andWhere('wasCancelled = :wasNotCancelled')
            ->setParameter('wasNotCancelled', 0)
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        return $this->mapMeetupList($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function listPastMeetups(): MeetupForList
    {
        $now = new DateTimeImmutable();
        $statement = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetups')
            ->where('scheduledFor < :now')
            ->setParameter('now', $now->format(ScheduledDate::DATE_TIME_FORMAT))
            ->andWhere('wasCancelled = :wasNotCancelled')
            ->setParameter('wasNotCancelled', 0)
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        return $this->mapMeetupList($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    private function mapMeetupList(array $result): MeetupForList
    {
        $meetUpForList = new MeetupForList();
        foreach ($result as $rawMeetup) {
            $meetUpForList->add(Meetup::FromDatabase($rawMeetup));
        }

        return $meetUpForList;
    }
}
