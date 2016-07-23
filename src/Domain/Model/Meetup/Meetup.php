<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;
use Infrastructure\DomainEvents\DomainEventRecordingCapabilities;
use Infrastructure\DomainEvents\RecordsDomainEvents;

class Meetup implements RecordsDomainEvents
{
    use DomainEventRecordingCapabilities;

    private $workingTitle;
    /**
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var MeetupGroupId
     */
    private $meetupGroupId;
    /**
     * @var \DateTimeImmutable
     */
    private $scheduledFor;

    private function __construct(
        MeetupId $meetupId,
        UserId $organiserId,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) {
        $this->workingTitle = $workingTitle;
        $this->meetupId = $meetupId;
        $this->userId = $organiserId;
        $this->meetupGroupId = $meetupGroupId;
        $this->scheduledFor = $scheduledFor;

        $meetupWasScheduled = new MeetupScheduled(
            $meetupId,
            $organiserId,
            $meetupGroupId,
            $workingTitle,
            $scheduledFor
        );

        $this->recordThat($meetupWasScheduled);
    }

    public static function schedule(
        MeetupId $meetupId,
        UserId $userId,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) {
        return new self(
            $meetupId,
            $userId,
            $meetupGroupId,
            $workingTitle,
            $scheduledFor
        );
    }
}
