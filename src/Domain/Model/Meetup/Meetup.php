<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;

class Meetup
{
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
    private $rsvps = [];

    private function __construct(
        MeetupId $meetupId,
        UserId $organiserId,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor)
    {
        $this->workingTitle = $workingTitle;
        $this->meetupId = $meetupId;
        $this->userId = $organiserId;
        $this->meetupGroupId = $meetupGroupId;
        $this->scheduledFor = $scheduledFor;

        $this->rsvps[] = Rsvp::rsvpYes($organiserId, $meetupId);
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
